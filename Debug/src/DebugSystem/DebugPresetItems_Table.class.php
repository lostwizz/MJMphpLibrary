<?php

declare(strict_types=1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

/**
 * Description of DebugPresetItems
 *
 * @author lost_
 */
class DebugPresetItems_Table {

	public static $listPresetitem = [];
	public static $listOfJustItemsForPreset = [];

	/** --------------------------------------------------------------------------
	 *
	 * @param type $whichPreset
	 */
	public static function initialize($whichPreset = DebugPresets::DEFAULT_TEMP_PRESET) {
		self::readPresetsItems($whichPreset);

		//DebugSystem::debug(null, self::$listPresetitem);

		self::processItemsForPreset();
	}

	/** --------------------------------------------------------------------------
	 *
	 */
	protected static function processItemsForPreset() {

		self::$listOfJustItemsForPreset = [];
		$a = array();
		foreach (self::$listPresetitem as $i) {

			if (!in_array( $i->item_id, self::$listOfJustItemsForPreset)) {
				self::$listOfJustItemsForPreset[] = $i->item_id;
			}
		}
		//DebugSystem::debug(null, self::$listOfJustItemsForPreset);
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $whichPreset
	 */
	protected static function readPresetsItems($whichPreset) {

		if ($whichPreset == DebugPresets::DEFAULT_TEMP_PRESET) {
			$sql = 'SELECT presetId, presetitemid FROM debug_presetItems';
		} else {
			// this will also cate the DEFAULT_TEMP_PRESET
			$sql = 'SELECT presetId, presetitemid FROM debug_presetItems WHERE presetId = :presetId';
		}
		foreach (range(1, 5) as $r) {
			foreach (range(1, 6) as $j) {
				if (true) {
					$aPresetItem = self::fake_presets($j, $r);
				} else {
					$aPresetItem = new DebugAPresetItem();
					// process database results
					$aPresetItem['preset_id'] = $r['preset_id'];
					$aPresetItem['item_id'] = $r['item_id'];
				}
				self::$listPresetitem[] = $aPresetItem;
			}
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $pre
	 * @param type $id
	 * @return type
	 */
	private static function fake_presets($pre, $id) {
		$aPresetItem = new DebugAPresetItem();
		//switch($id) {
		//	case 1:
		$aPresetItem->preset_id = $pre;
		$aPresetItem->item_id = $id;
//				break;
//			case 2:
//				break;
//			case 3:
//				break;
//			case 4:
//				break;
//			case 5:
//				break;
//			case 6:
//				break;
//		}
		return $aPresetItem;
	}

}
