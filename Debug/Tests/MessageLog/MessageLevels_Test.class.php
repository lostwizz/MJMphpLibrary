<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\MessageLog\MessageLevels.class.php');
use \MJMphpLibrary\Debug\MessageLog\MessageLevels;


/** ===================================================================================================
 *
 * @covers \MessageLevels
 */
class MessageLevels_Test extends TestCase {

	const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, MessageLevels::Version());
	}

	function test_var_levels(){
			$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_constats() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

}