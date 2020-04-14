<?php

namespace Tests\Test;


use PHPUnit\Framework\TestCase;
use MJMphpLibrary\FlagHandler;

include '..\FlagHandler.class.php';

class FlagHandler_Test extends TestCase {

	function test_Version() :void {
		$expected ='0.1.0';
		$t = new FlagHandler();

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}
}