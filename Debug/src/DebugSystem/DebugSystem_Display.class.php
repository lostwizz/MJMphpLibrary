<?php

declare(strict_types=1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpClasses.class.php');

use MJMphpLibrary\Debug\Dump as Dump;

/**
 * Description of DebugSystem_Display
 *
 * @author lost_
 */
class DebugSystem_Display {


	private static $listOfHighlightedItemIDs = [];

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

	/** --------------------------------------------------------------------------
	 *
	 * @staticvar type $Colors
	 * @param type $Colorname
	 * @return string
	 *
	 * GetColor  returns  an  associative  array  with  the  red,  green  and  blue
	 *             values  of  the  desired  color
	 */
	public static FUNCTION GetColor($Colorname) {
		static $Colors = null;

		if (empty($Colors)) {
			$Colors = array(
//  Colors  as  they  are  defined  in  HTML  3.2
				"black"					 => array("red" => 0x00, "green" => 0x00, "blue" => 0x00),
				"maroon"				 => array("red" => 0x80, "green" => 0x00, "blue" => 0x00),
				"green"					 => array("red" => 0x00, "green" => 0x80, "blue" => 0x00),
				"olive"					 => array("red" => 0x80, "green" => 0x80, "blue" => 0x00),
				"navy"					 => array("red" => 0x00, "green" => 0x00, "blue" => 0x80),
				"purple"				 => array("red" => 0x80, "green" => 0x00, "blue" => 0x80),
				"teal"					 => array("red" => 0x00, "green" => 0x80, "blue" => 0x80),
				"gray"					 => array("red" => 0x80, "green" => 0x80, "blue" => 0x80),
				"silver"				 => array("red" => 0xC0, "green" => 0xC0, "blue" => 0xC0),
				"red"					 => array("red" => 0xFF, "green" => 0x00, "blue" => 0x00),
				"lime"					 => array("red" => 0x00, "green" => 0xFF, "blue" => 0x00),
				"yellow"				 => array("red" => 0xFF, "green" => 0xFF, "blue" => 0x00),
				"blue"					 => array("red" => 0x00, "green" => 0x00, "blue" => 0xFF),
				"fuchsia"				 => array("red" => 0xFF, "green" => 0x00, "blue" => 0xFF),
				"aqua"					 => array("red" => 0x00, "green" => 0xFF, "blue" => 0xFF),
				"white"					 => array("red" => 0xFF, "green" => 0xFF, "blue" => 0xFF),
//  Additional  colors  as  they  are  used  by  Netscape  and  IE
				"aliceblue"				 => array("red" => 0xF0, "green" => 0xF8, "blue" => 0xFF),
				"antiquewhite"			 => array("red" => 0xFA, "green" => 0xEB, "blue" => 0xD7),
				"aquamarine"			 => array("red" => 0x7F, "green" => 0xFF, "blue" => 0xD4),
				"azure"					 => array("red" => 0xF0, "green" => 0xFF, "blue" => 0xFF),
				"beige"					 => array("red" => 0xF5, "green" => 0xF5, "blue" => 0xDC),
				"blueviolet"			 => array("red" => 0x8A, "green" => 0x2B, "blue" => 0xE2),
				"brown"					 => array("red" => 0xA5, "green" => 0x2A, "blue" => 0x2A),
				"burlywood"				 => array("red" => 0xDE, "green" => 0xB8, "blue" => 0x87),
				"cadetblue"				 => array("red" => 0x5F, "green" => 0x9E, "blue" => 0xA0),
				"chartreuse"			 => array("red" => 0x7F, "green" => 0xFF, "blue" => 0x00),
				"chocolate"				 => array("red" => 0xD2, "green" => 0x69, "blue" => 0x1E),
				"coral"					 => array("red" => 0xFF, "green" => 0x7F, "blue" => 0x50),
				"cornflowerblue"		 => array("red" => 0x64, "green" => 0x95, "blue" => 0xED),
				"cornsilk"				 => array("red" => 0xFF, "green" => 0xF8, "blue" => 0xDC),
				"crimson"				 => array("red" => 0xDC, "green" => 0x14, "blue" => 0x3C),
				"darkblue"				 => array("red" => 0x00, "green" => 0x00, "blue" => 0x8B),
				"darkcyan"				 => array("red" => 0x00, "green" => 0x8B, "blue" => 0x8B),
				"darkgoldenrod"			 => array("red" => 0xB8, "green" => 0x86, "blue" => 0x0B),
				"darkgray"				 => array("red" => 0xA9, "green" => 0xA9, "blue" => 0xA9),
				"darkgreen"				 => array("red" => 0x00, "green" => 0x64, "blue" => 0x00),
				"darkkhaki"				 => array("red" => 0xBD, "green" => 0xB7, "blue" => 0x6B),
				"darkmagenta"			 => array("red" => 0x8B, "green" => 0x00, "blue" => 0x8B),
				"darkolivegreen"		 => array("red" => 0x55, "green" => 0x6B, "blue" => 0x2F),
				"darkorange"			 => array("red" => 0xFF, "green" => 0x8C, "blue" => 0x00),
				"darkorchid"			 => array("red" => 0x99, "green" => 0x32, "blue" => 0xCC),
				"darkred"				 => array("red" => 0x8B, "green" => 0x00, "blue" => 0x00),
				"darksalmon"			 => array("red" => 0xE9, "green" => 0x96, "blue" => 0x7A),
				"darkseagreen"			 => array("red" => 0x8F, "green" => 0xBC, "blue" => 0x8F),
				"darkslateblue"			 => array("red" => 0x48, "green" => 0x3D, "blue" => 0x8B),
				"darkslategray"			 => array("red" => 0x2F, "green" => 0x4F, "blue" => 0x4F),
				"darkturquoise"			 => array("red" => 0x00, "green" => 0xCE, "blue" => 0xD1),
				"darkviolet"			 => array("red" => 0x94, "green" => 0x00, "blue" => 0xD3),
				"deeppink"				 => array("red" => 0xFF, "green" => 0x14, "blue" => 0x93),
				"deepskyblue"			 => array("red" => 0x00, "green" => 0xBF, "blue" => 0xFF),
				"dimgray"				 => array("red" => 0x69, "green" => 0x69, "blue" => 0x69),
				"dodgerblue"			 => array("red" => 0x1E, "green" => 0x90, "blue" => 0xFF),
				"firebrick"				 => array("red" => 0xB2, "green" => 0x22, "blue" => 0x22),
				"floralwhite"			 => array("red" => 0xFF, "green" => 0xFA, "blue" => 0xF0),
				"forestgreen"			 => array("red" => 0x22, "green" => 0x8B, "blue" => 0x22),
				"gainsboro"				 => array("red" => 0xDC, "green" => 0xDC, "blue" => 0xDC),
				"ghostwhite"			 => array("red" => 0xF8, "green" => 0xF8, "blue" => 0xFF),
				"gold"					 => array("red" => 0xFF, "green" => 0xD7, "blue" => 0x00),
				"goldenrod"				 => array("red" => 0xDA, "green" => 0xA5, "blue" => 0x20),
				"greenyellow"			 => array("red" => 0xAD, "green" => 0xFF, "blue" => 0x2F),
				"honeydew"				 => array("red" => 0xF0, "green" => 0xFF, "blue" => 0xF0),
				"hotpink"				 => array("red" => 0xFF, "green" => 0x69, "blue" => 0xB4),
				"indianred"				 => array("red" => 0xCD, "green" => 0x5C, "blue" => 0x5C),
				"indigo"				 => array("red" => 0x4B, "green" => 0x00, "blue" => 0x82),
				"ivory"					 => array("red" => 0xFF, "green" => 0xFF, "blue" => 0xF0),
				"khaki"					 => array("red" => 0xF0, "green" => 0xE6, "blue" => 0x8C),
				"lavender"				 => array("red" => 0xE6, "green" => 0xE6, "blue" => 0xFA),
				"lavenderblush"			 => array("red" => 0xFF, "green" => 0xF0, "blue" => 0xF5),
				"lawngreen"				 => array("red" => 0x7C, "green" => 0xFC, "blue" => 0x00),
				"lemonchiffon"			 => array("red" => 0xFF, "green" => 0xFA, "blue" => 0xCD),
				"lightblue"				 => array("red" => 0xAD, "green" => 0xD8, "blue" => 0xE6),
				"lightcoral"			 => array("red" => 0xF0, "green" => 0x80, "blue" => 0x80),
				"lightcyan"				 => array("red" => 0xE0, "green" => 0xFF, "blue" => 0xFF),
				"lightgoldenrodyellow"	 => array("red" => 0xFA, "green" => 0xFA, "blue" => 0xD2),
				"lightgreen"			 => array("red" => 0x90, "green" => 0xEE, "blue" => 0x90),
				"lightgrey"				 => array("red" => 0xD3, "green" => 0xD3, "blue" => 0xD3),
				"lightpink"				 => array("red" => 0xFF, "green" => 0xB6, "blue" => 0xC1),
				"lightsalmon"			 => array("red" => 0xFF, "green" => 0xA0, "blue" => 0x7A),
				"lightseagreen"			 => array("red" => 0x20, "green" => 0xB2, "blue" => 0xAA),
				"lightskyblue"			 => array("red" => 0x87, "green" => 0xCE, "blue" => 0xFA),
				"lightslategray"		 => array("red" => 0x77, "green" => 0x88, "blue" => 0x99),
				"lightsteelblue"		 => array("red" => 0xB0, "green" => 0xC4, "blue" => 0xDE),
				"lightyellow"			 => array("red" => 0xFF, "green" => 0xFF, "blue" => 0xE0),
				"limegreen"				 => array("red" => 0x32, "green" => 0xCD, "blue" => 0x32),
				"linen"					 => array("red" => 0xFA, "green" => 0xF0, "blue" => 0xE6),
				"mediumaquamarine"		 => array("red" => 0x66, "green" => 0xCD, "blue" => 0xAA),
				"mediumblue"			 => array("red" => 0x00, "green" => 0x00, "blue" => 0xCD),
				"mediumorchid"			 => array("red" => 0xBA, "green" => 0x55, "blue" => 0xD3),
				"mediumpurple"			 => array("red" => 0x93, "green" => 0x70, "blue" => 0xD0),
				"mediumseagreen"		 => array("red" => 0x3C, "green" => 0xB3, "blue" => 0x71),
				"mediumslateblue"		 => array("red" => 0x7B, "green" => 0x68, "blue" => 0xEE),
				"mediumspringgreen"		 => array("red" => 0x00, "green" => 0xFA, "blue" => 0x9A),
				"mediumturquoise"		 => array("red" => 0x48, "green" => 0xD1, "blue" => 0xCC),
				"mediumvioletred"		 => array("red" => 0xC7, "green" => 0x15, "blue" => 0x85),
				"midnightblue"			 => array("red" => 0x19, "green" => 0x19, "blue" => 0x70),
				"mintcream"				 => array("red" => 0xF5, "green" => 0xFF, "blue" => 0xFA),
				"mistyrose"				 => array("red" => 0xFF, "green" => 0xE4, "blue" => 0xE1),
				"moccasin"				 => array("red" => 0xFF, "green" => 0xE4, "blue" => 0xB5),
				"navajowhite"			 => array("red" => 0xFF, "green" => 0xDE, "blue" => 0xAD),
				"oldlace"				 => array("red" => 0xFD, "green" => 0xF5, "blue" => 0xE6),
				"olivedrab"				 => array("red" => 0x6B, "green" => 0x8E, "blue" => 0x23),
				"orange"				 => array("red" => 0xFF, "green" => 0xA5, "blue" => 0x00),
				"orangered"				 => array("red" => 0xFF, "green" => 0x45, "blue" => 0x00),
				"orchid"				 => array("red" => 0xDA, "green" => 0x70, "blue" => 0xD6),
				"palegoldenrod"			 => array("red" => 0xEE, "green" => 0xE8, "blue" => 0xAA),
				"palegreen"				 => array("red" => 0x98, "green" => 0xFB, "blue" => 0x98),
				"paleturquoise"			 => array("red" => 0xAF, "green" => 0xEE, "blue" => 0xEE),
				"palevioletred"			 => array("red" => 0xDB, "green" => 0x70, "blue" => 0x93),
				"papayawhip"			 => array("red" => 0xFF, "green" => 0xEF, "blue" => 0xD5),
				"peachpuff"				 => array("red" => 0xFF, "green" => 0xDA, "blue" => 0xB9),
				"peru"					 => array("red" => 0xCD, "green" => 0x85, "blue" => 0x3F),
				"pink"					 => array("red" => 0xFF, "green" => 0xC0, "blue" => 0xCB),
				"plum"					 => array("red" => 0xDD, "green" => 0xA0, "blue" => 0xDD),
				"powderblue"			 => array("red" => 0xB0, "green" => 0xE0, "blue" => 0xE6),
				"rosybrown"				 => array("red" => 0xBC, "green" => 0x8F, "blue" => 0x8F),
				"royalblue"				 => array("red" => 0x41, "green" => 0x69, "blue" => 0xE1),
				"saddlebrown"			 => array("red" => 0x8B, "green" => 0x45, "blue" => 0x13),
				"salmon"				 => array("red" => 0xFA, "green" => 0x80, "blue" => 0x72),
				"sandybrown"			 => array("red" => 0xF4, "green" => 0xA4, "blue" => 0x60),
				"seagreen"				 => array("red" => 0x2E, "green" => 0x8B, "blue" => 0x57),
				"seashell"				 => array("red" => 0xFF, "green" => 0xF5, "blue" => 0xEE),
				"sienna"				 => array("red" => 0xA0, "green" => 0x52, "blue" => 0x2D),
				"skyblue"				 => array("red" => 0x87, "green" => 0xCE, "blue" => 0xEB),
				"slateblue"				 => array("red" => 0x6A, "green" => 0x5A, "blue" => 0xCD),
				"slategray"				 => array("red" => 0x70, "green" => 0x80, "blue" => 0x90),
				"snow"					 => array("red" => 0xFF, "green" => 0xFA, "blue" => 0xFA),
				"springgreen"			 => array("red" => 0x00, "green" => 0xFF, "blue" => 0x7F),
				"steelblue"				 => array("red" => 0x46, "green" => 0x82, "blue" => 0xB4),
				"tan"					 => array("red" => 0xD2, "green" => 0xB4, "blue" => 0x8C),
				"thistle"				 => array("red" => 0xD8, "green" => 0xBF, "blue" => 0xD8),
				"tomato"				 => array("red" => 0xFF, "green" => 0x63, "blue" => 0x47),
				"turquoise"				 => array("red" => 0x40, "green" => 0xE0, "blue" => 0xD0),
				"violet"				 => array("red" => 0xEE, "green" => 0x82, "blue" => 0xEE),
				"wheat"					 => array("red" => 0xF5, "green" => 0xDE, "blue" => 0xB3),
				"whitesmoke"			 => array("red" => 0xF5, "green" => 0xF5, "blue" => 0xF5),
				"yellowgreen"			 => array("red" => 0x9A, "green" => 0xCD, "blue" => 0x32));
		}
		if (empty($Colors[strtolower($Colorname)])) {
			return '';
		}
		$x = '#'
				. str_pad(dechex($Colors[$Colorname]['red']), 2, '00')
				. str_pad(dechex($Colors[$Colorname]['green']), 2, '00')
				. str_pad(dechex($Colors[$Colorname]['blue']), 2, '00')
		;
		return $x;
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public static function showDebugSettingSetup(bool $showForm = false): void {

//dump::dump(DebugPresets::$listOfPresets);
		if ($showForm) {
			echo '<form method="POST" action=index.php>';
			self::showSubmitBar();
		}


		self::selfShowTurnOnDebuggingButton( DebugSystem::$IS_DEBUG_DEBUGGING);

		self::showPresets();

		echo '<BR><BR>' . PHP_EOL;

		if ($showForm) {
			self::showSubmitBar();
		}

		echo '<BR><BR>' . PHP_EOL;

		self::showItems();

		if ($showForm) {
			self::showSubmitBar();
			echo '</form>';
		}
	}

	protected static function selfShowTurnOnDebuggingButton( $isOnorOff = false): void {
		echo '<BR>';
		if ($isOnorOff){
			echo '<input type="submit" name="ChangeDebuggingSwitch" value="DebugSystem_TurnOFF" class="OFF_Button">';
		} else {
			echo '<input type="submit" name="ChangeDebuggingSwitch" value="DebugSystem_TurnON" class="ON_Button">';
		}
		echo '<BR>';
	}


	/** --------------------------------------------------------------------------
	 *
	 */
	protected static function showSubmitBar() :void{
		echo '<input type=submit name=submit value="Submit form">';
		echo '<input type=submit name="Add_Preset" value="Add New Preset">';
		echo '<input type=submit name="Add_Item" value="Add New Item">';
		echo '<BR>';
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	protected static function showPresets(): void {
		echo '<table border=1 width=100% style="border: 1px solid black;">';
		self::showHeader();
		self::showPresetDetails();
		echo '</table>' . PHP_EOL;
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	protected static function showHeader(): void {
		echo '<tr><th>';
		echo 'chk';
		echo '</th><th>';
		echo 'Preset Id';
		echo '</th><th>';
		echo 'Preset Name';
		echo '</th><th>';
		echo 'Preset Description';
		echo '</th><th>';
		echo 'items';
		echo '</th></tr>' . PHP_EOL;
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	protected static function showPresetDetails(): void {

		foreach (DebugPresets::$listOfPresets as $p) {
			if ( $p->preset_id == DebugSystem::giveCurrentPresetId() ){
				$selected = ' checked ';
			} else {
				$selected = '';
			}

			echo '<tr><td>';
			echo '<input type="radio" name="preset_id" value="' . $p->preset_id . '"'  . $selected . '>';
			echo '</td><td style="text-align: center;">';
			echo $p->preset_id;
			echo '</td><td>';
			//echo $p->name;
			echo '<input type="text" id="prefix_name[' . $p->preset_id . ']"  name="preset_name[' . $p->preset_id . ']" value="' . $p->name . '">';			echo '</td><td>';
			echo '</td><td>';
			//echo $p->description;
			echo '<input type="text" id="prefix_desc[' . $p->preset_id . ']"  name="preset_desc[' . $p->preset_id . ']" value="' . $p->description . '">';			echo '</td><td>';
			//print_r($i);
			if ( empty($p->listOfItemIds )) {
				echo '';
			}else {
				echo join(', ', $p->listOfItemIds);
			}
			echo '</td></tr>' . PHP_EOL;
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	protected static function showItems(): void {
		echo '<table border=1  width=100% style="border: 1px solid blue;">';
		self::showItemHeader();
		self::showItemDetails();
		echo '</table>' . PHP_EOL;
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	protected static function showItemHeader(): void {
		echo '<tr><th>';
		echo 'chk';
		echo '</th><th>';
		echo 'item id';
		echo '</th><th>';
		echo 'Codex';
		echo '</th><th>';
		echo 'Description';
		echo '</th><th>';
		echo 'Forground';
		echo '</th><th>';
		echo 'Background';
		echo '</th><th>';
		echo 'Text Size';
		echo '</th><th>';
		echo 'Flags';
		echo '</th><th>';
		echo 'Example';
		echo '</th><th>';
		echo 'flag decode';
		echo '</th></tr>' . PHP_EOL;
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $value
	 * @return string|null
	 */
	protected static function sanitizeColor($value): ?string {
		if (empty($value)) {
			return '#FFFFFF';
		}

		if (substr(trim($value), 0, 1) == '#') {
			return $value;
		} else {
			$x = self::GetColor($value);
			//dump::dump($x);
			return $x;
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	protected static function showItemDetails(): void {
		//foreach (DebugPresets::$listOfItems as $index) {
		//$i = DebugItems::$listOfItems[$index];

		$fakeBT[0]	 = [
			'file'		 => 'filename.xxx',
			'line'		 => '1234',
			'function'	 => 'function'];
		$fakeBT[1]	 = [
			'class'	 => 'class',
			'object' => 'object',
			'type'	 => 'type',
			'args'	 => ['arg1', 'arg2', 'arg3']
		];

		$preset_ID = DebugSystem::giveCurrentPresetId();

		$aPreset = DebugPresets::$listOfPresets[$preset_ID];
		$ItemIds = $aPreset->listOfItemIds;
		if ( empty($aPreset->listOfItemIds) ){
			$ItemIds = [];
		}
		if (empty(DebugItems::$listOfItems )) {
			echo '<tr><td></td></tr>';
		} else {
			foreach (DebugItems::$listOfItems as $i) {
				echo '<tr><td>';
				if (in_array($i->item_id, $ItemIds)) {
					$s = ' checked';
				} else {
					$s = '';
				}
				echo '<input type="checkbox" name="item_ids[]" value="' . $i->item_id . '"' . $s . '>';
				echo '</td><td style="text-align: center;">';
				echo $i->item_id;
				echo '</td><td>';
				echo '<input type="text" id="codex[' . $i->item_id . ']" name="codex[' . $i->item_id . ']" value="' . $i->codex . '">';
				echo '</td><td>';
				//echo $i->description;
				echo '<input type="text" id="desc[' . $i->item_id . ']"  name="desc[' . $i->item_id . ']" value="' . $i->description . '">';				echo '</td><td>';
				echo $i->foregroundColor;
				echo '<br>';
				echo ' <input type="color" id="forecolor[' . $i->item_id . ']" name="forecolor[' . $i->item_id . ']" value="' . self::sanitizeColor($i->foregroundColor) . '">';
				echo PHP_EOL;
				echo '</td><td>';
				echo PHP_EOL;
				echo $i->backgroundColor;
				echo '<br>';
				echo ' <input type="color" id="backcolor[' . $i->item_id . ']" name="backcolor[' . $i->item_id . ']" value="' . self::sanitizeColor($i->backgroundColor) . '">';
				echo PHP_EOL;
				echo '</td><td>';
				echo '<input type="text" id="size[' . $i->item_id . ']" name="size[' . $i->item_id . ']" value="' . $i->text_Size . '" maxlength="5" size="5">';
				echo '</td><td>';
				echo decbin($i->flags);
				echo ' (' . $i->flags . ') ';
				echo '</td><td>';

				DebugSystem::printDebugInfo($i->codex, [' an Example'], $fakeBT);

				echo '</td><td>';
				echo DebugAnItem::giveFlagSelect($i->item_id, $i->flags);
				echo '</td></tr>' . PHP_EOL;
			}
		}
	}

}
