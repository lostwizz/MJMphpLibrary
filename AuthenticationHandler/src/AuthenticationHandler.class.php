<?php declare(strict_types=1);

namespace MJMphpLibrary\AuthenticationHandler;


use MJMphpLibrary\AuthenticationHandler\Data_AuthenticateUserDetailsTable;
use MJMphpLibrary\AuthenticationHandler\Display_AuthenticationHandler;
use MJMphpLibrary\AuthenticationHandler\AuthenticationDBmethod;
use MJMphpLibrary\AuthenticationHandler\AuthenticationGuestMethod;
use MJMphpLibrary\AuthenticationHandler\AuthenticationHardCodedMethod;
use MJMphpLibrary\AuthenticationHandler\AuthenticationLDAPmethod;
use MJMphpLibrary\AuthenticationHandler\AuthenticationUnEncryptedPWDmethod;

//define( 'MyDIR', realpath('.') );


class AuthenticationHandler {

	const AUTH_TIMEOUTSECONDS = 18000;
	const AUTH_NONE = 0;
	const AUTH_FAILED_LOGON = -1;
	const AUTH_FORGOT_PASSWORD = -2;
	const AUTH_CHANGING_PASSWORD = -3;
	const AUTH_CHANGED_TO_NEWPASSWORD = -4;
	const AUTH_CHANGED_USING_BAD_OLDPASSWORD = -5;
	const AUTH_SIGNUP = -6;
	const AUTH_REMOVING_USER = -7;
	const AUTH_REMOVED_USER = -8;
	const AUTH_LOGGED_OFF = -9;
	const AUTH_ATTEMPTING_LOGON = -10;
	const AUTH_TIMEDOUT = -11;
	const AUTH_LOGGED_ON = 9999;

	protected $appName;
	protected $userName;
	protected $currentStatus = self::AUTH_NONE;
	protected $currentUserDetails;
	protected $loginTime;
	protected $lastActivityTime;
	protected $currentLogonMethod;
	protected $currentLogonMethodObject;
	protected $LogonMethods = [];
	protected $app;
	private $DB_Username = 'Mikes_DBLogging_User';
	private $DB_Password = 'DonaldDuck96';
	private $DB_Type = 'sqlsrv';
	private $DB_Server = 'vm-db-prd4';
	private $DB_Database = 'Mikes_Application_Store';
	private $DB_DSN = 'sqlsrv:server=vm-db-prd4;database=Mikes_Application_Store';
	private $DB_DSN_OPTIONS = array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
		\PDO::ATTR_CASE => \PDO::CASE_UPPER,
		\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
			//PDO::ATTR_PERSISTENT => true
		);

	/**
	 * @var version string
	 */
	private const VERSION = '0.0.1';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $appName
	 */
	function __construct(string $appName) {
		$this->updateLastActivityTime(true);
		$this->app = $appName;
		$this->currentStatus = self::AUTH_NONE;
		$this->UserDetailsDB = new DATA_AuthenticateUserDetailsTable(
				$this->app,
				$this->DB_DSN,
				$this->DB_Username,
				$this->DB_Password,
				$this->DB_DSN_OPTIONS
			);
		$this->registerMethods();
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	protected function registerMethods() {
		$this->LogonMethods['DB_Table'] = new AuthenticationDBmethod();
		$this->LogonMethods['Guest'] = new AuthenticationGuestMethod();
		$this->LogonMethods['HARDCoded'] = new AuthenticationHardCodedMethod();
		$this->LogonMethods['LDAP'] = new AuthenticationLDAPmethod();
		$this->LogonMethods['UnEncrypted'] = new AuthenticationUnEncryptedPWDmethod();
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return array|null
	 */
	public function getRegisteredMethods(): ?array {
		$listOfMethods = [];
		foreach ($this->LogonMethods as $name => $aMethod) {
			$listOfMethods[] = $name;
		}
		return $listOfMethods;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param bool $setLoginTime
	 * @return void
	 */
	public function updateLastActivityTime(bool $setLoginTime = false): void {
		if (defined("IS_PHPUNIT_TESTING")) {
			$this->loginTime = 1575920000;
			$this->lastActivityTime = 1575920000 + 100;
		} else {
			if ($setLoginTime) {
				$this->loginTime = (new \DateTime('now'))->getTimestamp();
			}
			$this->lastActivityTime = (new \DateTime('now'))->getTimestamp();
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return bool
	 */
	public function hasTimedOut(): bool {
		if ($this->currentStatus == self::AUTH_LOGGED_ON) {
			$now = (new \DateTime('now'))->getTimestamp();
			$diff = $now - $this->lastActivityTime;
			if ($diff > self::AUTH_TIMEOUTSECONDS) {
				$this->currentStatus = self::AUTH_TIMEDOUT;
				return true;
			} else {
				return false;
			}
		} else {
			return true;  // if not logged on then effectively it has also timedout
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 * Status / Is Authenticated
	 * @return int
	 */
	public function status(): int {
		$this->updateLastActivityTime();
		return $this->currentStatus;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string|null $username
	 * @return bool
	 */
	protected function getUserDetailsFromDB(?string $username = null): bool {
		if (!empty($username)) {
			$this->currentUserDetails = $this->UserDetailsDB->readUserDetailsByName($username);
			if (!empty($this->currentUserDetails)) {
				$this->currentLogonMethodObject = $this->LogonMethods[$this->currentUserDetails['method']];
				return true;
			}
		}
		return false;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return string|null
	 */
	public function getLogonMethod(): ?string {
		$this->updateLastActivityTime();
		if ($this->currentStatus == self::AUTH_LOGGED_ON) {
			return $this->currentLogonMethod;
		} else {
			return null;
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $username
	 * @param string|null $password
	 * @return bool
	 */
	protected function checkPassword(string $username, ?string $password): bool {
		if ($this->currentLogonMethodObject->doesUserDetailsContainPassword()) {
			$isSucessfulLogOn = $this->currentLogonMethodObject->isValidPassword($password, $this->currentUserDetails['password']);
		} else {
			$isSucessfulLogOn = $this->currentLogonMethodObject->isValidPassword($username, $password);
		}
		return $isSucessfulLogOn;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $username
	 * @param string|null $password
	 * @return bool
	 */
	public function login(string $username, ?string $password = null): bool {
		// read user details from database
		// use the user details - logon_method to pick the registerd method
		//  pass everything to the registed method and let it say logon or not
		// then update the logintime and session_id in the user details table
		$this->currentStatus = self::AUTH_ATTEMPTING_LOGON;

		if ($this->getUserDetailsFromDB($username)) {
			if ($this->checkPassword($username, $password)) {
				$this->currentStatus = self::AUTH_LOGGED_ON;
				$this->updateLastActivityTime(true);
				return true;
			} else {
				$this->currentStatus = self::AUTH_FAILED_LOGON;
				return false;
			}
		} else {
			$this->currentStatus = self::AUTH_FAILED_LOGON;
			return false;
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return bool
	 */
	public function isLoggedOn(): bool {
		return ( $this->currentStatus == self::AUTH_LOGGED_ON);
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public function logout(): void {
		$this->currentStatus = self::AUTH_LOGGED_OFF;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return bool
	 */
	public function isAllowedToChangePassword(): bool {
		// using the registered method find out if it will allow a passwor change
		//   i.e. LDAP will not do a password change
		if ($this->isLoggedOn()) {
			if ((!empty($this->currentLogonMethodObject))) {
				return $this->currentLogonMethodObject->isAllowedToChangePassword();
			}
		}
		return false;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $oldPassword
	 * @param string $newPassword
	 * @return bool
	 */
	public function changePassword(string $oldPassword, string $newPassword): bool {
		// if allowed to change password then pass old and new to the registered method
		//    and let it handle the change
		if ($this->isLoggedOn() and $this->isAllowedToChangePassword()) {
			//verify oldpassword is correct
			if ($this->checkPassword($this->currentUserDetails['username'], $oldPassword)) {
				$this->currentStatus = self::AUTH_CHANGING_PASSWORD;
				$encrypedPWD = $this->currentLogonMethodObject->preSaveProcessPassword($newPassword);
				if ($this->UserDetailsDB->updateUserDetailsWithNewPassword( (int)$this->currentUserDetails['userid'], $encrypedPWD)) {
					$this->currentStatus = self::AUTH_CHANGED_TO_NEWPASSWORD;
					return true;
				}
			} else {
				$this->currentStatus = self::AUTH_CHANGED_USING_BAD_OLDPASSWORD;
			}
		}
		return false;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $username
	 * @param string $password
	 * @param string $method
	 * @param int $flags
	 * @return int
	 */
	public function signUp(string $username, string $password, string $method, int $flags): int {
		// create a row in the user details table
		//   dont give it any rights untils "someone" grants the "role"

		$newUserID =$this->UserDetailsDB->addUserDetailsNewUser( $username, $password, $method, $flags);
		$this->currentStatus = self::AUTH_SIGNUP;
		return $newUserID;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string|null $username
	 * @return bool
	 */
	public function isAllowedToForgetPassword( ?string $username = null): bool {
		// get the user details from the table/db
		// ask the registered method if they are allowed to forget the password
		//   probably same result as isAllowed to change password

		if ($this->getUserDetailsFromDB($username)) {
			return $this->currentLogonMethodObject->isAllowedToForgetPassword();
		} else {
			return false;
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $username
	 * @return string|null
	 */
	public function forgotPassword(string $username): ?string {
		// get the user details from the table/db
		// change the password to a random one
		//     and return the new password (for upstream to email it out
		$this->currentStatus = self::AUTH_FORGOT_PASSWORD;

		if ($this->getUserDetailsFromDB($username) AND $this->isAllowedToForgetPassword($username)) {

			$newRandomPassword = self::makeRandomPassword(12);
			$encrypedPWD = $this->currentLogonMethodObject->preSaveProcessPassword($newRandomPassword);
			if ($this->UserDetailsDB->updateUserDetailsWithNewPassword( $this->currentUserDetails['userid'], $encrypedPWD)) {
				return $newRandomPassword;
			}
		}
		return null;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param int $length
	 * @return string
	 */
	public static function makeRandomPassword(int $length = 10): string {
		$pass = "";
		$salt = "abchefghjkmnpqrstuvwxyz0123456789ABCHEFGHJKMNPQRSTUVWXYZ0123456789";
		srand((double) microtime() * 1000314);
		$i = 0;
		while ($i < $length) {
			$num = rand() % strlen($salt);
			$tmp = substr($salt, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		return $pass;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string|null $username
	 * @return bool
	 */
	public function doesUserDetailsContainPassword(?string $username = null): bool {
		//if the registered method save the password in the table/db
		//   only db authentication method does (LDAP no, HARDCODED no)
		//if yes then pass the submitted password and the password in thedb (encoded string)
		// if not then pass username and password
		$this->getUserDetailsFromDB($username);
		if (!empty($this->currentLogonMethodObject)) {
			return $this->currentLogonMethodObject->doesUserDetailsContainPassword();
		} else {
			return false;
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $username
	 * @return bool
	 */
	public function removeUser( string $username): bool {
		$this->getUserDetailsFromDB($username);

		$this->currentStatus = self::AUTH_REMOVING_USER;
		if ($this->getUserDetailsFromDB($username)) {
			$r = $this->UserDetailsDB->removeUserDetailsByUserID( $this->currentUserDetails['userid']);
			if ($r) {
				$this->currentStatus = self::	AUTH_REMOVED_USER;
				return true;
			}
		}
		$this->currentStatus = self::AUTH_NONE;
		return false;
	}


	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function showLogin() :void{
		$display = new Display_AuthenticationHandler( $this->app, true, true, true);
		$display->showLoginPage();
//		echo '<HR size=5>';
//		$display = new Display_AuthenticationHandler( $this->app, true, false, true);
//		$display->showLoginPage();
//		echo '<HR size=5>';
//		$display = new Display_AuthenticationHandler( $this->app, true, false, false);
//		$display->showLoginPage();
//		echo '<HR size=5>';
//		$display = new Display_AuthenticationHandler( $this->app, true, true, false);
//		$display->showLoginPage();
//		echo '<HR size=5>';
//		$display = new Display_AuthenticationHandler( $this->app, false, true, true);
//		$display->showLoginPage();
//		echo '<HR size=5>';
//		$display = new Display_AuthenticationHandler( $this->app, false, false, true);
//		$display->showLoginPage();
//		echo '<HR size=5>';
//		$display = new Display_AuthenticationHandler( $this->app, false, true, false);
//		$display->showLoginPage();
//		echo '<HR size=5>';
//		$display = new Display_AuthenticationHandler( $this->app, false, false, false);
//		$display->showLoginPage();
//		echo '<HR size=5>';
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public function showForgotPassword():void  {
		$display = new Display_AuthenticationHandler( $this->app, true, true, true);

		$display->showForgotPassword();
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public function showChangePassword() :void {
		$display = new Display_AuthenticationHandler( $this->app, true, true, true);
		$display->showChangePassword();
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public function showSignup() :void {
		$display = new Display_AuthenticationHandler( $this->app, true, true, true);
		$display->showSignup();
	}

}
