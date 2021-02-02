<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;

use MJMphpLibrary\Debug\History\HistoryItem;

class HistoryItem_Test extends TestCase {

	const VERSION = '0.4.0';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, HistoryItem::Version());
	}


	/*
	 * @todo
	 */
	public function test_something(){
		$this->markTestIncomplete('This test has not been implemented yet' );

	}
}