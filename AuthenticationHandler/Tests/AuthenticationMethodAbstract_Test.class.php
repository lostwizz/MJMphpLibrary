<?php declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationMethodAbstract.class.php');

use \MJMphpLibrary\AuthenticationMethodAbstract;


/** ===================================================================================================
 *
 * @covers \AuthenticationMethodAbstract
 */
class AuthenticationMethodAbstract_Test  extends TestCase{
	const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, AuthenticationMethodAbstract::Version());
	}

    protected $newAnonymousClassFromAbstract;

    protected function setUp():void  {
        // Create a new instance from the Abstract Class
        $this->newAnonymousClassFromAbstract = new class extends AuthenticationMethodAbstract {

//			public function isUserNameRequired(): bool {return true; }
			public function isValidPassword($string1, $string2): bool{return true; }
			public function preSaveProcessPassword( $password ) : ?string {return ''; }
			//public function isValidPasswordByUserID($userName, $password): bool{return true; }
			public function isAllowedToChangePassword(): bool{return true; }
			public function isAllowedToForgetPassword(): bool{return true; }
			public function doesUserDetailsContainPassword(): bool{return true; }
			public function returnThis() { return $this;}
        };
    }
//
	public function testAbstractClassMethod() {
//		$this->assertTrue( $this->newAnonymousClassFromAbstract->isUserNameRequired() );
		$this->assertTrue( $this->newAnonymousClassFromAbstract->isValidPassword('s1','s2') );
		//$this->assertTrue( $this->newAnonymousClassFromAbstract->isValidPasswordByUserID(1,'p') );
		$this->assertTrue( $this->newAnonymousClassFromAbstract->isAllowedToChangePassword() );
		$this->assertTrue( $this->newAnonymousClassFromAbstract->isAllowedToForgetPassword() );
		$this->assertTrue( $this->newAnonymousClassFromAbstract->doesUserDetailsContainPassword() );

		$this->assertInstanceOf(
            AuthenticationMethodAbstract::class,
            $this->newAnonymousClassFromAbstract
        );
		$this->assertInstanceOf(
            AuthenticationMethodAbstract::class,
            $this->newAnonymousClassFromAbstract->returnThis()
        );
	}


}