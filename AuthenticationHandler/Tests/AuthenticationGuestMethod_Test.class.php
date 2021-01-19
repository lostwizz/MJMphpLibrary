<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;


include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationGuestMethod.class.php');

use \MJMphpLibrary\AuthenticationGuestMethod;



/** ===================================================================================================
 *
 * @covers \AuthenticationGuestMethod
 */
class AuthenticationGuestMethod_Test  extends TestCase{
	const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, AuthenticationGuestMethod::Version());
	}

	public function test_Version() :void {
		$expected = self::VERSION;
		$t = new AuthenticationGuestMethod( ['flag1']);

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}

	public function test_initialStuff() {
		$am = new AuthenticationGuestMethod();

//		$this->assertTrue( $am->isUserNameRequired() );
		$this->assertFalse( $am->isAllowedToChangePassword() );
		$this->assertFalse( $am->isAllowedToForgetPassword() );
		$this->assertFalse( $am->doesUserDetailsContainPassword() );

	}
	public function test_Guestpassword() {
		$am = new AuthenticationGuestMethod();

		// any "empty" password for guest will work
		$this->assertTrue( $am->isValidPassword('guest','') );
		$this->assertTrue( $am->isValidPassword('guest',null) );
		//$this->assertTrue( $am->isValidPassword('guest',0) );
		//$this->assertTrue( $am->isValidPassword('guest','0') );
		$this->assertFalse( $am->isValidPassword('guest','any password') );

		// this is not the guest account so will fail
		$this->assertFalse( $am->isValidPassword('mm', 'dummy') );

	}
	public function test_preSaveProcessPassword() {
		$am = new AuthenticationGuestMethod();

		// the password is always blank
		//    so it will always return null
		$encrypted = $am->preSaveProcessPassword('test Password');
		$this->assertNull( $encrypted);
	}


}