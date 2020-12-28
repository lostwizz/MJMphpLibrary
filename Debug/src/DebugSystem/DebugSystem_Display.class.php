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
		}

		echo '<BR><br>';

		echo '<table border=1 style="border: 1px solid black;">';
		self::showPresets();
		self::showItems();
		echo '</table>' . PHP_EOL;
		if ($showForm) {
			echo '<input type=submit name=submit value="Submit form">';
			echo '</form>';
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	protected static function showPresets(): void {
		self::showHeader();
		self::showPresetDetails();
	}

	protected static function showHeader(): void {
		echo '<tr><th>';
		echo 'chk';
		echo '</th><th>';
		echo 'Preset Id';
		echo '</th><th>';
		echo 'Preset Name';
		echo '</th></tr>' . PHP_EOL;
	}

	protected static function showPresetDetails(): void {
		foreach (DebugPresets_Table::$listOfPresets as $i) {
			echo '<tr><td>';
			echo '<input type="checkbox" name="presetid[]" value="' . $i['presetid'] . '">';
			echo '</td><td>';
			echo $i['presetid'];
			echo '</td><td>';
			echo $i['name'];
			echo '</td></tr>' . PHP_EOL;
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	protected static function showItems(): void {

	}

	/** --------------------------------------------------------------------------
	 */
}
