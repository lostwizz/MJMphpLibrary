<?php

declare(strict_types=1);

namespace Tests\Test;

use \PHPUnit\Framework\TestCase;

use MJMphpLibrary\Debug\Dump\DumpConfig;


	require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpConfig.class.php');


class DumpConfig_Test extends TestCase {

	const VERSION = '0.3.2';

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function test_Versions2() {
		$this->assertEquals(self::VERSION, DumpConfig::Version());
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public function test_Version() :void {
		$expected = self::VERSION;
		$t = new DumpConfig( 'DummyApp');

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}

}