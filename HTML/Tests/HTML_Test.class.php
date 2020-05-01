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

			['<a href="" z>y</a>', '', 'y', ['z'] ],
			['<a href="" z>y</a>', null, 'y', ['z'] ],
			['<a href="x" z>y</a>', 'x', 'y', ['z'] ],
			['<a href="xx" zz>yy</a>', 'xx', 'yy', ['zz'] ],

			['<a href="" z a>y</a>', '', 'y', ['z', 'a'] ],
			['<a href="" z a>y</a>', null, 'y', ['z', 'a'] ],
			['<a href="x" z a>y</a>', 'x', 'y', ['z', 'a'] ],
			['<a href="xx" zz aa>yy</a>', 'xx', 'yy', ['zz', 'aa'] ],

			['<a href="" z a b>y</a>', '', 'y', ['z', 'a', 'b'] ],
			['<a href="" z a b>y</a>', null, 'y', ['z', 'a', 'b'] ],
			['<a href="x" z a b>y</a>', 'x', 'y', ['z', 'a', 'b'] ],
			['<a href="xx" zz aa bb>yy</a>', 'xx', 'yy', ['zz', 'aa', 'bb'] ],

			['<a href=""></a>', null, null, null,null],
			['<a href="X">X</a>', 'X', '', '', ''],
			['<a href="X">X</a>', 'X', null, '', ''],
			['<a href="" z style="m">y</a>', '', 'y', 'z', 'm'],  //13
			['<a href="" z style="m">y</a>', null, 'y', 'z', 'm'],
			['<a href="x" z style="m">y</a>', 'x', 'y', 'z', 'm'],
			['<a href="xx" zz style="mm">yy</a>', 'xx', 'yy', 'zz', 'mm'],

			['<a href="" z style="m">y</a>', '', 'y', ['z'], 'm'],
			['<a href="" z style="m">y</a>', null, 'y', ['z'], 'm' ],
			['<a href="x" z style="m">y</a>', 'x', 'y', ['z'], 'm' ],
			['<a href="xx" zz style="m">yy</a>', 'xx', 'yy', ['zz'], 'm' ],


			['<a href="" z a style="n">y</a>', '', 'y', ['z', 'a'], 'n' ],
			['<a href="" z a style="n">y</a>', null, 'y', ['z', 'a'], 'n' ],
			['<a href="x" z a style="n">y</a>', 'x', 'y', ['z', 'a'], 'n' ],
			['<a href="xx" zz aa style="nn">yy</a>', 'xx', 'yy', ['zz', 'aa'], 'nn' ],

			['<a href="" z a style="0: n;">y</a>', '', 'y', ['z', 'a'], ['n'] ],
			['<a href="" z a style="0: n;">y</a>', null, 'y', ['z', 'a'], ['n'] ],
			['<a href="x" z a style="0: n;">y</a>', 'x', 'y', ['z', 'a'], ['n'] ],
			['<a href="xx" zz aa style="0: nn;">yy</a>', 'xx', 'yy', ['zz', 'aa'], ['nn'] ],

			['<a href="" z a style="0: n; 1: o;">y</a>', '', 'y', ['z', 'a'], ['n', 'o'] ],
			['<a href="" z a style="0: n; 1: o;">y</a>', null, 'y', ['z', 'a'], ['n', 'o'] ],
			['<a href="x" z a style="0: n; 1: o;">y</a>', 'x', 'y', ['z', 'a'], ['n', 'o'] ],
			['<a href="xx" zz aa style="0: nn; 1: oo;">yy</a>', 'xx', 'yy', ['zz', 'aa'], ['nn', 'oo'] ],
		];
	}

	/**
	 * @dataProvider DataProvider_Anchor
	 */
	function test_Anchor($expected, $in1=null, $in2=null, $in3=null, $in4=null, $in5=null) {
		$this->assertEquals( $expected, HTML::Anchor($in1, $in2, $in3, $in4, $in5));
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


			['<Input type="BUTTON">', null, null, null],
			['<Input type="BUTTON" name="X">', 'X', '', ''],
			['<Input type="BUTTON" name="X">', 'X', null, ''],
			['<Input type="BUTTON" value="y" z>', '', 'y', 'z'],  //13
			['<Input type="BUTTON" value="y" z>', null, 'y', 'z'],
			['<Input type="BUTTON" name="x" value="y" z>', 'x', 'y', 'z'],  //15
			['<Input type="BUTTON" name="xx" value="yy" zz>', 'xx', 'yy', 'zz'],

			['<Input type="BUTTON" value="y" z>', '', 'y', ['z'] ], //17
			['<Input type="BUTTON" value="y" z>', null, 'y', ['z'] ],
			['<Input type="BUTTON" name="x" value="y" z>', 'x', 'y', ['z'] ],
			['<Input type="BUTTON" name="xx" value="yy" zz>', 'xx', 'yy', ['zz'] ],  //20

			['<Input type="BUTTON" value="y" z a>', '', 'y', ['z', 'a'] ],
			['<Input type="BUTTON" value="y" z a>', null, 'y', ['z', 'a'] ],
			['<Input type="BUTTON" name="x" value="y" z a>', 'x', 'y', ['z', 'a'] ],
			['<Input type="BUTTON" name="xx" value="yy" zz aa>', 'xx', 'yy', ['zz', 'aa'] ],  //24

			['<Input type="BUTTON" value="y" z a b>', '', 'y', ['z', 'a', 'b'] ],
			['<Input type="BUTTON" value="y" z a b>', null, 'y', ['z', 'a', 'b'] ],
			['<Input type="BUTTON" name="x" value="y" z a b>', 'x', 'y', ['z', 'a', 'b'] ],
			['<Input type="BUTTON" name="xx" value="yy" zz aa bb>', 'xx', 'yy', ['zz', 'aa', 'bb'] ],   //28

			['<Input type="BUTTON">', null, null, null,null],
			['<Input type="BUTTON" name="X">', 'X', '', '', ''],
			['<Input type="BUTTON" name="X">', 'X', null, '', ''],
			['<Input type="BUTTON" value="y" z style="m">', '', 'y', 'z', 'm'],
			['<Input type="BUTTON" value="y" z style="m">', null, 'y', 'z', 'm'],
			['<Input type="BUTTON" name="x" value="y" z style="m">', 'x', 'y', 'z', 'm'],
			['<Input type="BUTTON" name="xx" value="yy" zz style="mm">', 'xx', 'yy', 'zz', 'mm'],    //35

			['<Input type="BUTTON" value="y" z style="m">', '', 'y', ['z'], 'm'],
			['<Input type="BUTTON" value="y" z style="m">', null, 'y', ['z'], 'm' ],
			['<Input type="BUTTON" name="x" value="y" z style="m">', 'x', 'y', ['z'], 'm' ],
			['<Input type="BUTTON" name="xx" value="yy" zz style="m">', 'xx', 'yy', ['zz'], 'm' ], //39


			['<Input type="BUTTON" value="y" z a style="n">', '', 'y', ['z', 'a'], 'n' ],
			['<Input type="BUTTON" value="y" z a style="n">', null, 'y', ['z', 'a'], 'n' ],
			['<Input type="BUTTON" name="x" value="y" z a style="n">', 'x', 'y', ['z', 'a'], 'n' ],
			['<Input type="BUTTON" name="xx" value="yy" zz aa style="nn">', 'xx', 'yy', ['zz', 'aa'], 'nn' ],        //43

			['<Input type="BUTTON" value="y" z a style="0: n;">', '', 'y', ['z', 'a'], ['n'] ],
			['<Input type="BUTTON" value="y" z a style="0: n;">', null, 'y', ['z', 'a'], ['n'] ],
			['<Input type="BUTTON" name="x" value="y" z a style="0: n;">', 'x', 'y', ['z', 'a'], ['n'] ],
			['<Input type="BUTTON" name="xx" value="yy" zz aa style="0: nn;">', 'xx', 'yy', ['zz', 'aa'], ['nn'] ],   //47

			['<Input type="BUTTON" value="y" z a style="0: n; 1: o;">', '', 'y', ['z', 'a'], ['n', 'o'] ],
			['<Input type="BUTTON" value="y" z a style="0: n; 1: o;">', null, 'y', ['z', 'a'], ['n', 'o'] ],
			['<Input type="BUTTON" name="x" value="y" z a style="0: n; 1: o;">', 'x', 'y', ['z', 'a'], ['n', 'o'] ],
			['<Input type="BUTTON" name="xx" value="yy" zz aa style="0: nn; 1: oo;">', 'xx', 'yy', ['zz', 'aa'], ['nn', 'oo'] ],       //51

			['<Input type="BUTTON" name="xx" value="yy" zz aa style="backgroundcolor: yellow;">',
				'xx', 'yy', ['zz', 'aa'], ['backgroundcolor' => 'yellow'] ],

		];
	}

	/**
	 * @dataProvider DataProvider_Button
	 */
	function test_Button($expected, $in1=null, $in2=null, $in3=null, $in4=null, $in5=null) {
		$actual = HTML::Button($in1, $in2, $in3, $in4, $in5);
		$expected .= PHP_EOL ;
		$this->assertEquals( $expected, $actual);
	}


		function test_parseOptions() {
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