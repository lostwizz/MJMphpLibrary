<?php
namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\AuthenticationHandler;



include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationHandler.class.php');


class AuthenticationHandler_TEST extends TestCase {

	const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, AuthenticationHandler::Version());
	}

	public function test_Version() :void {
		$expected = self::VERSION;
		$t = new AuthenticationHandler( 'DummyApp');

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}

	public function test__construct() {    // tests without a username being set/available
		$auth = new AuthenticationHandler('TestApp');
		$this->assertNotNull( $auth);

		$r = $auth->hasTimedOut();
		$this->assertTrue( $r);   // not logged on yet so it has effectively timed out

		$r = $auth->status();
		$this->assertEquals( AuthenticationHandler::AUTH_NONE , $r);

		$r = $auth->getLogonMethod();
		$this->assertNull($r);

		$r =  $auth->getRegisteredMethods();
		$expected = ['DB_Table', 'Guest', 'HARDCoded', 'LDAP','UnEncrypted'];
		$this->assertEquals( $expected, $r);

		$this->assertFalse( $auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));

		$this->assertFalse( $auth->isAllowedToForgetPassword());

		$this->assertFalse( $auth->doesUserDetailsContainPassword());
	}


		//fwrite(STDERR, print_r(' at 1 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($auth, TRUE));

	public function test_BadUser() {

		$auth = new AuthenticationHandler('TestApp');
		$this->assertNotNull( $auth);
		$r = $auth->login( 'badUserName', 'pwd1');
		$this->assertFalse( $r);
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());


		$auth = new AuthenticationHandler('TestApp');
		$this->assertNotNull( $auth);
		$r = $auth->login( 'badUserName', null);
		$this->assertFalse( $r);
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());

		$auth = new AuthenticationHandler('TestApp');
		$this->assertNotNull( $auth);
		$r = $auth->login( '', null);
		$this->assertFalse( $r);
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());
	}

	public function test_withDBtable() {

		// test DB_table
		$auth = new AuthenticationHandler('TestApp');
		$this->assertNotNull( $auth);
		$r = $auth->login( 'm', 'm');
		$this->assertTrue( $r);
		$this->assertTrue( $auth->isLoggedOn());
		$this->assertTrue($auth->isAllowedToChangePassword());
		$this->assertTrue($auth->isAllowedToForgetPassword('m'));
		$this->assertFalse($auth->isAllowedToForgetPassword());

		$auth->logout();
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());


		$r = $auth->login( 'm', 'bad password');
		$this->assertFalse( $r);
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());

		$auth->logout();
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
	}
	public function test_withGuest() {
		// test Guest - only blank/empty password will work for the guest account
		$auth = new AuthenticationHandler('TestApp');
		$this->assertNotNull( $auth);
		$r = $auth->login( 'Guest', null);
		$this->assertTrue( $r);
		$this->assertTrue( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());
		$auth->logout();
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());

		$r = $auth->login( 'Guest', '');
		$this->assertTrue( $r);
		$this->assertTrue( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());
		$auth->logout();
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());

		$r = $auth->login( 'Guest', 0);
		$this->assertTrue( $r);
		$this->assertTrue( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());
		$auth->logout();
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());

		$r = $auth->login( 'Guest', '0');
		$this->assertTrue( $r);
		$this->assertTrue( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());
		$auth->logout();
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());

		$r = $auth->login( 'Guest', 'bad password');
		$this->assertFalse( $r);
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());
		$auth->logout();
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());
	}
	public function test_withhardcoded() {

		//test hardcoded
		$auth = new AuthenticationHandler('TestApp');
		$this->assertNotNull( $auth);
		$r = $auth->login( 'harry', '$2y$10$8HoPqNBlIvc1JR140QmnI.OCCwsXPxlP8M6.eFS8taIaMwdhgmtP.');
		$this->assertTrue( $r);
		$this->assertTrue( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());
		$auth->logout();
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());

		$r = $auth->login( 'harry', 'bad password');
		$this->assertFalse( $r);
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());
		$auth->logout();
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());

	}
	public function test_withLDAP() {

		// test ldap --- DISABLED because too many bad password attempts locks the account
		//					- and dont want to put good password infile to github
//		$auth = new AuthenticationHandler('TestApp');
//		$this->assertNotNull( $auth);
//		$r = $auth->login( 'merrem', '---- insert good password here---');
//		$this->assertTrue( $r);
//		$this->assertTrue( $auth->isLoggedOn());
//		$this->assertFalse($auth->isAllowedToChangePassword());
//		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
//		$this->assertFalse($auth->isAllowedToForgetPassword());
//		$auth->logout();
//		$this->assertFalse( $auth->isLoggedOn());
//		$this->assertFalse($auth->isAllowedToChangePassword());
//		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
//		$this->assertFalse($auth->isAllowedToForgetPassword());

//		$r = $auth->login( 'merrem', 'bad password');
//		$this->assertFalse( $r);
//		$this->assertFalse( $auth->isLoggedOn());
//		$this->assertFalse($auth->isAllowedToChangePassword());
//		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
//		$this->assertFalse($auth->isAllowedToForgetPassword());
//		$auth->logout();
//		$this->assertFalse( $auth->isLoggedOn());
//		$this->assertFalse($auth->isAllowedToChangePassword());
//		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
//		$this->assertFalse($auth->isAllowedToForgetPassword());
	}

	public function test_withUnEncrypted() {

		// test unEncrypted
		$auth = new AuthenticationHandler('TestApp');
		$this->assertNotNull( $auth);
		$r = $auth->login( 'UUUTESTUUU', 'UUUpasswordUUU');
		$this->assertTrue( $r);
		$this->assertTrue( $auth->isLoggedOn());
		$this->assertTrue($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword')); // bad old password
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->changePassword('UUUpasswordUUU', 'newPassword'));

		$r = $auth->login( 'UUUTESTUUU', 'UUUpasswordUUU');
		$this->assertTrue( $r);
		$this->assertTrue( $auth->isLoggedOn());
		$this->assertTrue($auth->changePassword('UUUpasswordUUU', 'newPassword'));
		$this->assertFalse( $auth->isLoggedOn());



		$r = $auth->login( 'UUUTESTUUU', 'newPassword');
		$this->assertTrue( $r);
		$this->assertTrue( $auth->isLoggedOn());
		$this->assertTrue($auth->changePassword('newPassword', 'UUUpasswordUUU'));
		$this->assertFalse( $auth->isLoggedOn());

		$r = $auth->login( 'UUUTESTUUU', 'UUUpasswordUUU');
		$this->assertTrue( $r);
		$this->assertTrue( $auth->isLoggedOn());
		$this->assertTrue($auth->isAllowedToForgetPassword('UUUTESTUUU'));
		$this->assertFalse($auth->isAllowedToForgetPassword());
		$auth->logout();
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());

		$r = $auth->login( 'UUUTESTUUU', 'bad password');
		$this->assertFalse( $r);
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());
		$auth->logout();
		$this->assertFalse( $auth->isLoggedOn());
		$this->assertFalse($auth->isAllowedToChangePassword());
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));
		$this->assertFalse($auth->isAllowedToForgetPassword());

	}

}