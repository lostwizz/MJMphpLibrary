<?php

declare(strict_types=1);

namespace Tests\Test;

use \PHPUnit\Framework\TestCase;
use \MJMphpLibrary\Debug\Dump\DumpConfigSet;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpConfigSet.class.php');

//fwrite(STDERR, print_r($out, TRUE));


class DumpConfigSet_Test extends TestCase {

	const VERSION = '0.0.1';

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function test_Versions2() {
		$this->assertEquals(self::VERSION, DumpConfigSet::Version());
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
//	public function test_Version() :void {
//		$expected = self::VERSION;
//		$t = new Display_AuthenticationHandler( 'DummyApp');
//
//		$actual = $t->Version();
//		$this->assertEquals($expected, $actual);
//	}



	function test_construct() {
		$x = new DumpConfigSet('ONE');
//fwrite(STDERR, print_r($x, TRUE));

		$this->assertIsArray( $x->currentSet);
		$y = $x->Beautify_PreWidth;
		$this->assertEquals('95%', $y);

	}

	function test_currentSet() {
		$x = new DumpConfigSet();
		$this->assertEquals( 39, count($x->currentSet));


	}


	function test_tabOverSet(){
		$x = new DumpConfigSet();
		$this->assertEquals( 16, count($x->tabOverSet));

	}



}
