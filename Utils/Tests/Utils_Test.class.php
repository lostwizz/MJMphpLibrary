<?php declare(strict_types=1);

namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\Utils\Utils;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Utils\src\Utils.class.php');


/** ===================================================================================================
 *
 * @covers \Utils
 */
class Utils_TEST extends TestCase {
	const VERSION = '0.3.0';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, Utils::Version());
	}


	function test_ShowMoney() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

}