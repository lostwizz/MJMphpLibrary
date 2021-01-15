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

	const ALL_PRESETS			 = -99999;
	const DEFAULT_TEMP_PRESET	 = -1;

	public static $listOfPresets = [];

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
	 * @param type $whichPreset
	 * @return void
	 */
	public static function initialize($whichPreset = self::DEFAULT_TEMP_PRESET): void {
		DebugPresets_Table::initialize();
		self::$listOfPresets = DebugPresets_Table::$listOfPresets;
		DebugSystem::setCurrentPresetId($whichPreset);
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public static function handlePresetDetailsChange(): void {
		self::handleCurrentPreset();

		self::handleAttributeChanges();
		self::handlePresetListOfItemChanges();
//		self::doShowAddPreset();
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public static function handleCurrentPreset(): void {
		$possible_preset_id = (int) filter_input(INPUT_POST, 'preset_id', FILTER_SANITIZE_NUMBER_INT);

		$prev_preset_id = (int) filter_input(INPUT_POST, 'prev_preset_id', FILTER_SANITIZE_NUMBER_INT);

		if ( $possible_preset_id != $prev_preset_id) {
			DebugSystem::$wasPresetJustChanged = true;
		} else {
			DebugSystem::$wasPresetJustChanged = false;
		}

		if (!empty($possible_preset_id)) {
			DebugSystem::setCurrentPresetId($possible_preset_id);
		} else {
			//$_POST['preset_id'] = DebugPresets::DEFAULT_TEMP_PRESET;
			DebugSystem::setCurrentPresetId(DebugPresets::DEFAULT_TEMP_PRESET);
		}
	}



	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public static function handleAttributeChanges() : void {
		foreach( self::$listOfPresets as $p) {
			$anyDetailsNeedChanging = false;
			$id = $p->preset_id;

			if ( $p->name != $_POST['preset_name'][$id]) {
				$str = $_POST['preset_name'][$id];
				$p->name = (string)filter_var($str, FILTER_SANITIZE_STRING);
				$anyDetailsNeedChanging = true;
			}

			if ( $p->description != $_POST['preset_desc'][$id]) {
				$str = $_POST['preset_desc'][$id];
				$p->description = (string)filter_var($str, FILTER_SANITIZE_STRING);
				$anyDetailsNeedChanging = true;
			}
			if ( $anyDetailsNeedChanging) {
				DebugPresets_Table::updatePreset( $p);
			}
		}

		if (!empty($_POST['Add_Preset']) && $_POST['Add_Preset'] == 'Add New Preset') {
			self::doShowAddPreset();
		}

	}

	/** --------------------------------------------------------------------------
	 *
	 */
	protected static function doShowAddPreset() {
		$newPreset = new DebugAPreset();
		$newPreset->name = 'New Preset';
		///////////$newPreset->listOfItemIds = join(',', self::listOfItemIds);

		$newPresetId = DebugPresets_Table::insertPreset($newPreset);
		$newPreset->preset_id = $newPresetId;
		self::$listOfPresets[$newPresetId] = $newPreset;


	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $arr
	 * @return void
	 */
	public static function handlePresetListOfItemChanges(): void {

		if (! DebugSystem::$wasPresetJustChanged) {
			$arr = [];
			if (!empty($_POST['item_ids'])) {
				foreach ($_POST['item_ids'] as $i) {
					$j		 = (int) filter_var($i, FILTER_SANITIZE_NUMBER_INT);
					$arr[$j] = $j;
				}
			}

			$currPresetID	 = DebugSystem::giveCurrentPresetId();
			$preset			 = self::$listOfPresets[$currPresetID];
			$presetItems	 = &$preset->listOfItemIds;
			$presetItems	 = $arr;

			DebugPresets_Table::updatePreset($preset);
		}
	}

}
