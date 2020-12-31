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
 * Description of DebugPresets
 *
 * @author lost_
 */
class DebugPresets {

	const ALL_PRESETS = -99999;
	const DEFAULT_TEMP_PRESET = -1;

	//public static $currentPreset = self::DEFAULT_TEMP_PRESET;
	public static $listOfPresets = [];
	public static $listOfItems = [];

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
	 */
	public static function initialize($whichPreset = self::DEFAULT_TEMP_PRESET): void {
		DebugPresets_Table::initialize();
		self::$listOfPresets = DebugPresets_Table::$listOfPresets;

		foreach (DebugPresets_Table::$listOfPresets as &$preset) {
			DebugPresetItems::initialize($preset->preset_id);

dump::dump( $preset);
			self::$listOfItems = DebugPresetItems_Table::$listOfJustItemsForPreset;
dump::dump( self::$listOfItems );
			if ($preset->preset_id == self::DEFAULT_TEMP_PRESET) {
				$preset->listOfItemIds = array_keys(DebugItems::$listOfItems);
			} else {
				$preset->listOfItemIds = self::$listOfItems;
			}
		}
//		self::put_ini_file( self::$listOfPresets, 'P:\Projects\_PHP_Code\MJMphpLibrary\config\presets.ini', true, true );
		//self::$currentPreset = $whichPreset;
	}



//	public static function put_ini_file($config, $file= 'P:\Projects\_PHP_Code\MJMphpLibrary\config\presets.ini', $has_section = false, $write_to_file = true) {
//		$fileContent = '';
//		////////////////$config = self::$listOfItems;
//		if (!empty($config)) {
//			foreach ($config as $i => $v) {
//				if ($has_section) {
//					$fileContent .= "[$i]" . PHP_EOL . self::put_ini_file($v, $file, false, false);
//				} else {
//					if (is_array($v)) {
//						foreach ($v as $t => $m) {
//							$fileContent .= "$i[$t] = " . (is_numeric($m) ? $m : '"' . $m . '"') . PHP_EOL;
//						}
//					} else $fileContent .= "$i = " . (is_numeric($v) ? $v : '"' . $v . '"') . PHP_EOL;
//				}
//			}
//		}
//
//		if ($write_to_file && strlen($fileContent)) return file_put_contents($file, $fileContent, LOCK_EX);
//		else return $fileContent;
//	}
}
