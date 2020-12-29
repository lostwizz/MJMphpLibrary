<?php

declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

include_once('DebugPresets.class.php');
include_once('DebugSystem_Display.class.php');

include_once('DebugPresets_Table.class.php');
include_once('DebugAPreset.class.php');
include_once('DebugAPresetItem.class.php');
include_once('DebugPresetItems.class.php');
include_once('DebugPresetItems_Table.class.php');

include_once('DebugAnItem.class.php');
include_once('DebugItems.class.php');
include_once('DebugItems_Table.class.php');

include_once('DebugCategories.class.php');

/** ===================================================================================
 *
 */
Class DebugSystem {

	const DEBUG_SHOW_ALL = -1;

	protected static $currPreset = -1;
	/** --------------------------------------------------------------------------
	 *
	 */
	public static function initialize() {
		//echo 'hello world';
		DebugItems::initialize();
		DebugPresets::initialize();
		DebugPresetItems::initialize();

		if (!empty($_REQUEST)) {
			if (!empty($_REQUEST['Add_Item']) && $_REQUEST['Add_Item'] == 'Add New Item') {
				self::doShowAddItem();
			} else if (!empty($_REQUEST['Add_Preset']) && $_REQUEST['Add_Preset'] == 'Add New Preset') {
				self::doShowAddPreset();
			}

			if (!empty($_REQUEST['preset_id'])) {
				/// set the current preset as this id
				self::$currPreset = $_REQUEST['preset_id'] ;
			}
			if (!empty($_REQUEST['item_ids'])) {
				// if have a preset id then add these items to the preset - otherwise just ignore
			}
		}

		//echo '.............done init debugSystem';
	}

	/** --------------------------------------------------------------------------
	 *
	 */
	public static function showSettings() {
		DebugSystem_Display::showDebugSettingSetup(true);
	}

	/** --------------------------------------------------------------------------
	 *
	 */
	protected static function doShowAddItem() {

	}

	/** --------------------------------------------------------------------------
	 *
	 */
	protected static function doShowAddPreset(){

	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $debugCodex
	 * @param type $vars
	 */
	public static function debug($debugCodex = self::DEBUG_SHOW_ALL, ...$vars): void {
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT,2);

		if (self::isAdebugCodex($debugCodex)) {
			self::printDebugInfo($debugCodex, $vars, $bt);
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $debugCodex
	 * @return bool
	 */
	protected static function isAdebugCodex($debugCodex): bool {
		if ($debugCodex === null || $debugCodex == self::DEBUG_SHOW_ALL || empty($debugCodex)) {
			return true;
		}
		$debugCodex = strtoupper($debugCodex);
		foreach (DebugPresets::$listOfItems as $i) {
			$theItem = DebugItems::$listOfItems[$i];
			//echo '>' . $theItem->codex . '<';
			if ($debugCodex == strtoupper($theItem->codex)) {
				return true;
			}
		}
		return false;
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $debugCodex
	 * @return DebugAnItem
	 */
	protected static function findItemWithCodex($debugCodex): DebugAnItem {
		if (!empty($debugCodex)) {
			$debugCodex = strtoupper($debugCodex);
			foreach (DebugPresets::$listOfItems as $i) {
				$theItem = DebugItems::$listOfItems[$i];
				if ($debugCodex == strtoupper($theItem->codex)) {
					return $theItem;
				}
			}
		}
		return new DebugAnItem();
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $vars
	 * @param type $bt
	 */
	protected static function printDebugInfo($debugCodex, $vars, $bt) {
		$debugItem = self::findItemWithCodex($debugCodex);
		echo '&nbsp;';
		echo '<span style="background-color:' . $debugItem->backgroundColor
			. '; color:' . $debugItem->foregroundColor
			. '; font-size:' . ($debugItem->textSize ?? '9pt')
			. ';">';
		foreach ($vars as $v) {
			if (is_string($v) || is_int($v)) {
				echo $v;
			} else {
				echo '<pre style="background-color:' . $debugItem->backgroundColor
					. '; color:' . $debugItem->foregroundColor
					. '; font-size:' . ($debugItem->textSize ?? '9pt')
					. ';">';
				echo print_r($v, true);
				echo '</pre>';
			}
			echo '&nbsp;|&nbsp;';
		}

		if (( $debugItem->flags & 0b0010_0000) == 0b0010_0000) {
			echo '<i>', basename(($bt[0]['file'] ?? 'no_file')) . '</i>';
		} else {
			echo basename(($bt[0]['file'] ?? 'no_file'));
		}

		echo '(';
		if (( $debugItem->flags & 0b0001_0000) == 0b0001_0000) {
			echo '<b>' . ($bt[0]['line'] ?? 'no_line') . '</b>';
		} else {
			echo ($bt[0]['line'] ?? 'no_line');
		}
		echo ')';

		if (( $debugItem->flags & 0b0000_0010) == 0b0000_0010) {
			if (isset($bt[0]['function'])) {
				echo ' func=', $bt[0]['function'] ?? '';
			}
		}
		if (( $debugItem->flags & 0b0000_0001) == 0b0000_0001) {
			if (isset($bt[1]['class'])) {
				echo ' class=', $bt[1]['class'] ?? '';
			}
		}
		if (( $debugItem->flags & 0b0000_0100) == 0b0000_0100) {
			if (isset($bt[1]['type'])) {
				echo ' type=', $bt[1]['type'] ?? '';
			}
		}
		if (( $debugItem->flags & 0b0000_1000) == 0b0000_1000) {
			if (isset($bt[1]['args'])) {
				echo ' args=', join('||', ($bt[1]['args'] ?? ''));
			}
		}
		echo '</span><br>' . PHP_EOL;
	}

}
