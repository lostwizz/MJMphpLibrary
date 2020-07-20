<?php declare(strict_types=1);

namespace Tests\Test;

use \PHPUnit\Framework\TestCase;

//use \MJMphpLibrary\Debug\Dump\Dump\Dump;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\MessageLog\AMessage.class.php');
use \MJMphpLibrary\Debug\MessageLog\AMessage as AMessage;


class AMessage_Test extends TestCase {

	const VERSION = '0.0.4';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, AMessage::Version());
	}


	function test_constructor() {
//fwrite(STDERR, print_r( get_declared_classes(), TRUE));

		$m = new AMessage();
		$this->assertInstanceOf( AMessage::class, $m);

		$m = new AMessage('a');
		$this->assertInstanceOf( AMessage::class, $m);

		$m = new AMessage('a', 'b' , 1);
		$this->assertInstanceOf( AMessage::class, $m);

		$m = new AMessage('a', 'b' , 1, 'c');
		$this->assertInstanceOf( AMessage::class, $m);


		//$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test__toString() {
		$m = new AMessage();
		$this->assertEquals( '23:55:30 (Level: NOTICE)  ' , (string)$m);

		$m = new AMessage('a');
		$this->assertEquals( '23:55:30 (Level: NOTICE) a ' , (string)$m);

		$m = new AMessage('a', 'b');
		$this->assertEquals( 'b (Level: NOTICE) a ' , (string)$m);

		$m = new AMessage('a', 'b' , 1);
		$this->assertEquals( 'b (Level: ALL) a ' , (string)$m);

		$m = new AMessage('a', 'b' , 1, 'c');
		$this->assertEquals( 'b (Level: ALL) a c' , (string)$m);
	}

	function test_dump() {
		$m = new AMessage();
		$this->assertEquals( 'msg= time=23:55:30 level=NOTICE coded=<Br>' , $m->dump( true ) );

		$m = new AMessage('a');
		$this->assertEquals( 'msg=a time=23:55:30 level=NOTICE coded=<Br>' , $m->dump(true));

		$m = new AMessage('a', 'b');
		$this->assertEquals( 'msg=a time=b level=NOTICE coded=<Br>' , $m->dump(true));

		$m = new AMessage('a', 'b' , 1);
		$this->assertEquals( 'msg=a time=b level=ALL coded=<Br>' , $m->dump(true));

		$m = new AMessage('a', 'b' , 1, 'c');
		$this->assertEquals( 'msg=a time=b level=ALL coded=c<Br>' , $m->dump(true));

	}

	function test_dump1() {
		$m = new AMessage();
		$this->expectOutputString('msg= time=23:55:30 level=NOTICE coded=<Br>');
		$m->dump(  );
	}

	function test_dump2() {
		$m = new AMessage('a');
		$this->expectOutputString('msg=a time=23:55:30 level=NOTICE coded=<Br>');
		$m->dump(  );
	}
	function test_dump3() {
		$m = new AMessage('a', 'b' );
		$this->expectOutputString('msg=a time=b level=NOTICE coded=<Br>');
		$m->dump(  );
	}
	function test_dump4() {
		$m = new AMessage('a', 'b' ,1);
		$this->expectOutputString('msg=a time=b level=ALL coded=<Br>');
		$m->dump(  );
	}
	function test_dump5() {
		$m = new AMessage('a', 'b' ,1, 'c');
		$this->expectOutputString('msg=a time=b level=ALL coded=c<Br>');
		$m->dump( );
	}

	function test_set() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_setFromArray() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_setText() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_setTimeStamp(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_setLevel(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_setCodeDetails(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_get(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_getShowStyle() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_getShowTextLeader(){
		$this->markTestIncomplete('This test has not been implemented yet' );
	}

	function test_getPrettyLine() {
		$this->markTestIncomplete('This test has not been implemented yet' );
	}




}