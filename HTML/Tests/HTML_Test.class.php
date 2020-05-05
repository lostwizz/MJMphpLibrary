<?php

declare(strict_types=1);

namespace Tests\Test;

use \PHPUnit\Framework\TestCase;
//use \MJMphpLibrary\AuthenticationHandler;
//include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationHandler.class.php');
//use \MJMphpLibrary\Display_AuthenticationHandler;
//include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\Display_AuthenticationHandler.class.php');
use \MJMphpLibrary\HTML;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\HTML\src\HTML.class.php');

//fwrite(STDERR, print_r($out, TRUE));


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
				[' a="b" checked="1"', ['a'=>'b', 'checked'=>true]],   //4

				[' alt=FRED', 'alt=FRED'],   //5
				[' alt="FRED"', ['alt' => 'FRED']],  //6
				[' border="4"', ['border'=>'4']],    //7
				[' alt="FRED" border="4" snow="somesnow"', ['alt'=>'FRED', 'border'=>'4','snow'=>'somesnow']],   //8
				[' alt="FRED" border="4" snow="somesnow"', ['alt="FRED"', 'border="4"','snow="somesnow"']],   //9
				[' alt=FRED border=4 snow=somesnow', ['alt=FRED', 'border=4','snow=somesnow']],   //10



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

	function x () {
		$o = new ExtendedHTML();

		$out = $o->extended_parseOptions();
		$this->assertEquals('', $out);

		$out = $o->extended_parseOptions(array());
		$this->assertEquals('', $out);

		$options = 'alt=FRED';
		$out = $o->extended_parseOptions($options);
		$this->assertEquals(' alt=FRED', $out);


		$options = array('alt' => 'FRED');
		$out = $o->extended_parseOptions($options);
		$this->assertEquals(' alt="FRED"', $out);

		$options['border'] = '4';
		$out = $o->extended_parseOptions($options);
		$this->assertEquals(' alt="FRED" border="4"', $out);

		$options['snow'] = 'somesnow';
		$out = $o->extended_parseOptions($options);
		$this->assertEquals(' alt="FRED" border="4" snow="somesnow"', $out);

		$options['something'] = 'something else';
		$out = $o->extended_parseOptions($options);
		$this->assertEquals(' alt="FRED" border="4" snow="somesnow" something="something else"', $out);
	}

	function test_parseStyle() {
		$o = new ExtendedHTML();

		$out = $o->extended_parseStyle();
		$this->assertEquals('', $out);

		$style = 'backgroundcolor: yellow';
		$out = $o->extended_parseStyle($style);
		$this->assertEquals(' style="backgroundcolor: yellow"', $out);

		$out = $o->extended_parseStyle(array());
		$this->assertEquals('', $out);

		$style = array('backgroundcolor' => 'yellow');
		$out = $o->extended_parseStyle($style);
		$this->assertEquals(' style="backgroundcolor: yellow;"', $out);

		$style['forground-color'] = 'blue';
		$out = $o->extended_parseStyle($style);
		$this->assertEquals(' style="backgroundcolor: yellow; forground-color: blue;"', $out);

		$style['encode'] = 'cyan';
		$out = $o->extended_parseStyle($style);
		$this->assertEquals(' style="backgroundcolor: yellow; forground-color: blue; encode: cyan;"', $out);

		$style['font'] = '13px "Arial",sans-serif';
		$out = $o->extended_parseStyle($style);
		$this->assertEquals(' style="backgroundcolor: yellow; forground-color: blue; encode: cyan; font: 13px "Arial",sans-serif;"', $out);

		$style['padding'] = '4px 4px 4px 4px';
		$out = $o->extended_parseStyle($style);
		$this->assertEquals(' style="backgroundcolor: yellow; forground-color: blue; encode: cyan; font: 13px "Arial",sans-serif; padding: 4px 4px 4px 4px;"', $out);
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
			['<Input type="BUTTON" name="xx" value="yy">', 'xx', 'yy'],  //9

		];
	}

	/**
	 * @dataProvider DataProvider_Button
	 * @depends test_parseOptions
	 * @depends test_parseStyle
	 */
	function test_Button($expected, $in1=null, $in2=null, $in3=null, $in4=null, $in5=null) {
		$actual = HTML::Button($in1, $in2, $in3, $in4, $in5);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}

	public function DataProvider_CheckBox() {
		return [
			['<Input type="CHECKBOX">'],  //0
			['<Input type="CHECKBOX">', null],  //1
			['<Input type="CHECKBOX" name="a">', 'a'],  //2
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
	function test_CheckBox($expected, $in1=null, $in2=null, $in3=null, $in4=null, $in5=null, $in6=null) {
		$actual = HTML::CheckBox($in1, $in2, $in3, $in4, $in5, $in6);
		$expected .= PHP_EOL ;
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

	function extended_Options($v, $defaultItemView = null, $addDefaultSelection = null) {
		return parent::Options($v, $defaultItemView, $addDefaultSelection);
	}

}