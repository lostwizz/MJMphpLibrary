<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;

use MJMphpLibrary\Debug\MessageLog\SubSystemMessage;

class SubSystemMessage_Test extends TestCase {

	const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, SubSystemMessage::Version());
	}



	public function test_something(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}
}