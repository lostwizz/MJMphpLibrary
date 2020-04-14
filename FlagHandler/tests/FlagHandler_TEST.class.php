<?php

namespace Tests\Test;
use PHPUnit\Framework\TestCase;


use MJMphpLibrary\FlagHandler\FlagHandler as FlagHandler;
;

//include '..\..\FlagHandler.class.php';
include_once('P:\Projects\_PHP_Code\MJMphpLibrary\FlagHandler\src\FlagHandler.class.php');

//$h = new FlagHandler();

final class FlagHandler_TEST extends TestCase {


	public function test_Versions2() {
		$this->assertEquals('0.1.0', FlagHandler::Version());
	}

	public function test_Version() :void {
		echo 'hi';
		$expected ='0.1.0';
		$t = new FlagHandler();

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}
}