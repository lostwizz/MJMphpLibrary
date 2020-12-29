<?php

declare(strict_types=1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

/**
 * Description of DebugSystem_Display
 *
 * @author lost_
 */
class DebugSystem_Display {

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public static function showDebugSettingSetup(bool $showForm = false): void {
		if ($showForm) {
			echo '<form type="post" action=index.php>';
			echo '<input type=submit name=submit value="Submit form">';
			echo '<input type=submit name="Add_Preset" value="Add New Preset">';
			echo '<input type=submit name="Add_Item" value="Add New Item">';
		}

		echo '<BR><br>';

		self::showPresets();

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
		echo '<table border=1 style="border: 1px solid black;">';
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
		echo '</th></tr>' . PHP_EOL;
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	protected static function showPresetDetails(): void {

		foreach (DebugPresets_Table::$listOfPresets as $i) {

			echo '<tr><td>';
			//echo '<input type="checkbox" name="preset_id[]" value="' . $i->preset_id . '">';
			 //<input type="radio" id="male" name="gender" value="male">
			echo '<input type="radio" name="preset_id" value="' . $i->preset_id . '">';
			echo '</td><td>';
			echo $i->preset_id;
			echo '</td><td>';
			echo $i->name;
			echo '</td><td>';
			echo $i->description;
			echo '</td></tr>' . PHP_EOL;
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	protected static function showItems(): void {
		echo '<table border=1 style="border: 1px solid blue;">';
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
		echo '</th></tr>';
	}

	protected static function showItemDetails(): void {
		//foreach (DebugPresets::$listOfItems as $index) {
		//$i = DebugItems::$listOfItems[$index];
		foreach( DebugItems::$listOfItems as $i) {
			echo '<tr><td>';
			echo '<input type="checkbox" name="item_ids[]" value="' . $i->item_id . '">';
			echo '</td><td>';
			echo $i->item_id;
			echo '</td><td>';
			echo $i->codex;
			echo '</td><td>';
			echo $i->description;
			echo '</td><td>';
			echo $i->foregroundColor;
			echo '</td><td>';
			echo $i->backgroundColor;
			echo '</td><td>';
			echo $i->textSize;
			echo '</td><td>';
			echo decbin($i->flags);
			//printf('%b', $i->flags);
			echo '</td></tr>';
		}
	}


	//public static function prettyBin($flags) : string {

	//}
	/** --------------------------------------------------------------------------
	 */
}
