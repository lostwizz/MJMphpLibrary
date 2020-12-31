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
	 * @return void
	 */
	public static function showDebugSettingSetup(bool $showForm = false): void {

dump::dump(DebugPresets::$listOfPresets );
		if ($showForm) {
			echo '<form type="POST" action=index.php>';
			echo '<input type=submit name=submit value="Submit form">';
			echo '<input type=submit name="Add_Preset" value="Add New Preset">';
			echo '<input type=submit name="Add_Item" value="Add New Item">';
		}

//		echo '<BR><br>';
//
//		self::showPresets();

		echo '<BR><BR>' . PHP_EOL;

		self::showItems();

		if ($showForm) {
			echo '<input type=submit name=submit value="Submit form">';
			echo '<input type=submit name="Add_Preset" value="Add New Preset">';
			echo '<input type=submit name="Add_Item" value="Add New Item">';
			echo '</form>';
		}
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

		foreach (DebugPresets::$listOfPresets as $i) {
			echo '<tr><td>';
			echo '<input type="radio" name="preset_id" value="' . $i->preset_id . '">';
			echo '</td><td style="text-align: center;">';
			echo $i->preset_id;
			echo '</td><td>';
			echo $i->name;
			echo '</td><td>';
			echo $i->description;
			echo '</td><td>';
			print_r( $i);
			echo  join(', ', $i->listOfItemIds );
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
		echo '</th></tr>';
	}

	protected static function showItemDetails(): void {
		//foreach (DebugPresets::$listOfItems as $index) {
		//$i = DebugItems::$listOfItems[$index];
		foreach (DebugItems::$listOfItems as $i) {
			echo '<tr><td>';
			if (in_array($i->item_id, DebugPresets::$listOfItems)) {
				$s = ' checked';
			} else {
				$s='';
			}
			echo '<input type="checkbox" name="item_ids[]" value="' . $i->item_id . '"' . $s . '>';
			echo '</td><td style="text-align: center;">';
			echo $i->item_id;
			echo '</td><td>';
			//echo $i->codex;
			echo '<input type="text" id="codex[' . $i->item_id . ']" name="codex[' . $i->item_id . ']" value="' . $i->codex .'">';
			echo '</td><td>';
			//echo $i->description;
			echo '<input type="text" id="desc[' . $i->item_id . ']"  name="desc[' . $i->item_id . ']" value="' . $i->description .'">';
			echo '</td><td>';
			//echo '<span style="color: ' . $i->foregroundColor . ';">';
			echo $i->foregroundColor;
			//echo '</span>';
			echo '<input type="color" id="forecolor[' . $i->item_id . ']" name="forecolor[' . $i->item_id . ']" value="' . $i->foregroundColor . '">';
			echo '</td><td>';
			//echo '<span style="background-color: ' . $i->backgroundColor . ';">';
			echo $i->backgroundColor;
			echo '<input type="color" id="backcolor[' . $i->item_id . ']" name="backcolor[' . $i->item_id . ']" value="' . $i->backgroundColor . '">';
			//echo '</span>';
			echo '</td><td>';
			//echo $i->textSize;
			echo '<input type="text" id="size[' . $i->item_id . ']" name="size[' . $i->item_id . ']" value="' . $i->textSize .'" maxlength="5" size="5">';
			echo '</td><td>';
			echo decbin($i->flags);
			echo ' (' . $i->flags . ') ';
			//printf('%b', $i->flags);
			echo '</td><td>';
			//if (DebugSystem::IS_DEBUG_DEBUGGING) {	echo '{[' . decbin($i->flags) . ']}';}

			$fakeBT[0] = [
				'file' => 'filename.xxx',
				'line' => '1234',
				'function'=> 'function'];
			$fakeBT[1] = [
				'class'=>'class',
				'object'=> 'object',
				'type'=>'type',
				'args'=> ['arg1', 'arg2', 'arg3']
				];
			DebugSystem::printDebugInfo($i->codex, [' an Example'], $fakeBT);

			echo '</td><td>';
			//echo DebugAnItem::strFlags($i->flags);
			echo DebugAnItem::giveFlagSelect( $i->item_id, $i->flags);
			echo '</td></tr>';
		}
	}

	//public static function prettyBin($flags) : string {
	//}
	/** --------------------------------------------------------------------------
	 */
}
