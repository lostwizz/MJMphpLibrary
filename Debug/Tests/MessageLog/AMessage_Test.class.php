<?php declare(strict_types=1);

namespace Tests\Test;

use \PHPUnit\Framework\TestCase;

//use \MJMphpLibrary\Debug\Dump\Dump\Dump;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\MessageLog\AMessage.class.php');
use \MJMphpLibrary\Debug\MessageLog\AMessage;


class AMessage_Test extends TestCase {

	const VERSION = '0.0.4';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, AMessage::Version());
	}

	function test__toString() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_dump() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_set() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_setFromArray() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_setText() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_setTimeStamp(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_setLevel(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_setCodeDetails(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_get(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_getShowStyle() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_getShowTextLeader(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_getPrettyLine() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

}