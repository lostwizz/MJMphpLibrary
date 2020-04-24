<?php  declare(strict_types=1);
namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\Display_AuthenticationHandler;



include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\Display_AuthenticationHandler.class.php');


class Display_AuthenticationHandler_Test extends TestCase {
	const VERSION = '0.0.1';

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function test_Versions2() {
		$this->assertEquals(self::VERSION, Display_AuthenticationHandler::Version());
	}


	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public function test_Version() :void {
		$expected = self::VERSION;
		$t = new Display_AuthenticationHandler( 'DummyApp');

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function test__construct() {
	}

}