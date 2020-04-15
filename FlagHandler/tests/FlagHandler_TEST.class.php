<?php

namespace Tests\Test;
use PHPUnit\Framework\TestCase;


//use MJMphpLibrary\FlagHandler as FlagHandler;


//include '..\..\FlagHandler.class.php';
include_once('P:\Projects\_PHP_Code\MJMphpLibrary\FlagHandler\src\FlagHandler.class.php');

//$h = new FlagHandler();

class FlagHandler_TEST extends TestCase {

	public function test_Versions2() {
		$this->assertEquals('0.1.0', \MJMphpLibrary\FlagHandler::Version());
	}

	public function test_Version() :void {
		$expected ='0.1.0';
		$t = new \MJMphpLibrary\FlagHandler( ['flag1']);

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}

	function test__construct1(){
		$this->expectException(\ArgumentCountError::class);
		$this->expectErrorMessageMatches('/Too few arguments to function/');
		$this->expectErrorMessageMatches('/FlagHandler::__construct/');
		$this->expectErrorMessageMatches('/MJMphpLibrary/');
		$this->expectErrorMessageMatches('/0 passed/');
		$this->expectExceptionCode(0);

		$f = new \MJMphpLibrary\FlagHandler();
	}

	function test__construct2(){
		$this->expectException(\TypeError::class);
		$this->expectErrorMessageMatches('/Argument 1 passed to/');
		$this->expectErrorMessageMatches('/FlagHandler::__construct/');
		$this->expectErrorMessageMatches('/MJMphpLibrary/');
		$this->expectErrorMessageMatches('/must be of the type array, string given,/');
		$this->expectExceptionCode(0);

		$f = new \MJMphpLibrary\FlagHandler('simpleString');
	}

	function test__construct3(){
		$this->expectException(\TypeError::class);
		$this->expectErrorMessageMatches('/Argument 1 passed to/');
		$this->expectErrorMessageMatches('/FlagHandler::__construct/');
		$this->expectErrorMessageMatches('/MJMphpLibrary/');
		$this->expectErrorMessageMatches('/must be of the type array, int given,/');
		$this->expectExceptionCode(0);

		$f = new \MJMphpLibrary\FlagHandler(1);
	}

	function test__construct4() {
		$f = new \MJMphpLibrary\FlagHandler(['dummyFlag']);
		$this->assertEquals( 0, $f->getIntValue());
		$this->assertEquals(['dummyflag'], $f->getListOfFlags());

		$f = new \MJMphpLibrary\FlagHandler(['dummyflag','anotherdummy']);
		$this->assertEquals( 0, $f->getIntValue());
		$this->assertEquals(['dummyflag','anotherdummy'], $f->getListOfFlags());

		$f = new \MJMphpLibrary\FlagHandler(['dummyFlag'] , -1);
		$this->assertEquals( 0, $f->getIntValue());

		$f = new \MJMphpLibrary\FlagHandler(['dummyFlag'] , 0);
		$this->assertEquals( 0, $f->getIntValue());

		$f = new \MJMphpLibrary\FlagHandler(['dummyFlag'] , 1);
		$this->assertEquals( 1, $f->getIntValue());
	}

	function test_setValueToInt(){
		$f = new \MJMphpLibrary\FlagHandler(['dummyFlag']);
		$this->assertEquals(0, $f->getIntValue());

		$f->setValueToInt(1);
		$this->assertEquals(1, $f->getIntValue());

		$f->setValueToInt(0b0001);
		$this->assertEquals(1, $f->getIntValue());

		$f->setValueToInt(0b1111);
		$this->assertEquals(15, $f->getIntValue());

		$f->setValueToInt(0b1111_0001);
		$this->assertEquals( 241, $f->getIntValue());

		$f->setValueToInt(0b0000_1111);
		$this->assertEquals( 15, $f->getIntValue());
	}

	function test_setFlagOn_and_off() {
		$f = new \MJMphpLibrary\FlagHandler(['dummyFlag','flagTwo', 'flagThree']);
		$this->assertEquals(0, $f->getIntValue());

		$f->setFlagOn('dummyFlag');
		$this->assertEquals( 1, $f->getIntValue());

		$f->setFlagOff('dummyFlag');
		$this->assertEquals( 0, $f->getIntValue());

		$f->setFlagOn('flagTwo');
		$this->assertEquals( 2, $f->getIntValue());

		$f->setFlagOff('flagTwo');
		$this->assertEquals( 0, $f->getIntValue());

		$f->setFlagOn('flagThree');
		$this->assertEquals( 4, $f->getIntValue());

		$f->setFlagOff('flagThree');
		$this->assertEquals( 0, $f->getIntValue());

		$f->setFlagOff('flagFIVE');
		$this->assertEquals( 0, $f->getIntValue());


		$f->setFlagOn('dummyFlag');
		$f->setFlagOn('flagTwo');
		$this->assertEquals( 3, $f->getIntValue());

		$f->setFlagOff('dummyFlag');
		$this->assertEquals( 2, $f->getIntValue());
		$f->setFlagOff('flagTwo');
		$this->assertEquals( 0, $f->getIntValue());

		$f->setFlagOn('dummyFlag');
		$f->setFlagOn('flagTwo');
		$f->setFlagOn('flagThree');
		$this->assertEquals( 7, $f->getIntValue());

		$f->setFlagOff('flagTwo');
		$this->assertEquals( 5, $f->getIntValue());
	}

	function test_isFlagSet() {
		$f = new \MJMphpLibrary\FlagHandler(['dummyFlag','flagTwo', 'flagThree']);
		$this->assertEquals(0, $f->getIntValue());
		$this->assertFalse( $f->isFlagSet('dummyFlag'));
		$this->assertFalse( $f->isFlagSet('flagTwo'));
		$this->assertFalse( $f->isFlagSet('flagThree'));
		$this->assertFalse( $f->isFlagSet('flagFIVE'));

		$f->setFlagOn('dummyFlag');
		$this->assertTrue( $f->isFlagSet('dummyFlag'));

		$f->setFlagOn('flagTwo');
		$this->assertTrue( $f->isFlagSet('flagTwo'));

		$f->setFlagOn('flagThree');
		$this->assertTrue( $f->isFlagSet('flagThree'));

		$f->setFlagOff('flagTwo');
		$this->assertFalse( $f->isFlagSet('flagTwo'));
		$this->assertTrue( $f->isFlagSet('dummyFlag'));
		$this->assertTrue( $f->isFlagSet('flagThree'));

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





