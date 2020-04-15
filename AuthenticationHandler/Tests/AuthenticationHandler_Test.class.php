<?php
namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\AuthenticationHandler;



include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationHandler.class.php');


class AuthenticationHandler_TEST extends TestCase {

	public function test_Versions2() {
		$this->assertEquals('0.1.0', AuthenticationHandler::Version());
	}

	public function test_Version() :void {
		$expected ='0.1.0';
		$t = new AuthenticationHandler( 'DummyApp');

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}
}