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

	//public static int $presetItemId;
	//public static int $presetId ;
	public static $itemIds = [];


	public static function initialize( $whichPreset = DebugPresets::DEFAULT_TEMP_PRESET ){
		//self::$presetId = $whichPreset;
		self::readPresets( $whichPreset);
	}

	protected static function readPresets( $whichPreset) {

		if ( $whichPreset == DebugPresets::DEFAULT_TEMP_PRESET) {

			$sql = 'SELECT presetId, presetitemid FROM debug_presetItems';

		} else {
			// this will also cate the DEFAULT_TEMP_PRESET
			$sql = 'SELECT presetId, presetitemid FROM debug_presetItems WHERE presetId = :presetId';
		}

		if (true) {
			self::$itemIds[] = [ 'presetid' => '1', 'presetitemid' => 1 ];
			self::$itemIds[] = [ 'presetid' => '1', 'presetitemid' => 2 ];
			self::$itemIds[] = [ 'presetid' => '1', 'presetitemid' => 3 ];
			self::$itemIds[] = [ 'presetid' => '1', 'presetitemid' => 4 ];
			self::$itemIds[] = [ 'presetid' => '1', 'presetitemid' => 5 ];
		} else {
			// read the database
		}
	}
}
