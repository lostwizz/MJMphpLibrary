<?php  declare(strict_types=1);
namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\MenuBarHandler;



include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Menus\src\MenuBarHandler.class.php');

/** ===================================================================================================
 *
 * @covers \MenuBarHandler
 */
class MenuBarHandler_TEST extends TestCase {
	const VERSION = '0.0.0';

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function test_Versions2() {
		$this->assertEquals(self::VERSION, MenuBarHandler::Version());
	}


	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public function test_Version() :void {
		$expected = self::VERSION;
		$t = new MenuBarHandler( 'DummyApp');

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}

}
