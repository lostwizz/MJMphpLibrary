<?php

declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

/**
 * Description of DebugPresets
 *
 * @author lost_
 */
class DebugPresets {

	const ALL_PRESETS = -99999;
	const DEFAULT_TEMP_PRESET = -1;

	//public static $listOfPresets = [];
	public static $listOfItems = [];


	/** --------------------------------------------------------------------------
	 */
	public static function initialize($whichPreset = self::DEFAULT_TEMP_PRESET): void {
		DebugPresets_Table::initialize();
		DebugPresetItems_Table::initialize($whichPreset);
		self::$listOfItems = DebugPresetItems_Table::$itemIds;
		self::BuildItemList();
	}

	protected static function BuildItemList(): void {

	}

}
