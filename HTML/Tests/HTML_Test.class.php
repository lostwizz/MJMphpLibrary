<?php

declare(strict_types=1);

namespace Tests\Test;

use \PHPUnit\Framework\TestCase;
//use \MJMphpLibrary\AuthenticationHandler;
//include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationHandler.class.php');
//use \MJMphpLibrary\Display_AuthenticationHandler;
//include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\Display_AuthenticationHandler.class.php');
use \MJMphpLibrary\HTML\HTML;

//include_once('P:\Projects\_PHP_Code\MJMphpLibrary\HTML\src\HTML.class.php');

//fwrite(STDERR, print_r($out, TRUE));


/** ===================================================================================================
 *
 * @covers \HTML
 */
class HTML_Test extends TestCase {

	const VERSION = '0.3.2';

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function test_Versions2() {
		$this->assertEquals(self::VERSION, HTML::Version());
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


	public function DataProvider_ParseOptions() {
		return [[ '', null],   //0
				[' checked', 'checked'],  //1
				[' checked', ['checked']],  //2
				[' a="b" checked', ['a'=>'b', 'checked']],    //3
				[' a="b" checked', ['a'=>'b', 'checked'=>true]],   //4

				[' alt=FRED', 'alt=FRED'],   //5
				[' alt="FRED"', ['alt' => 'FRED']],  //6
				[' border="4"', ['border'=>'4']],    //7
				[' alt="FRED" border="4" snow="somesnow"', ['alt'=>'FRED', 'border'=>'4','snow'=>'somesnow']],   //8
				[' alt="FRED" border="4" snow="somesnow"', ['alt="FRED"', 'border="4"','snow="somesnow"']],   //9
				[' alt=FRED border=4 snow=somesnow', ['alt=FRED', 'border=4','snow=somesnow']],   //10
				['', []], //11
				[' checked', ['checked' => true]]    //12
			];
	}

	/**
 	 * @dataProvider DataProvider_ParseOptions
	 */
	function test_parseOptions($expected, $in1=null) {
		$o = new ExtendedHTML();

		$actual = $o->extended_parseOptions($in1);
		//$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	public function DataProvider_ParseStyle() {
		return [
			['', null],         //0
			['', []],			//1
			[' style="backgroundcolor: yellow"', 'backgroundcolor: yellow'],		//2
			[' style="backgroundcolor: yellow;"', ['backgroundcolor: yellow']],		//3
			[' style="backgroundcolor: yellow; forground-color: blue;"', ['backgroundcolor' => 'yellow', 'forground-color: blue']], //4
			[' style="backgroundcolor: yellow; forground-color: blue;"', ['backgroundcolor' => 'yellow', 'forground-color' =>'blue']],  //5
		];
	}

	/**
	 * @dataProvider DataProvider_ParseStyle
	 */
	function test_parseStyle( $expected, $in1=null) {
		$o = new ExtendedHTML();
		$actual = $o->extended_parseStyle($in1);
		$this->assertEquals( $expected, $actual);
	}


	public function DataProvider_Anchor() {
		return [
			['<a href=""></a>'],
			['<a href=""></a>', null],
			['<a href=""></a>', '', ''],
			['<a href=""></a>', null, null],
			['<a href="X">X</a>', 'X', ''],
			['<a href="X">X</a>', 'X', null],
			['<a href="">y</a>', '', 'y'],
			['<a href="">y</a>', null, 'y'],
			['<a href="x">y</a>', 'x', 'y'],
			['<a href="xx">yy</a>', 'xx', 'yy'],

			['<a href=""></a>', null, null, null],
			['<a href="X">X</a>', 'X', '', ''],
			['<a href="X">X</a>', 'X', null, ''],
			['<a href="" z>y</a>', '', 'y', 'z'],  //13
			['<a href="" z>y</a>', null, 'y', 'z'],
			['<a href="x" z>y</a>', 'x', 'y', 'z'],
			['<a href="xx" zz>yy</a>', 'xx', 'yy', 'zz'],
		];
	}

	/**
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 * @dataProvider DataProvider_Anchor
	 */
	function test_Anchor($expected, $in1=null, $in2=null, $in3=null, $in4=null) {
		$this->assertEquals( $expected, HTML::Anchor($in1, $in2, $in3, $in4));
	}


	public function DataProvider_Button() {
		return [
			['<Input type="BUTTON">'],  //0
			['<Input type="BUTTON">', null],  //1
			['<Input type="BUTTON">', '', ''],  //                       //2
			['<Input type="BUTTON">', null, null],                       //3
			['<Input type="BUTTON" name="X">', 'X', ''],                 //4
			['<Input type="BUTTON" name="X">', 'X', null],               //5
			['<Input type="BUTTON" value="y">', '', 'y'],                //6
			['<Input type="BUTTON" value="y">', null, 'y'],              //7
			['<Input type="BUTTON" name="x" value="y">', 'x', 'y'],      //8
			['<Input type="BUTTON" name="xx" value="yy">', 'xx', 'yy', null],  //9
			['<Input type="BUTTON" name="xx" value="yy">', 'xx', 'yy', ''],  //10
			['<Input type="BUTTON" name="xx" value="yy">cc', 'xx', 'yy', 'cc'],  //11

		];
	}

	/**
	 * @dataProvider DataProvider_Button
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Button($expected, $in1=null, $in2=null, $in3=null) {
		$actual = HTML::Button($in1, $in2, $in3);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	public function DataProvider_CheckBox() {
		return [
			['<Input type="CHECKBOX">'],  //0
			['<Input type="CHECKBOX">', null],  //1
			['<Input type="CHECKBOX" name="a">', 'a'],	 //2
			['<Input type="CHECKBOX" name="a">', 'a', null],  //3
			['<Input type="CHECKBOX" name="a" value="b">', 'a', 'b'],  //4
			['<Input type="CHECKBOX" name="a" value="b">', 'a', 'b',null],  //5
			['<Input type="CHECKBOX" name="a" value="b">c', 'a', 'b', 'c'],  //6
			['<Input type="CHECKBOX" name="a" value="b">c', 'a', 'b', 'c', null],  //7
			['<Input type="CHECKBOX" name="a" value="b" checked>c', 'a', 'b', 'c', true],  //8
			['<Input type="CHECKBOX" name="a" value="b">c', 'a', 'b', 'c', false],  //9

			];
	}

	/**
	 * @dataProvider DataProvider_CheckBox
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_CheckBox($expected, $in1=null, $in2=null, $in3=null, $in4=null) {
		$actual = HTML::CheckBox($in1, $in2, $in3, $in4);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_DIV() {
		return [
			['<Input type="CHECKBOX">',null], //0
			['<Input type="CHECKBOX">', ''],		//1
			['<Input type="CHECKBOX" name="a">', 'a'],		//2
			['<Input type="CHECKBOX" name="a">', 'a', ''],	//3
			['<Input type="CHECKBOX" name="a" value="b">', 'a', 'b'],		//4
		];
	}

	/**
	 * @dataProvider DataProvider_DIV
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_DIV( $expected, $in1=null, $in2=null) {
		$actual = HTML::CheckBox($in1, $in2);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_EMAIL() {
		return [
			//['', null],
			//['', ''],
			['<Input type="eMail">', ''],			//0
			['<Input type="eMail" name="a">', 'a'],		//1
			['<Input type="eMail" name="a">', 'a', ''],	//2
			['<Input type="eMail" name="a" value="b">', 'a', 'b'],	//3
			['<Input type="eMail" name="a" value="b">', 'a', 'b', null],	//4
			['<Input type="eMail" name="a" value="b">', 'a', 'b', ''],	//5
			['<Input type="eMail" name="a" value="b">c', 'a', 'b', 'c'],	//6
		];
	}

	/**
	 * @dataProvider DataProvider_EMAIL
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_EMAIL( $expected, $in1=null, $in2=null, $in3=null) {
		$actual = HTML::email($in1, $in2,$in3);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_Hidden(){
		return [
			['<Input type="HIDDEN">',''],			//0
			['<Input type="HIDDEN" name="a">','a'],		//1
			['<Input type="HIDDEN" name="a">','a', ''],	//2
			['<Input type="HIDDEN" name="a" value="b">','a', 'b', null],	//3
			['<Input type="HIDDEN" name="a" value="b">','a', 'b', ''],	//4
			['<Input type="HIDDEN" name="a" value="b">c','a', 'b', 'c'],	//5
		];
	}

	/**
	 * @dataProvider DataProvider_Hidden
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Hidden( $expected, $in1=null, $in2=null, $in3=null) {
		$actual = HTML::Hidden($in1, $in2, $in3);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_Image() {
		return [
			['<Input type="IMAGE" src="">','',''],				//0
			['<Input type="IMAGE" name="a" src="">', 'a', ''],	//1
			['<Input type="IMAGE" name="a" src="b">', 'a', 'b'],	//2
			['<Input type="IMAGE" name="a" src="b">', 'a', 'b', null],		//3
			['<Input type="IMAGE" name="a" src="b">', 'a', 'b', ''],		//4
			['<Input type="IMAGE" name="a" value="c" src="b">', 'a', 'b', 'c'],		//5
			['<Input type="IMAGE" name="a" value="c" src="b">', 'a', 'b', 'c', null],		//6
			['<Input type="IMAGE" name="a" value="c" src="b">', 'a', 'b', 'c', ''],		//7
			['<Input type="IMAGE" name="a" value="c" src="b">', 'a', 'b', 'c', ' '],		//8
			['<Input type="IMAGE" name="a" value="c" src="b">d', 'a', 'b', 'c', 'd' ],		//9
		];
	}

	/**
	 * @dataProvider DataProvider_Image
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Image( $expected, $in1=null, $in2=null, $in3=null, $in4=null) {
		$actual = HTML::Image($in1, $in2, $in3, $in4);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_Img(){
		return [
			['<img src="" border="0" />',''],		//0

			['<img src="html://a.com" border="0" />', 'html://a.com'],      //1
			['<img src="b" border="0" />', 'b'],			//2
			['<img src="./c.bmp" border="0" />', './c.bmp'],			//3
		];
	}

	/**
	 * @dataProvider DataProvider_Img
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Img( $expected, $in1=null){
		$actual = HTML::Img($in1 );
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_Password(){
		return [
			['<Input type="Password">', ''],		//0
			['<Input type="Password" name="a">', 'a'],			//1
			['<Input type="Password" name="a">', 'a', null],			//2
			['<Input type="Password" name="a">', 'a', ''],			//3
			['<Input type="Password" name="a" value="b">', 'a', 'b'],			//4
			['<Input type="Password" name="a" value="b">', 'a', 'b', null],			//5
			['<Input type="Password" name="a" value="b">', 'a', 'b', ''],			//6
			['<Input type="Password" name="a" value="b">c', 'a', 'b', 'c'],			//7
		];
	}

	/**
	 * @dataProvider DataProvider_Password
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Password( $expected, $in1=null, $in2=null, $in3=null) {
		$actual = HTML::Password($in1, $in2, $in3);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_Radio() {
		return [
			['<Input type="RADIO" name="a" value="b">', 'a', 'b'], //0
			['<Input type="RADIO" name="a" value="b">', 'a', 'b', null],			//1
			['<Input type="RADIO" name="a" value="b" checked>', 'a', 'b', true],		//2
			['<Input type="RADIO" name="a" value="b">', 'a', 'b', false],		//3
			['<Input type="RADIO" name="a" value="b">', 'a', 'b', false, null],		//4
			['<Input type="RADIO" name="a" value="b">c', 'a', 'b', false, 'c'],		//5
			['<Input type="RADIO" name="a" value="b" checked>c', 'a', 'b', true, 'c'],		//6

		];
	}

	/**
	 * @dataProvider DataProvider_Radio
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Radio( $expected, $in1=null, $in2=null, $in3=null, $in4=null) {
		$actual = HTML::Radio($in1, $in2, $in3, $in4);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_Reset() {
		return [
			['<Input type="Reset">',''],
			['<Input type="Reset" value="a">','a']
		];
	}

	/**
	 * @dataProvider DataProvider_Reset
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Reset( $expected, $in1=null) {
		$actual = HTML::Reset($in1);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_ShowInput() {
		return [
			['', '', '', ''],		//0
			['', '', '', '', ''],	//1
			['', '', '', '', '', ''], //2
			['', 'a', '', ''],		//3
			['', 'a', 'b', ''],		//4
			['', 'a', 'b', 'c'],		//5
			['', '', 'b', 'c'],		//6
			['', '', '', 'c'],		//7
			['', '', 'b', ''],		//8
			['', 'a', 'b', 'c', 'd'],	//9
			['', '', '', '', '', ''],	//10
			['', '', '', '', '', '', ''],		//11
			['', 'a', 'b', 'c', 'd', 'e', 'f'],	//12

			['<Input type="CHECKBOX" name="a" value="b">' . PHP_EOL, 'a', 'b', 'CHECKBOX'],  //13
			['<Input type="RADIO" name="a" value="b">' . PHP_EOL, 'a', 'b', 'RADIO'],  //14
			['<Input type="Reset" name="a" value="b">' . PHP_EOL, 'a', 'b', 'Reset'],  //15
			['<Input type="Password" name="a" value="b">' . PHP_EOL, 'a', 'b', 'Password'],  //16
			['<Input type="Submit" name="a" value="b">' . PHP_EOL, 'a', 'b', 'Submit'],  //17
			['<Input type="BUTTON" name="a" value="b">' . PHP_EOL, 'a', 'b', 'BUTTON'],  //18
			['<Input type="eMail" name="a" value="b">' . PHP_EOL, 'a', 'b', 'eMail'],  //19
			['<Input type="TEXT" name="a" value="b">' . PHP_EOL, 'a', 'b', 'TEXT'],  //20
			['<Input type="HIDDEN" name="a" value="b">' . PHP_EOL, 'a', 'b', 'HIDDEN'],  //21
			['<Input type="IMAGE" name="a" value="b">' . PHP_EOL, 'a', 'b', 'IMAGE'],  //22

			['<Input type="CHECKBOX" name="a" value="b" c>' . PHP_EOL, 'a', 'b', 'CHECKBOX', 'c'],  //23
			['<Input type="CHECKBOX" name="a" value="b" c style="d">' . PHP_EOL, 'a', 'b', 'CHECKBOX', 'c', 'd'],  //24
			['<Input type="CHECKBOX" name="a" value="b" c style="d">e' . PHP_EOL, 'a', 'b', 'CHECKBOX', 'c', 'd', 'e'],  //25
		];
	}

	/**
	 * @dataProvider DataProvider_ShowInput
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_ShowInput( $expected, $in1=null, $in2=null, $in3=null, $in4=null, $in5=null, $in6=null) {
		$o = new ExtendedHTML();
		$actual = $o->extendedShowinput($in1, $in2, $in3, $in4, $in5, $in6);
		/////////////$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_Submit(){
		return [
			['<Input type="Submit">',''],			//0
			['<Input type="Submit" name="a">','a'],		//1
			['<Input type="Submit" name="a">','a', ''],	//2
			['<Input type="Submit" name="a" value="b">','a', 'b'],		//3
			['<Input type="Submit" name="a" value="b">','a', 'b', ''],	//4
			['<Input type="Submit" name="a" value="b">c','a', 'b', 'c'],		//5
		];
	}

	/**
	 * @dataProvider DataProvider_Submit
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Submit( $expected, $in1=null, $in2=null, $in3=null) {
		$actual = HTML::Submit($in1, $in2, $in3 );
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_Text(){
		return [
			['<Input type="TEXT">',''],		//0
			['<Input type="TEXT">',''],		//1
			['<Input type="TEXT">','',''],		//2
			['<Input type="TEXT">','','',''],	//3
			['<Input type="TEXT" name="a">','a'],		//4
			['<Input type="TEXT" name="a" value="b">','a', 'b'],	//5
			['<Input type="TEXT" value="b">','', 'b'],		//6
			['<Input type="TEXT" name="a" value="b">c','a', 'b', 'c'],	//7
			['<Input type="TEXT" value="b">c','', 'b', 'c'],	//8
			['<Input type="TEXT" name="a">c','a', '', 'c'],	//9
			['<Input type="TEXT">c','', '', 'c'],	//10
		];
	}

	/**
	 * @dataProvider DataProvider_Text
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Text( $expected, $in1=null, $in2=null, $in3=null) {
		$actual = HTML::Text($in1, $in2, $in3 );
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}


	function DataProvider_TextArea(){
		return [
			['<textarea name="" ></textarea>', ''],			//0
			['<textarea name="" ></textarea>', '', ''],		//1
			['<textarea name="" ></textarea>', '', null],		//2
			['<textarea name="a" ></textarea>', 'a'],			//3
			['<textarea name="a" >b</textarea>', 'a', 'b'],			//4
			['<textarea name="" >b</textarea>', '', 'b'],			//5
		];
	}

	/**
	 * @dataProvider DataProvider_TextArea
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_TextArea( $expected, $in1=null, $in2=null) {
		$actual = HTML::TextArea($in1, $in2 );
		//$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}


	function DataProvider_Options(){
		return [
			[ '<option value="0" selected>a</option>' . PHP_EOL
			  . '<option value="1">b</option>' . PHP_EOL
			  . '<option value="2">c</option>' . PHP_EOL,
						['a', 'b', 'c'] ],             //0

			[ '<option value="0" selected>a</option>' . PHP_EOL
			  . '<option value="1">b</option>' . PHP_EOL
			  . '<option value="2">c</option>'. PHP_EOL ,
						['a', 'b', 'c'], 'd' ],        //1


			[ '<option value="-1">- Select -</option>' . PHP_EOL
			  . '<option value="0" selected>a</option>' . PHP_EOL
			  . '<option value="1">b</option>' . PHP_EOL
			  . '<option value="2">c</option>' . PHP_EOL,
					['a', 'b', 'c'], 'd', true],        //2

			[ '<option value="0" selected>a</option>' . PHP_EOL
			  . '<option value="1">b</option>' . PHP_EOL
			  . '<option value="2">c</option>' . PHP_EOL,
					['a', 'b', 'c'], 'd', false],         //3

			[ '<option value="0" selected>a</option>' . PHP_EOL
			  . '<option value="1">b</option>' . PHP_EOL
			  . '<option value="2">c</option>' . PHP_EOL,
					['a', 'b', 'c'], 0, false],           //4

			[ '<option value="0">a</option>' . PHP_EOL
			  . '<option value="1" selected>b</option>' . PHP_EOL
			  . '<option value="2">c</option>' . PHP_EOL,
					['a', 'b', 'c'], 1, false],           //5

			[ '<option value="0">a</option>' . PHP_EOL
				. '<option value="1">b</option>' . PHP_EOL
				. '<option value="2" selected>c</option>' . PHP_EOL,
					['a', 'b', 'c'], 2, false],          //6

			[ '<option value="0">a</option>' . PHP_EOL
				. '<option value="1">b</option>' . PHP_EOL
				. '<option value="2">c</option>' . PHP_EOL,
					['a', 'b', 'c'], -1, false],         //7

			[ '<option value="-1" selected>- Select -</option>' . PHP_EOL
			  . '<option value="0">a</option>' . PHP_EOL
			  . '<option value="1">b</option>' . PHP_EOL
			  . '<option value="2">c</option>' . PHP_EOL,
					['a', 'b', 'c'], -1, true],          //8

			['', []],  // 9

			['<option value="0" selected>a</option>' . PHP_EOL,
				['a']],   //10

			['<option value="-1" selected>- Select -</option>' . PHP_EOL
				. '<option value="0" selected>a</option>' . PHP_EOL,
				['a'], 0, true],   //11

		];
	}

	/**
	 * @dataProvider DataProvider_Options
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Options( $expected, $in1=null, $in2=null, $in3=null, $in4=null) {
		$h = new ExtendedHTML();
		$actual = $h->extended_Options($in1, $in2, $in3, $in4);
		//$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function DataProvider_Select(){
		return [
			['<Select name="a" ></select>' . PHP_EOL,
					'a', [], 'c', false],     //0

			['<Select name="a" ><option value="-1">- Select -</option>' . PHP_EOL
				. '</select>' . PHP_EOL
				,'a', [], 'c', true],      //1

			['<Select name="a" ><option value="-1">- Select -</option>' . PHP_EOL
				. '<option value="0" selected>B</option>' . PHP_EOL
				. '</select>' . PHP_EOL
				,'a', ['B'], 'c', true],      //2

			['<Select name="a" ><option value="-1" selected>- Select -</option>' . PHP_EOL
				. '<option value="0" selected>B</option>' . PHP_EOL
				. '</select>' . PHP_EOL,
				'a', ['B'], 0, true],         //3
		];
	}

	/**
	 * @dataProvider DataProvider_Select
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 * @depends test_Options
	 */
	function test_Select( $expected, $in1=null, $in2=null, $in3=null, $in4=null) {
		$actual = HTML::Select($in1, $in2, $in3, $in4);
		//$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}


	function DataProvider_DocType(){
		return [
			['html5' , '<!DOCTYPE html>'],
			['xhtml11' , '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">'],
			['xhtml1-strict' , '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'],
			['xhtml1-trans' , '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'],
			['xhtml1-frame' , '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">'],
			['html4-strict' , '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">'],
			['html4-trans' , '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">'],
			['html4-frame' , '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">'],
		];
	}

	/**
	 * @dataProvider DataProvider_DocType
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_DocType($in1, $expected ){
		$actual = HTML::DocType($in1 );
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function test_HR(){
		$this->assertEquals( '<HR size="1"/>', HTML::HR());
		$this->assertEquals( '<HR size="1"/>', HTML::HR(1));
		$this->assertEquals( '<HR size="2"/>', HTML::HR(2));
		$this->assertEquals( '<HR size="3"/>', HTML::HR(3));
	}

	function test_BR(){
		$this->assertEquals( '<BR />', HTML::BR());
		$this->assertEquals( '<BR />', HTML::BR(1));
		$this->assertEquals( '<BR /><BR />', HTML::BR(2));
		$this->assertEquals( '<BR /><BR /><BR />', HTML::BR(3));
	}

	function test_Space(){
		$this->assertEquals( '&nbsp;', HTML::Space());
		$this->assertEquals( '&nbsp;', HTML::Space(1));
		$this->assertEquals( '&nbsp;&nbsp;', HTML::Space(2));
		$this->assertEquals( '&nbsp;&nbsp;&nbsp;', HTML::Space(3));
	}

	function DataProvider_FormOpen(){
		return [
			[ '<form action="">', ''], //0
			[ '<form action="a">', 'a'], //1
			[ '<form action="a">', 'a', ''],  //2
			[ '<form action="a" name="b">', 'a', 'b'], //3
			[ '<form action="" name="b">', '', 'b'],  //4
			[ '<form action="a" name="b">', 'a', 'b', ''],   //5
			[ '<form action="a" name="b" method="c">', 'a', 'b', 'c'],  //6
			[ '<form action="">', '', '', ''],    //7
			[ '<form action="" name="b">', '', 'b', ''],   //8
			[ '<form action="" name="b" method="c">', '', 'b', 'c'],   //9
			[ '<form action="a">', 'a', '', '', ''],  //10
			[ '<form action="a" name="b" method="c">', 'a', 'b', 'c',''],  //11
			[ '<form action="a" name="b" method="c" enctype="d">', 'a', 'b', 'c', 'd'],  //12
			[ '<form action="" enctype="d">', '', '', '',  'd'],   //13
			[ '<form action="" method="c" enctype="d">', '', '', 'c', 'd'],   //14
			[ '<form action="" name="b" enctype="d">', '', 'b', '', 'd'],   //15
			[ '<form action="" name="b" method="c" enctype="d">', '', 'b', 'c', 'd'],  //16
		];
	}

	/**
	 * @dataProvider DataProvider_FormOpen
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_FormOpen($expected, $in1=null, $in2=null, $in3=null, $in4=null) {
		$actual = HTML::FormOpen($in1, $in2, $in3, $in4);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	function test_FormClose(){
		$this->assertEquals( ' </form>'.PHP_EOL, HTML::FormClose());
	}

	/**
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Open(){
		//$this->assertEquals( ''.PHP_EOL, HTML::Open());
		$this->assertEquals( '<>'.PHP_EOL, HTML::Open(''));
		$this->assertEquals( '<a>'.PHP_EOL, HTML::Open('a'));
	}

	function test_Close(){
		$this->assertEquals( '</>'.PHP_EOL, HTML::Close());
		$this->assertEquals( '</>'.PHP_EOL, HTML::Close(''));
		$this->assertEquals( '</a>'.PHP_EOL, HTML::Close('a'));
	}

	/**
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_TR(){
		$this->assertEquals( '<TR>'.PHP_EOL, HTML::TR());
	}

	function test_TRend() {
		$this->assertEquals( '</TR>'.PHP_EOL, HTML::TRend());
	}

	/**
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_TD(){
		$this->assertEquals( '<TD>'.PHP_EOL, HTML::TD());
	}

	function test_TDend() {
		$this->assertEquals( '</TD>'.PHP_EOL, HTML::TDend());
	}

	/**
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_TDendTD(){
		$this->assertEquals( '</TD>'.PHP_EOL.'<TD>'.PHP_EOL, HTML::TDendTD());
	}


	function DataProvider_filter(){
		return [
			[ '', 'a', 'b'],  //0
			[ 'b', 'strip', 'b'],  //1
			[ 'c', 'strip', '<b>c</b>'],   //2
			[ '&lt;b&gt;c&lt;/b&gt;', 'escapeAll', '<b>c</b>'],   //3
			[ '&lt;b&gt;c&lt;/b&gt;', 'escape', '<b>c</b>'],     //4
			[ 'b', 'url', 'b'],   //5
			[ 'foo%20%40%2B%25%2F', 'url', 'foo @+%/'],    //6
			[ 'b', 'filename', 'b'],    //7
			[ 'c--a.txt', 'filename', 'c:\a.txt'],    //8
			[ 'c--fred-a.txt', 'filename', 'c:\fred\a.txt'],   //9
			[ 'c--fred-a.txt', 'filename', 'c:\fred/a.txt'],   //10
			[ 'c--fred--a.txt', 'filename', 'c:\fred//a.txt'],   //10
		];
	}

	/**
	 * @dataProvider DataProvider_filter
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_filter($expected, $in1=null, $in2=null) {
		$actual = HTML::filter($in1, $in2);
		//$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

}


class ExtendedHTML extends HTML {

	function extended_parseOptions($ar = null) {
		return parent::parseOptions($ar);
	}

	function extended_parseStyle($ar = null) {
		return parent::parseStyle($ar);
	}

	function extended_Options( array $v, $defaultItemView = null, ?bool $addDashDashSelect = true) {
		return parent::Options($v, $defaultItemView, $addDashDashSelect);
	}
	function extendedShowinput(?string $name = null,
			?string $value = null,
			string $type = 'TEXT',
			$arOptions = null,
			$arStyle = null,
			?string $lable = null
	): ?string {
		return parent::ShowInput($name, $value, $type, $arOptions, $arStyle, $lable);
	}

}