<?php

namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\FlagHandler;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\FlagHandler\src\FlagHandler.class.php');

class FlagHandler_TEST extends TestCase {

	public function test_Versions2() {
		$this->assertEquals('0.1.0', FlagHandler::Version());
	}

	public function test_Version(): void {
		$expected = '0.1.0';
		$t = new FlagHandler(['flag1']);

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}

	function test__construct1() {
		$this->expectException(\ArgumentCountError::class);
		$this->expectErrorMessageMatches('/Too few arguments to function/');
		$this->expectErrorMessageMatches('/FlagHandler::__construct/');
		$this->expectErrorMessageMatches('/MJMphpLibrary/');
		$this->expectErrorMessageMatches('/0 passed/');
		$this->expectExceptionCode(0);

		$f = new FlagHandler();
	}

	function test__construct2() {
		$this->expectException(\TypeError::class);
		$this->expectErrorMessageMatches('/Argument 1 passed to/');
		$this->expectErrorMessageMatches('/FlagHandler::__construct/');
		$this->expectErrorMessageMatches('/MJMphpLibrary/');
		$this->expectErrorMessageMatches('/must be of the type array, string given,/');
		$this->expectExceptionCode(0);

		$f = new FlagHandler('simpleString');
	}

	function test__construct3() {
		$this->expectException(\TypeError::class);
		$this->expectErrorMessageMatches('/Argument 1 passed to/');
		$this->expectErrorMessageMatches('/FlagHandler::__construct/');
		$this->expectErrorMessageMatches('/MJMphpLibrary/');
		$this->expectErrorMessageMatches('/must be of the type array, int given,/');
		$this->expectExceptionCode(0);

		$f = new FlagHandler(1);
	}

	function test__construct9() {
		$f = new FlagHandler(['dummyFlag']);

		$expected = 0;
		$actual = $f->getIntValue();
		$this->assertEquals($expected, $actual);
	}

//
//
//	public function getIntValue() : int {
//		return $this->value;
//	}
//
//	public function setValueToInt(int $val ) : void {
//		$this->value = $val;
//	}
//
//	public function setFlagOn( string $whichFlag ) : void {
//
//	}
//
//	public function setFlagOff( string $whichFlag) : void {
//
//	}
}
