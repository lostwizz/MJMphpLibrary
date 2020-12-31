<?php
declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

/**
 * Description of DebugPresets_Table
 *
 * @author lost_
 */
class DebugPresets_Table {
//put your code here
	//public int $presetId;
	//public string $name;

	public static $listOfPresets=[];

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
	public static function initialize(): void {
		self::readTable();
		self::$listOfPresets[DebugPresets::DEFAULT_TEMP_PRESET] = new DebugAPreset();
		self::$listOfPresets[DebugPresets::DEFAULT_TEMP_PRESET]->preset_id = DebugPresets::DEFAULT_TEMP_PRESET;
		self::$listOfPresets[DebugPresets::DEFAULT_TEMP_PRESET]->name = 'Default';
		self::$listOfPresets[DebugPresets::DEFAULT_TEMP_PRESET]->description = 'Default preset with every item';

		//echo '<pre>DebugPresets_Table';
		//print_r(self::$listOfPresets);
		//echo '</pre>';
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public static function readTable() :void {
		$sql = 'SELECT presetid, name, description FROM debug_presets';

		foreach (range(1, 5) as $r) {
			if (true) {
				$preset = self::fake_presets_read($r);
			} else {
				$preset = new DebugAPreset();
				// process the table query results
				//$preset['preset_id'] = $r['preset_id'];
				$preset->preset_id = $r['preset_id'];
				$preset->name = $r['name'];
				$preset->description = $r['description'];
			}
			self::$listOfPresets[ $preset->preset_id ] = $preset;
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $num
	 * @return string
	 */
	private static function fake_presets_read( $num) {
		$preset = new DebugAPreset();
		$preset->preset_id= $num;
		$preset->name = 'all menu times' . $num;
		$preset->description = ' do something with the '. $num;
//		switch ($num){
//			case 1:
//				break;
//			case 2:
//				$preset = ['presetid'=>2, 'name'=> 'preset '.$num, 'description'=> ' do something with the '. $num];
//				break;
//			case 3:
//				$preset = ['presetid'=>3, 'name'=> 'preset '.$num, 'description'=> ' do something with the '. $num];
//				break;
//			case 4:
//				$preset = ['presetid'=>4, 'name'=> 'preset '.$num, 'description'=> ' do something with the '. $num];
//				break;
//		}

		return $preset;
	}


}
