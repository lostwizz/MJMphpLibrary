<?php declare(strict_types=1);
namespace Tests\Test;
use PHPUnit\Framework\TestCase;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationUnEncryptedPWDmethod.class.php');

use \MJMphpLibrary\AuthenticationUnEncryptedPWDmethod;



/** ===================================================================================================
 *
 * @covers \AAuthenticationUnEncryptedPWDmethod
 */
class AAuthenticationUnEncryptedPWDmethod_Test  extends TestCase{
	const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, AuthenticationUnEncryptedPWDmethod::Version());
	}

	public function test_Version() :void {
		$expected = self::VERSION;
		$t = new AuthenticationUnEncryptedPWDmethod( ['flag1']);

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}

	public function test_initialStuff() {
		$am = new AuthenticationUnEncryptedPWDmethod();

//		$this->assertTrue( $am->isUserNameRequired() );
		$this->assertTrue( $am->isAllowedToChangePassword() );
		$this->assertTrue( $am->isAllowedToForgetPassword() );
		$this->assertTrue( $am->doesUserDetailsContainPassword() );

	}
	public function test_dbpassword() {
		$am = new AuthenticationUnEncryptedPWDmethod();

		$unEncryptedPWD = 'm';
		$this->assertTrue( $am->isValidPassword('m','m') );

		$this->assertFalse( $am->isValidPassword('mm','m') );
		$this->assertFalse( $am->isValidPassword('m','mm') );

	}

	public function test_preSaveProcessPassword() {
		$am = new AuthenticationUnEncryptedPWDmethod();

		$encrypted = $am->preSaveProcessPassword('test Password');
		$this->assertTrue($am->isValidPassword('test Password', $encrypted));

		$this->assertFalse($am->isValidPassword('bad Password', $encrypted));
	}

}