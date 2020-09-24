<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;

use \MJMphpLibrary\Debug\DumpClasses;
//use \MJMphpLibrary\Debug\Dump\Dump\Dump;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\MessageLog\MessageLogBase.trait.php');
use \MJMphpLibrary\Dump\MessageLog\MessageLogBaseTrait as MessageLogBaseTrait;





	class fred {
		//use \MJMphpLibrary\Debug\MessageLog\MessageLogBaseTrait;
		use MessageLogBaseTrait;
	}



class MessageLogBaseTrait_Test extends TestCase {

//	const VERSION = '0.0.1';
//	public function test_Versions2() {
//		$this->assertEquals(self::VERSION, DumpClasses::Version());
//	}

//	function test_hello() {
//		$this->assertFalse(true, ' Hello World');
//	}

	function test_mask() {
		$c = new fred();

		$this->assertEquals( MSGLOG_BEGIN || MSGLOG_RESULT, $mask = $c->mask );

		$c->mask = 0b0000;
		$this->assertEquals( 0, $c->mask);

		$c->mask = 0b0001;
		$this->assertEquals( 1, $c->mask);

		$c->mask = 0b0010;
		$this->assertEquals( 2, $c->mask);

	}

	function test_giveLocation(){

		$fake_bt = [[ 'file' => 'somefile',
					  'line' => 'someline',
					'class'=> 'someclaass',
					'function' => 'somefunction',
					'args' => ['arg1' => 'a', 'arg2'=>'b'],
						]];
		$c = new fred();
		$c->fakeBTforTesting = $fake_bt;
		$c->fakeBTextraForTesting = 0;

		$actual = $c->giveLocation(0, $fake_bt);

		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #1#';
		$this->assertEquals($expected, $actual);
	}

	function test_msg(){
		$fake_bt = [[ 'file' => 'somefile',
					  'line' => 'someline',
					'class'=> 'someclaass',
					'function' => 'somefunction',
					'args' => ['arg1' => 'a', 'arg2'=>'b'],
						]];
		$c = new fred();
		$c->fakeBTforTesting = $fake_bt;
		$c->fakeBTextraForTesting = 0;

		$actual = $c->msg('a message',0);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #1#&nbsp;a message<BR>';
		$this->assertEquals( $expected, $actual);
	}

	function test_msgLogBegin() {
		$fake_bt = [[ 'file' => 'somefile',
					  'line' => 'someline',
					'class'=> 'someclaass',
					'function' => 'somefunction',
					'args' => ['arg1' => 'a', 'arg2'=>'b'],
						]];
		$c = new fred();
		$c->fakeBTforTesting = $fake_bt;
		$c->fakeBTextraForTesting = 0;

		$c->mask  =MSGLOG_BEGIN;
		$actual = $c->msgLogBegin('a message',0);
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #1#&nbsp;Array([0] => a message[1] => 0)<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogBegin('a message',0);
		$expected = '';
		$this->assertEmpty( $actual);
	}

	function test_msgLogResult() {
		$fake_bt = [[ 'file' => 'somefile',
					  'line' => 'someline',
					'class'=> 'someclaass',
					'function' => 'somefunction',
					'args' => ['arg1' => 'a', 'arg2'=>'b'],
						]];
		$c = new fred();
		$c->fakeBTforTesting = $fake_bt;
		$c->fakeBTextraForTesting = 0;

		$c->mask = MSGLOG_RESULT;
		$actual = $c->msgLogResult('a message',0);
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #2#&nbsp;Array([0] => a message[1] => 0)<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogResult('a message',0);
		$expected = '';
		$this->assertEmpty( $actual);
	}

	function test_msgLogAssertEquals() {
		$fake_bt = [[ 'file' => 'somefile',
					  'line' => 'someline',
					'class'=> 'someclaass',
					'function' => 'somefunction',
					'args' => ['arg1' => 'a', 'arg2'=>'b'],
						]];
		$c = new fred();
		$c->fakeBTforTesting = $fake_bt;
		$c->fakeBTextraForTesting = 0;

		$c->mask = MSGLOG_ASSERT_EQUALS;
		$actual = $c->msgLogAssertEquals('a','b');
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #32#&nbsp;Array([0] =>ASSERTED-EQUALS(NOT!) )<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask = MSGLOG_ASSERT_EQUALS;
		$actual = $c->msgLogAssertEquals('a', 'a');
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #32#&nbsp;Array([0] =>ASSERTED-EQUALS )<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogAssertEquals('a','a');
		$expected = '';
		$this->assertEmpty( $actual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogAssertEquals('a','b');
		$expected = '';
		$this->assertEmpty( $actual);
	}

	function test_msgLogAssertNotEquals() {
		$fake_bt = [[ 'file' => 'somefile',
					  'line' => 'someline',
					'class'=> 'someclaass',
					'function' => 'somefunction',
					'args' => ['arg1' => 'a', 'arg2'=>'b'],
						]];
		$c = new fred();
		$c->fakeBTforTesting = $fake_bt;
		$c->fakeBTextraForTesting = 0;

		$c->mask = MSGLOG_ASSERT_NOT_EQUALS;
		$actual = $c->msgLogAssertNotEquals('a', 'b');
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #16#&nbsp; ASSERTED-NOT-EQUALS <BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask = MSGLOG_ASSERT_NOT_EQUALS;
		$actual = $c->msgLogAssertNotEquals('a', 'a');
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #16#&nbsp; ASSERTED-EQUALS(bad) <BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogAssertNotEquals('a','a');
		$expected = '';
		$this->assertEmpty( $actual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogAssertNotEquals('a','b');
		$expected = '';
		$this->assertEmpty( $actual);

	}

	function test_msgLogAssertNull() {
		$fake_bt = [[ 'file' => 'somefile',
					  'line' => 'someline',
					'class'=> 'someclaass',
					'function' => 'somefunction',
					'args' => ['arg1' => 'a', 'arg2'=>'b'],
						]];
		$c = new fred();
		$c->fakeBTforTesting = $fake_bt;
		$c->fakeBTextraForTesting = 0;

		$c->mask = MSGLOG_ASSERT_NULL;
		$actual = $c->msgLogAssertNull('a');
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #128#&nbsp; ASERTED-NULL(NOT!)<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask = MSGLOG_ASSERT_NULL;
		$actual = $c->msgLogAssertNull(null);
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #128#&nbsp; ASSERTED-NULL<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask = MSGLOG_ASSERT_NULL;
		$x = null;
		$actual = $c->msgLogAssertNull($x);
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #128#&nbsp; ASSERTED-NULL<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogAssertNull('a');
		$expected = '';
		$this->assertEmpty( $actual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogAssertNull(null);
		$expected = '';
		$this->assertEmpty( $actual);

	}

	function test_msgLogAssertNotNull() {
		$fake_bt = [[ 'file' => 'somefile',
					  'line' => 'someline',
					'class'=> 'someclaass',
					'function' => 'somefunction',
					'args' => ['arg1' => 'a', 'arg2'=>'b'],
						]];
		$c = new fred();
		$c->fakeBTforTesting = $fake_bt;
		$c->fakeBTextraForTesting = 0;

		$c->mask = MSGLOG_ASSERT_NOT_NULL;
		$actual = $c->msgLogAssertNotNull('a');
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #64#&nbsp; ASSERTED-NOT-NULL<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask = MSGLOG_ASSERT_NOT_NULL;
		$actual = $c->msgLogAssertNotNull(null);
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #64#&nbsp; ASERTED-NULL(bad))<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask = MSGLOG_ASSERT_NOT_NULL;
		$x = null;
		$actual = $c->msgLogAssertNotNull($x);
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #64#&nbsp; ASERTED-NULL(bad))<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogAssertNotNull('a');
		$expected = '';
		$this->assertEmpty( $actual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogAssertNotNull(null);
		$expected = '';
		$this->assertEmpty( $actual);
	}

	function test_msgLogAsertEmpty() {
		$fake_bt = [[ 'file' => 'somefile',
					  'line' => 'someline',
					'class'=> 'someclaass',
					'function' => 'somefunction',
					'args' => ['arg1' => 'a', 'arg2'=>'b'],
						]];
		$c = new fred();
		$c->fakeBTforTesting = $fake_bt;
		$c->fakeBTextraForTesting = 0;

		$c->mask = MSGLOG_ASSERT_EMPTY;
		$actual = $c->msgLogAsertEmpty('a');
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #256#&nbsp; ASERTED-EMPTY(NOT!)<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask = MSGLOG_ASSERT_EMPTY;
		$actual = $c->msgLogAsertEmpty(null);
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #256#&nbsp; ASSERTED-EMPTY<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask = MSGLOG_ASSERT_EMPTY;
		$actual = $c->msgLogAsertEmpty(0);
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #256#&nbsp; ASSERTED-EMPTY<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask = MSGLOG_ASSERT_EMPTY;
		$actual = $c->msgLogAsertEmpty('0');
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #256#&nbsp; ASSERTED-EMPTY<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask = MSGLOG_ASSERT_EMPTY;
		$actual = $c->msgLogAsertEmpty(1);
		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);
		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #256#&nbsp; ASERTED-EMPTY(NOT!)<BR>';
		$this->assertEquals( $expected, $cleanActual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogAsertEmpty('a');
		$expected = '';
		$this->assertEmpty( $actual);

		$c->mask  =0; // do nothing
		$actual = $c->msgLogAsertEmpty(null);
		$expected = '';
		$this->assertEmpty( $actual);

	}

	function test_msgLogAsertNotEmpty() {
		$fake_bt = [[ 'file' => 'somefile',
					  'line' => 'someline',
					'class'=> 'someclaass',
					'function' => 'somefunction',
					'args' => ['arg1' => 'a', 'arg2'=>'b'],
						]];
		$c = new fred();
		$c->fakeBTforTesting = $fake_bt;
		$c->fakeBTextraForTesting = 0;
		$actual = $c->msgLogAsertNotEmpty('a message',0, $fake_bt, true);

		$cleanActual = str_replace( ["\r\n", "\n", "\r", "  "], '', $actual);

		$expected = 'somefile-someclaass->somefunction(a:2:{s:4:"arg1";s:1:"a";s:4:"arg2";s:1:"b";}) {line:someline} #1#&nbsp;Array([0] => a message[1] => 0[2] => Array([0] => Array([file] => somefile[line] => someline[class] => someclaass[function] => somefunction[args] => Array([arg1] => a[arg2] => b)))[3] => 1)<BR>';
		$this->assertEquals( $expected, $cleanActual);
	}

}


/*
	$x = new fred();
	$x2 = new fred();

	$x->mask = 0b0011;
	$x->tony('+++++++++');
	$x->msgit('hi');

	$x2->mask = 0b0010;

	$x2->msgit('x2');
	$x2->tony();

	$x->msgit('x');


	$x->mask = 0b0010;
	$x->tony('%%%%%%%%%%%%%%%%');


	$x->mask = 0b0011;
	$x->tony('***t2****');

	$x->mask = 0b0100;
	$x->tony('***t3****');


	echo'^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^<BR>';
	$x->mask = ($x->mask | MSGLOG_ASSERT_EQUALS) ;
	$x->tony( 1);
	$x->tony( 99);

	echo'^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^<BR>';
	echo'^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^<BR>';

	$x->mask = 0b1111_1111_1111_1111;
	$x->tony(1);
 *
 */