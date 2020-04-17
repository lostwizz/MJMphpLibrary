<?php

namespace Tests\Test;
use PHPUnit\Framework\TestCase;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationLDAPmethod.class.php');

use \MJMphpLibrary\AuthenticationLDAPmethod;

class AuthenticationLDAPmethod_Test  extends TestCase{
	const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, AuthenticationLDAPmethod::Version());
	}

	public function test_initialStuff() {
		$am = new AuthenticationLDAPmethod();

//		$this->assertTrue( $am->isUserNameRequired() );
		$this->assertFalse( $am->isValidPassword('a','b') );
		$this->assertFalse( $am->isAllowedToChangePassword() );
		$this->assertFalse( $am->isAllowedToForgetPassword() );
		$this->assertFalse( $am->doesUserDetailsContainPassword() );
	}

	public function test_ldappassword() {
		$am = new AuthenticationLDAPmethod();

		//$r = $am->LDAPfun( 'merrem', 'XXXXXXXXXXXXXXXXXX');   // temporarily put a real password here
		//$this->assertTrue( $r);

		//$r = $am->LDAPfun( 'merrem', 'password');
		//$this->assertFalse( $r);
	}

	public function test_preSaveProcessPassword() {
		$am = new AuthenticationLDAPmethod();

		// the password is not encrypted (passwords in ldap are not controlled by this app
		//    so it will always return null
		$encrypted = $am->preSaveProcessPassword('test Password');
		$this->assertNull( $encrypted);
	}

}
