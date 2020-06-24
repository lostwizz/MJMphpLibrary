<?php

declare(strict_types=1);

namespace Tests\Test;

use \PHPUnit\Framework\TestCase;
use \MJMphpLibrary\Debug\Dump\DumpConfigSet;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpConfigSet.class.php');

//fwrite(STDERR, print_r($out, TRUE));


class DumpConfigSet_Test extends TestCase {

	const VERSION = '0.0.2';

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

	//	$this->assertIsArray( $x->currentSet);
		$y = $x->OverallWidth;
		$this->assertEquals('95%', $y);

	}

	public function getPrivateMethod( $className, $methodName ) {
		$reflector = new ReflectionClass( $className );
		$method = $reflector->getMethod( $methodName );
		$method->setAccessible( true );

		return $method;
	}

	private function _getInnerPropertyValueByReflection(DumpConfigSet $instance, $property = '_data') {
        $reflector = new \ReflectionClass($instance);
        $reflector_property = $reflector->getProperty($property);
        $reflector_property->setAccessible(true);

        return $reflector_property->getValue($instance);
    }

	function test_currentSet() {
		$x = new DumpConfigSet();

		$actual  = $this->_getInnerPropertyValueByReflection($x, 'currentSet');

		$this->assertEquals( 39, count($actual ));
	}


	function test_tabOverSet(){
		$x = new DumpConfigSet();

		$actual  = $this->_getInnerPropertyValueByReflection($x, 'tabOverSet');

		$this->assertEquals( 16, count($actual));
	}



}

//
//class Extended_DumpConfigSet extends DumpConfigSet {
//	function __construct(){
//
//	}
//
//	function extended_currentSet() {
//		return $parent->
//	}
//}

