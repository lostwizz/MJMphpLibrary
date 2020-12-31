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
 * Description of DebugPresetItems
 *
 * @author lost_
 */
class DebugPresetItems_Table {

	public static $listPresetitemS = [];
	public static $listOfJustItemsForPreset = [];

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
dump::dump( self::$listPresetitemS);
		foreach (self::$listPresetitemS as $i) {
//dump::dump( $i);

			if (!in_array( $i, self::$listOfJustItemsForPreset)) {
				self::$listOfJustItemsForPreset[] = $i;
			}
		}
		sort(self::$listOfJustItemsForPreset);
dump::dump( self::$listOfJustItemsForPreset );
//dump::dump( $this );
//dump::dump( get_class() );
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $whichPreset
	 */
	public static function readPresetsItems($whichPreset) {
		self::$listPresetitemS = [];
		if ($whichPreset == DebugPresets::DEFAULT_TEMP_PRESET) {
			$sql = 'SELECT presetId, presetitemid FROM debug_presetItems';
		} else {
			// this will also cate the DEFAULT_TEMP_PRESET
			$sql = 'SELECT presetId, presetitemid FROM debug_presetItems WHERE presetId = :presetId';
		}
		//foreach( range(1, random_int(1, 5)) as $r ) {
		if (true) {
			self::$listPresetitemS = self::fake_presetsItems($whichPreset);
dump::dump(self::$listPresetitemS);
		} else {
			foreach (range(1, 5) as $r) {
				$aPresetItem = new DebugAPresetItem();
				// process database results
				$aPresetItem['preset_id'] = $r['preset_id'];
				$aPresetItem['item_id'] = $r['item_id'];
			}
			self::$listPresetitemS[] = $aPresetItem;
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $pre
	 * @param type $id
	 * @return type
	 */
	private static function fake_presetsItems($r ) {
		$aPresetItem = new DebugAPresetItem();
		$aPresetItem->preset_id = $r;
		$i = 1;
		switch($r) {
			case 1:
//				$i = \random_int(1,9);
				$i = [1,3,5,7,9];
				break;
			case 2:
				$i = [2,4,6,8,10];
				break;
			case 3:
				$i = [1,2,5,6];
				break;
			case 4:
				$i = [4];
				break;
			case 5:
				$i = [5];
				break;
			case 6:
				$i = [6];
				break;
		}
		$aPresetItem->listOfItemIds = $i;

//dump::dump( $aPresetItem);
		return $aPresetItem;
	}

}
