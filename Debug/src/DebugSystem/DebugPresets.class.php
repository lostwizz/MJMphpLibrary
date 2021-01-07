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
		DebugSystem::setCurrentPresetId( $whichPreset);

//		dump::dump( self::$listOfPresets[DebugSystem::giveCurrentPresetId()]);
//		$x = self::$listOfPresets[DebugSystem::giveCurrentPresetId()];
//
//		dump::dump( $x->listOfItemIds);
	}

}
