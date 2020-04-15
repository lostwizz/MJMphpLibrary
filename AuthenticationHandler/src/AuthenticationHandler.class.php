<?php



namespace MJMphpLibrary;

class AuthenticationHandler {

	const AUTH_TIMEOUTSECONDS = 18000;

	const AUTH_NONE = 0;
	const AUTH_FAILED_LOGON = -1;
	const AUTH_FORGOT_PASSWORD = -2;
	const AUTH_CHANGING_PASSWORD = -3;
	const AUTH_SIGNUP = -4;
	const AUTH_LOGGED_OFF = -5;
	const AUTH_ATTEMPTING_LOGON = -6;
	const AUTH_TIMEDOUT = -7;
	const AUTH_LOGGED_ON = 9999;

	protected $appName;
	protected $userName;
	protected $currentStatus = self::AUTH_NONE;
	protected $loginTime;
	protected $lastActivityTime;
	protected $currentLogonMethod;
	protected $LogonMethods = [];

	protected $app;

	private $DB_Username = 'Mikes_DBLogging_User';
	private $DB_Password =  'DonaldDuck96';

	private $DB_Type ='sqlsrv';
	private $DB_Server= 'vm-db-prd4';
	private $DB_Database = 'Mikes_Application_Store';

	private $DB_DSN =  'sqlsrv:server=vm-db-prd4;database=Mikes_Application_Store';

	private $DB_DSN_OPTIONS = array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
									\PDO::ATTR_CASE=> \PDO::CASE_UPPER,
									\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
													//PDO::ATTR_PERSISTENT => true
											);

	/**
	 * @var version string
	 */
	private const VERSION = '0.0.0';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}

	function __construct(string $appName) {
		$this->updateTime(true);
		$this->app = $appName;
		$this->currentStatus = self::AUTH_NONE;
		$this->UserDetailsDB = new AuthenticateUserDetailsTable(
				$this->app,
				$this->DB_DSN,
				$this->DB_Username,
				$this->DB_Password,
				$this->DB_DSN_OPTIONS
				);

	}

	public function updateTime(bool $setLoginTime = false): void {
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

	public function hasTimedOut(): bool {
		if ($this->current == self::AUTH_LOGGED_ON) {
			$now = (new \DateTime('now'))->getTimestamp();
			$diff = $now - $this->lastActivityTime;
			if ($diff > self::AUTH_TIMEOUTSECONDS) {
				$this->current = self::AUTH_TIMEDOUT;
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}

	public function registerActivity(): void {
		$this->updateTime();
	}

	//Status / Is Authenticated
	public function status(): int {
		$this->updateTime();
		return $this->currentStatus;
	}

	public function registerLogonMethod(string $methodName, $methodInstance): bool {
		$this->LogonMethods[$methodName] = $methodInsance;
	}

	public function login(string $username, string $password): bool {
		// read user details from database
		// use the user details - logon_method to pick the registerd method
		//  pass everything to the registed method and let it say logon or not
		// then update the logintime and session_id in the user details table
		$this->currentStatus = self::AUTH_ATTEMPTING_LOGON;
		$details = $this->UserDetails->readUserDetailsByName( $username, $this);
		$this->updateTime(true);
	}

	public function logout(): void {
		$this->currentStatus = self::AUTH_LOGGED_OFF;
	}

	public function isAllowedToChangePassword(): bool {
		// using the registered method find out if it will allow a passwor change
		//   i.e. LDAP will not do a password change
	}

	public function changePassword(string $oldPassword, string $newPassword): bool {
		// if allowed to change password then pass old and new to the registered method
		//    and let it handle the change
		$this->currentStatus = self::AUTH_CHANGING_PASSWORD;
	}

	public function signUp(string $username): void {
		// create a row in the user details table
		//   dont give it any rights untils "someone" grants the "role"
		$this->currentStatus = self::AUTH_SIGNUP;
	}

	public function isAllowedToForgetPassword(string $username): bool {
		// get the user details from the table/db
		// ask the registered method if they are allowed to forget the password
		//   probably same result as isAllowed to change password
	}

	public function forgotPassword(string $username) {
		// get the user details from the table/db
		// change the password to a random one
		//     and email the user saying new password
		$this->currentStatus = self::AUTH_FORGOT_PASSWORD;
	}

	public function getLogonMethod(): ?string {
		$this->updateTime();
		if ($this->current == self::AUTH_LOGGED_ON) {
			return $this->currentLogonMethod;
		} else {
			return null;
		}
	}

	protected function doesUserDetailsContainPassword(): bool {
		//if the registered method save the password in the table/db
		//   only db authentication method does (LDAP no, HARDCODED no)
	}

//	protected function readUserDetailsByName() : bool {
//		// read the table in the db using the username as the search key
//		// return if successfull or not
//	}
//	protected function readUserDetailsByID() : bool {
//
//	}
//
//
//	protected function updateUserDetailsDueToLogon() : bool {
//		 // update the table/db with the time the user logged on and the IP
//		// return if successfull or not
//	}
//
//
//	protected function updateUserDetailsWithNewPassword( string $newPassword) : bool {
//		//if the registered method save the password in the table/db
//		//   only db authentication method does (LDAP no, HARDCODED no)
//		//  if it does then update the password in the table/db
//
//	}
//
//	protected function addUserDetailsNewUser( string $username, string $method ) : int {
//		//insert a new row - username method,
////		 [UserId]
////      ,[app]
////      ,[method]
////      ,[username]
////      ,[password]
////      ,[Flags]
////      ,[ip]
////      ,[last_logon_time]
////      ,[session_id]
//
//	}
}
