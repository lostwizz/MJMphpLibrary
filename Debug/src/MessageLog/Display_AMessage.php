<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;

class Display_AMessage_Test extends TestCase {

	const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, Display_AMessage::Version());
	}



	public static function test_something(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}
}