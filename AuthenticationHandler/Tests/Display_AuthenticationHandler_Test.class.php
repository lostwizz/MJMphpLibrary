<?php  declare(strict_types=1);
namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\AuthenticationHandler;
include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationHandler.class.php');

use \MJMphpLibrary\Display_AuthenticationHandler;
include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\Display_AuthenticationHandler.class.php');

//fwrite(STDERR, print_r($out, TRUE));


class Display_AuthenticationHandler_Test extends TestCase {
	const VERSION = '0.0.1';

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function test_Versions2() {
		$this->assertEquals(self::VERSION, Display_AuthenticationHandler::Version());
	}


	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public function test_Version() :void {
		$expected = self::VERSION;
		$t = new Display_AuthenticationHandler( 'DummyApp');

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function test__construct() {
	}

	public function test_showLoginPage() {
		$auth = new AuthenticationHandler('TestApp');
		$auth->showLogin();

		$this->expectOutputRegex('/<form action="/');
		$this->expectOutputRegex('/name="LoginForm" method="POST">/');

		$this->expectOutputRegex('/<center>Logon Form for/');
		$this->expectOutputRegex('/<table border=1 align=center>/');
		$this->expectOutputRegex('/<td>Username: </td>\/');
		$this->expectOutputRegex('/<td colspan=2><Input type="TEXT" name="REQUEST_PAYLOAD[entered_username]" maxlength="30" minlength="1" size="30" required placeholder="User Name">/');
		$this->expectOutputRegex('/Password: /');
		$this->expectOutputRegex('/ <td colspan=2><Input type="Password" name="REQUEST_PAYLOAD[entered_password]" maxlength="100" minlength="1" size="30" required placeholder="Password">/');
		$this->expectOutputRegex('/<td align=center colspan=3><Input type="Submit" name="REQUEST_ACTION" value="Submit Logon">/');
		$this->expectOutputRegex('/<Input type="Submit" name="REQUEST_ACTION" value="Change Password">/');
		$this->expectOutputRegex('/<Input type="Submit" name="REQUEST_ACTION" value="Add New Account">/');
		$this->expectOutputRegex('/<Input type="Submit" name="REQUEST_ACTION" value="Forgot Password">/');

		$this->expectOutputRegex('(</form>)');
	}

	public function test_showForgotPassword() {
		$auth = new AuthenticationHandler('TestApp');
		$auth->showForgotPassword();

		$this->expectOutputRegex('/<form action="/');
		$this->expectOutputRegex('/" name="ForgotPasswordForm" method="POST">/');
		$this->expectOutputRegex('/<Input type="HIDDEN" name="REQUEST_PROCESS" value="Authenticate">/');
		$this->expectOutputRegex('/<Input type="HIDDEN" name="REQUEST_TASK" value="ChangeForgotPassword">/');
		$this->expectOutputRegex('/<center>Forgot Password Form for/');
		$this->expectOutputRegex('(</center><BR>           <table border=1 align=center>)');
		$this->expectOutputRegex('(<td>Username: </td>)');
		$this->expectOutputRegex('/<Input type="TEXT" name="REQUEST_PAYLOAD[entered_username]" maxlength="30" size="30" required placeholder="User Name" minlength="1" required>/');
		$this->expectOutputRegex('/<Input type="Submit" name="REQUEST_ACTION" value="Submit Username for Forgot Password">/');
		$this->expectOutputRegex('(</form>)');
	}

	public function test_showChangePassword() {
		$auth = new AuthenticationHandler('TestApp');
		$auth->showChangePassword();

		$this->expectOutputRegex('/<form action="/');
		$this->expectOutputRegex('/" name="ChangePasswordForm" method="POST">/');
		$this->expectOutputRegex('/<Input type="HIDDEN" name="REQUEST_PROCESS" value="Authenticate">/');

		$this->expectOutputRegex('/<Input type="HIDDEN" name="REQUEST_PROCESS" value="Authenticate">/');
		$this->expectOutputRegex('/<Input type="HIDDEN" name="REQUEST_TASK" value="ChangePasswordTask">/');
		$this->expectOutputRegex('/<center>Change Password Form for/');
		$this->expectOutputRegex('(<td>Username: </td>)');
		$this->expectOutputRegex('/<td><Input type="TEXT" name="REQUEST_PAYLOAD[entered_username]" maxlength="30" size="30" minlength="1" required placeholder="User Name">/');

		$this->expectOutputRegex('(<td>Old Password: </td>)');
		$this->expectOutputRegex('/ <Input type="Password" name="REQUEST_PAYLOAD[old_password]" maxlength="100" size="30" required minlength="1" placeholder="Old Password">/');
		$this->expectOutputRegex('(<td>New Password: </td>)');
		$this->expectOutputRegex('/<Input type="Submit" name="REQUEST_ACTION" value="Submit Username for Password Change">/');


		$this->expectOutputRegex('(</form>)');
	}

	public function test_showSignup() {
		$auth = new AuthenticationHandler('TestApp');
		$auth->showSignup();

		$this->expectOutputRegex('/<form action="/');
		$this->expectOutputRegex('/" name="ChangePasswordForm" method="POST">/');
		$this->expectOutputRegex('/<Input type="HIDDEN" name="REQUEST_PROCESS" value="Authenticate">/');
		$this->expectOutputRegex('/<Input type="HIDDEN" name="REQUEST_TASK" value="SignUpTask">/');
		$this->expectOutputRegex('/<center>Request for Account Form for/');
		$this->expectOutputRegex('(<td>Username: </td>)');
		$this->expectOutputRegex('/<td><Input type="TEXT" name="REQUEST_PAYLOAD[entered_username]" maxlength="30" size="30" required minlength="1" placeholder="User Name">/');
		$this->expectOutputRegex('(<td>Password: </td>)');
		$this->expectOutputRegex('/<Input type="Password" name="REQUEST_PAYLOAD[entered_password]" maxlength="100" size="30" required minlength="1" placeholder="Password">/');
		$this->expectOutputRegex('(<td>Email Address: </td>)');
		$this->expectOutputRegex('/<Input type="eMail" name="REQUEST_PAYLOAD[entered_email]" maxlength="255" size="30" required minlength="3" placeholder="email address">/');
		$this->expectOutputRegex('/<Input type="Submit" name="REQUEST_ACTION" value="Submit New Account Info">/');

		$this->expectOutputRegex('(</form>)');
	}

}