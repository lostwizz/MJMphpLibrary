<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;



include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationHardCodedMethod.class.php');

use \MJMphpLibrary\AuthenticationHardCodedMethod;


class AuthenticationHardCodedMethod_Test  extends TestCase{
		const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, AuthenticationHardCodedMethod::Version());
	}

	public function test_Version() :void {
		$expected = self::VERSION;
		$t = new AuthenticationHardCodedMethod( ['flag1']);

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}

	public function test_initialStuff() {
		$am = new AuthenticationHardCodedMethod();

//		$this->assertTrue( $am->isUserNameRequired() );
		$this->assertFalse( $am->isAllowedToChangePassword() );
		$this->assertFalse( $am->isAllowedToForgetPassword() );
		$this->assertFalse( $am->doesUserDetailsContainPassword() );

	}
	public function test_dbpassword() {
		$am = new AuthenticationHardCodedMethod();

		$pwdHash = '$2y$10$zofEoreltPwAUzVTjQLWFeRVmUpfrqUXfMmCB1qW3Sw.Xl1bAxr26';

		$this->assertTrue( $am->isValidPassword('m',$pwdHash) );

		$this->assertFalse( $am->isValidPassword('mm',$pwdHash) );
	}


	public function test_preSaveProcessPassword() {
		$am = new AuthenticationHardCodedMethod();

		$encrypted = $am->preSaveProcessPassword('test Password');
		$this->assertTrue($am->isValidPassword('test Password', $encrypted));

		$this->assertFalse($am->isValidPassword('bad Password', $encrypted));
	}
}