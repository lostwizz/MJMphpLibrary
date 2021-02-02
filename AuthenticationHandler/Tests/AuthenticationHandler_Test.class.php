<?php  declare(strict_types=1);
namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\AuthenticationHandler\AuthenticationHandler;
//use MJMphpLibrary\AuthenticationHandler\Data_AuthenticateUserDetailsTable;
//use MJMphpLibrary\AuthenticationHandler\Display_AuthenticationHandler;
//use MJMphpLibrary\AuthenticationHandler\AuthenticationDBmethod;
//use MJMphpLibrary\AuthenticationHandler\AuthenticationGuestMethod;
//use MJMphpLibrary\AuthenticationHandler\AuthenticationHardCodedMethod;
//use MJMphpLibrary\AuthenticationHandler\AuthenticationLDAPmethod;
//use MJMphpLibrary\AuthenticationHandler\AuthenticationUnEncryptedPWDmethod;

use \MJMphpLibrary\HTML\HTML;

//include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationHandler.class.php');


/** ===================================================================================================
 *
 * @covers \AuthenticationHandler
 */
class AuthenticationHandler_TEST extends TestCase {
	const VERSION = '0.0.1';

	public static ?string $userName =null;

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public static function setUpBeforeClass(): void   {
		// do things before any tests start -- like change some settings
		if ( empty( AuthenticationHandler_TEST::$userName)) {
			$randomSuffix = rand(100,999999);
			$newUserName = 'uu_username_uu' . $randomSuffix;
			AuthenticationHandler_TEST::$userName = $newUserName;

		}
	}


//	public function Setup():void {
//		if ( empty( self::$userName)) {
//			$randomSuffix = rand(100,999999);
//			$newUserName = 'uu_username_uu' . $randomSuffix;
//			self::$userName = $newUserName;
//		}
//	}



	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function test_Versions2() {
		$this->assertEquals(self::VERSION, AuthenticationHandler::Version());
		$this->assertNotNull( self::$userName);
	}


	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public function test_Version() :void {
		$expected = self::VERSION;
		$t = new AuthenticationHandler( 'DummyApp');

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
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

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
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

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
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

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
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

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
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

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
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

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return type
	 */
	public function test_withUnEncrypted() {

		// test unEncrypted
		$auth = new AuthenticationHandler('TestApp');
		$this->assertNotNull( $auth);

		// account doesnt exist so this logon should fail
		$this->assertFalse($auth->login( self::$userName, 'UUUpasswordUUU'));
		$this->assertFalse($auth->isLoggedOn());

		// so create the account
		$newUserId = $auth->signUp(self::$userName, 'UUUpasswordUUU', 'UnEncrypted', 0);
		$this->assertNotNull($newUserId);
		$this->assertNotEmpty($newUserId);
		$this->assertIsInt( $newUserId);

		$this->assertTrue($auth->login( self::$userName, 'UUUpasswordUUU'));
		$this->assertTrue( $auth->isLoggedOn());
		$this->assertTrue($auth->isAllowedToChangePassword());

			// bad old password this will logout
		$this->assertFalse($auth->changePassword('old password', 'newPassword'));

		$this->assertFalse( $auth->isLoggedOn());
		$this->assertTrue($auth->login( self::$userName, 'UUUpasswordUUU'));
		$this->assertTrue( $auth->isLoggedOn());

		$this->assertTrue($auth->changePassword('UUUpasswordUUU', 'newPassword'));
		$auth->logout();

		$this->assertTrue($auth->login( self::$userName, 'newPassword'));
		$this->assertTrue($auth->changePassword('newPassword', 'UUUpasswordUUU' ));

		$this->assertTrue($auth->isAllowedToForgetPassword(self::$userName));
		$this->assertFalse($auth->isAllowedToForgetPassword());

		// test removing the account

		$this->assertTrue( $auth->removeUser(self::$userName));
		// try to remove it again
		$this->assertFalse( $auth->removeUser(self::$userName));

		return $newUserId;
	}

	/** -----------------------------------------------------------------------------------------------
	 * @depends test_withUnEncrypted
	 */
	public function test_CreateDuplicate( $username){

		$auth = new AuthenticationHandler('TestApp');
		$this->assertNotNull( $auth);

		// account does not exist so should fail
 fwrite(STDERR, print_r(self::$userName, TRUE));
 fwrite( STDERR, PHP_EOL);
		$this->assertFalse($auth->login( self::$userName, 'UUUpasswordUUU'));
		$this->assertFalse( $auth->isLoggedOn());

		// so create the account
 fwrite(STDERR, print_r(self::$userName, TRUE));
 fwrite( STDERR, PHP_EOL);
		$newUserId = $auth->signUp(self::$userName, 'UUUpasswordUUU', 'UnEncrypted', 0);
		$this->assertNotNull($newUserId);
		$this->assertNotEmpty($newUserId);
		$this->assertIsInt( $newUserId);

		fwrite(STDERR, ' at test duplicate ---------------------------------' .PHP_EOL);
		fwrite(STDERR, print_r(self::$userName, TRUE));
		 fwrite( STDERR, PHP_EOL);

		fwrite(STDERR, print_r($newUserId, TRUE));
 fwrite( STDERR, PHP_EOL);


		// now try to create the account again
//		$this->expectError();
//		$this->expectErrorMessageMatches('/Cannot insert duplicate key row in object/');
//		$this->expectErrorMessageMatches('/SQLSTATE[23000]/');
//		$this->expectErrorMessageMatches('/[SQL Server]/');
 //fwrite(STDERR, print_r(self::$userName, TRUE));
 fwrite( STDERR, PHP_EOL);

		$newUserId = $auth->signUp(self::$userName, 'UUUpasswordUUU', 'UnEncrypted', 0);
 //fwrite(STDERR, print_r(self::$userName, TRUE));
 fwrite( STDERR, PHP_EOL);

		$this->assertFalse($newUserId);
	}

	/** -----------------------------------------------------------------------------------------------
	 * @depends test_CreateDuplicate
	 */
	public function test_CleanOutAccount( $x){

		$auth = new AuthenticationHandler('TestApp');
		$this->assertNotNull( $auth);

		//fwrite(STDERR, ' at clean out ---------------------------------' .PHP_EOL);
		//fwrite(STDERR, print_r(self::$userName, TRUE));

		$this->assertTrue($auth->login( self::$userName, 'UUUpasswordUUU'));
		$this->assertTrue( $auth->isLoggedOn());

		$this->assertTrue($auth->removeUser(self::$userName));
		$this->assertFalse( $auth->login('uu_username_uu', 'uu_password_uu'));

		// fail on second attempt to remove the user
		$this->assertFalse($auth->removeUser(self::$userName));
	}



}