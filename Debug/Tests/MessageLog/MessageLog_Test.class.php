<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;


use MJMphpLibrary\Debug\MessageLog\MessageLog;

class MessageLog_Test extends TestCase {

	const VERSION = '0.4.0';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, MessageLog::Version());
	}



	public function test_somethingYYY(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}
}