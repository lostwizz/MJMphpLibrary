<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;

use MJMphpLibrary\Debug\History\History;

class History_Test extends TestCase {

	const VERSION = '0.3.0';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, History::Version());
	}


	/*
	 * @todo
	 */
	public function test_something(){
		$this->markTestIncomplete('This test has not been implemented yet' );

	}
}