<?php

declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

Class DebugAnItem {

	public $item_id = -1;
	public $codex = ''; //_REQUEST';
	public $description = 'default';
	public $foreground_color = '#ffffff'; //#0000FF';
	public $background_color = '#C0C0C0';
	public $text_size = '8pt';
	public $flags = 0b0000_0000_0000_0000_0000_0000_0010_0000;

//	public $owner;
//	public $level =5;   //1=low, 5= medium, 9= high
//	public $categoryId = -1;

	public const desc = [
		0                                         => [ 'desc'=>'-None-', 'short'=>'(0)-None'],
		0b0000_0000_0000_0000_0000_0000_0000_0001 => [ 'desc'=>'(1)- show the class in the debug stmt', 'short'=> 'add Class'],
		0b0000_0000_0000_0000_0000_0000_0000_0010 => [ 'desc'=>'(2)- show the func in the debug stmt', 'short'=> 'add func'],
		0b0000_0000_0000_0000_0000_0000_0000_0100 => [ 'desc'=>'(4)- show the type in the debug stmt', 'short'=> 'add type'],
		0b0000_0000_0000_0000_0000_0000_0000_1000 => [ 'desc'=>'(8)- show the args to func in the debug stmt', 'short'=>'add args'],

		0b0000_0000_0000_0000_0000_0000_0001_0000 => [ 'desc'=>'(16)- bold the line number', 'short'=>'bold line#'],
		0b0000_0000_0000_0000_0000_0000_0010_0000 => [ 'desc'=>'(32)- italics the filename', 'short'=>'italics filename'],
		0b0000_0000_0000_0000_0000_0000_0100_0000 => [ 'desc'=>'(64)- args on different lines', 'short'=>'args diff ln'],
		0b0000_0000_0000_0000_0000_0000_1000_0000 => [ 'desc'=>'(128)- Line Number large', 'short'=>'ln# large'],

		0b0000_0000_0000_0000_0000_0001_0000_0000 => [ 'desc'=>'(256)- show full path', 'short'=>'Path'],

		// => [ 'desc'=>'(128)', 'short'=>''],


	/*
	 *
	 * (256)
	 * (512)
	 * (1024)
	 * (2048)
	 *
	 * (4096)
	 * (8192)
	 * (16,384)
	 * (32,768)
	 *
	 * (65,536)
	 * (131,072)
	 * (262,144)
	 * (524,288)
	 *
	 * (1,048,576)
	 * (2,097,152)
	 * (4,194,304)
	 * (8,388,608)
	 *
	 * (16,777,216)
	 * (33,554,432)
	 * (67,108,864)
	 * (134,217,728)
	 *
	 * (268,435,456)
	 * (536,870,912)
	 * (1,073,741,824)
	 * (2,147,483,648)
	 */
	];

	/**
	 * @var version string
	 */
	private const VERSION = '0.0.1';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}


//	/** --------------------------------------------------------------------------
//	 */
//	public static function initialize() :void {
//
//	}


	/* ----------------------------------------------------------------------------
	 *
	 */
	public static function strFlags( $flag ) {

		//$r = self::desc[0]['short'];
		$r='';

		$m =1;
		$max = (array_key_last ( self::desc) *2) -1 ;
		while ( $m <  $max ) {
			//echo 'm=' , $m;
			if (( $flag & $m ) == $m) {
				$r .=  '&nbsp;|&nbsp;' . self::desc[$m]['short'];
			}
			$m = $m << 1;
		}
		return substr( $r, strlen('&nbsp;|&nbsp;'));;
	}



	/* ----------------------------------------------------------------------------
	 * <label for='formCountries[]'>Select the countries that you have visited:</label><br>
	 * <select multiple="multiple" name="formCountries[]">
	 * 		<option value="US">United States</option>
	 * 		<option value="UK">United Kingdom</option>
	 * 		<option value="France">France</option>
	 * 		<option value="Mexico">Mexico</option>
	 * 		<option value="Russia">Russia</option>
	 * 		<option value="Japan">Japan</option>
	 * 	</select>
	 */

	public static function giveFlagSelect($index, $value): string {
		$r = '';

		$num = min(count(self::desc), 4);
		$r	 .= '<select size="'
				. $num
				. '" multiple="multiple" name="flags[' . $index . '][]">';

		foreach (self::desc as $k => $f) {
			$r .= '<option value="' . $k . '"';
			if ((( $value & $k ) == $k) && ($k != 0 )) {
				$r .= ' selected';
			}
			$r .= '>' . $f['short'] . '</option>';
		}
		$r .= '</select>';
		return $r;
	}

	/* ----------------------------------------------------------------------------
	 *
	 */
	public  function __toString(){
		return serialize($this);
	}
}
