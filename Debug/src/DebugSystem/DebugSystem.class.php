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

//include_once('DebugCategories.class.php');

require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpClasses.class.php');
use MJMphpLibrary\Debug\Dump as Dump;


/** ===================================================================================
 *
 */
Class DebugSystem {

	public const IS_DEBUG_DEBUGGING = true;

	const DEBUG_SHOW_ALL = -1;

	protected static $currPreset = DebugPresets::DEFAULT_TEMP_PRESET;

	public static $dbConn;

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
	 */
	public static function initialize() {

		self::DebugStartDBConnection();

		//echo 'hello world';
		DebugItems::initialize();
//dump::dump(DebugItems::$listOfItems);

		DebugPresets::initialize();

		if (!empty($_REQUEST) && !empty($_REQUEST['preset_id'])) {
			self::$currPreset = $_REQUEST['preset_id'];
		} else {
			$_REQUEST['preset_id'] = DebugPresets::DEFAULT_TEMP_PRESET;
		}

		if (!empty($_REQUEST)) {
			if (!empty($_REQUEST['Add_Item']) && $_REQUEST['Add_Item'] == 'Add New Item') {
				self::doShowAddItem();
			} else if (!empty($_REQUEST['Add_Preset']) && $_REQUEST['Add_Preset'] == 'Add New Preset') {
				self::doShowAddPreset();
			}

			if (!empty($_REQUEST['preset_id'])) {
				/// set the current preset as this id
				self::$currPreset = $_REQUEST['preset_id'];
			}
			if (!empty($_REQUEST['item_ids'])) {
				// if have a preset id then add these items to the preset - otherwise just ignore
			}
		}

		//echo '.............done init debugSystem';
	}

	public static function giveCurrentPresetId(): int {
		return (int)self::$currPreset;
	}

	public static function setCurrentPresetId(int $newVal) {
		self::$currPreset = $newVal;
	}

	public static function giveNumberOfItems(): int {
		return count(DebugItems::$listOfItems);

	}

	/** --------------------------------------------------------------------------
	 *
	 * @throws Exception
	 */
		protected static function DebugStartDBConnection() {
//		if (defined('DB_DATABASE') && defined('DB_SERVER')) {
//			$schema		 = DB_DATABASE;
//			$host		 = DB_SERVER;
//			$username	 = DB_USERNAME;
//			$password	 = DB_PASSWORD;
//		} else {
			$host		 = 'pv00dbsmss01';
			$schema		 = 'CityJETSystem_DEV';
			$username	 = 'jet_system';
			$password	 = 'jet_system99A';
//		}
		try {
			$dsn			 = 'sqlsrv:Server=' . $host . ';Database=' . $schema;
			self::$dbConn	 = new \pdo($dsn, $username, $password);

			self::$dbConn->setattribute(\PDO::ATTR_PERSISTENT, true);
			self::$dbConn->setattribute(\PDO::ATTR_CASE, \PDO::CASE_LOWER);
			self::$dbConn->setattribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			print "<hr>Error!: " . $e->getMessage() . "<br/>";
			print "stmt: " . $e->getCode() . '<br>';
			//trigger_error( "ERROR: Connect to database failed: " . $e->getMessage() ."\n\n");
			throw new Exception("ERROR: Connect to database failed: " . $e->getMessage());
		}
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
	protected static function doShowAddPreset() {

	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $debugCodex
	 * @param type $vars
	 */
	public static function debug($debugCodex = self::DEBUG_SHOW_ALL, ...$vars): void {
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
//dump::dump( $debugCodex);
		if (self::isAdebugCodexInPreset($debugCodex)) {
			self::printDebugInfo($debugCodex, $vars, $bt);
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $debugCodex
	 * @return bool
	 */
	protected static function isAdebugCodexInPreset($debugCodex): bool {
		if ($debugCodex === null || $debugCodex == self::DEBUG_SHOW_ALL || empty($debugCodex)) {
			return true;
		}
		$debugCodex = strtoupper($debugCodex);
		$lll = DebugPresets::$listOfPresets[ self::$currPreset]->listOfItemIds;
		foreach ($lll as $i) {
			$theItem = DebugItems::$listOfItems[$i];

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
	protected static function findPresetItemsWithCodex($debugCodex): DebugAnItem {
		if (!empty($debugCodex)) {
			$debugCodex = strtoupper($debugCodex);
			foreach (DebugItems::$listOfItems as $i) {
				//$theItem = DebugItems::$listOfItems[$i];
				//if ($debugCodex == strtoupper($theItem->codex)) {
//dump::dump( $i);

				if ($debugCodex == strtoupper($i->codex)) {
					//return $theItem;
					return $i;
				}
			}
		}
		return new DebugAnItem();
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $debugItem
	 * @return string
	 */
	protected static function giveStyleOptions($debugItem): string {
		return
			'style="background-color:'
			. ($debugItem->backgroundColor ?? '#ffffff')
			. '; color:' . ($debugItem->foregroundColor ?? '#0000ff')
			. '; font-size:' . ($debugItem->text_Size ?? '9pt')
			. ';"';
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $vars
	 * @param type $bt
	 */
	public static function printDebugInfo($debugCodex, $vars, $bt) {
		//if (self::IS_DEBUG_DEBUGGING) { echo '[{'. $debugCodex .'}]'; }
//dump::dump( $debugCodex);
		$debugItem = self::findPresetItemsWithCodex($debugCodex);
		echo '&nbsp;';
		//if (self::IS_DEBUG_DEBUGGING) { echo '{'. decbin($debugItem->flags ?? 0) .'}'; }

//dump::dump( $debugItem);
		echo '<span ' . self::giveStyleOptions($debugItem) . '>';

		foreach ($vars as $v) {
			if (is_string($v) || is_int($v)) {
				echo $v;
			} else {
				echo '<pre ' . self::giveStyleOptions($debugItem) . '>';
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

		echo self::doFormatLineNum( $debugItem->flags, ($bt[0]['line'] ?? 'no_line') );
//		echo ' (';
//		if (( $debugItem->flags & 0b0100_0000) == 0b0100_0000) {
//			echo '<p style="font:size:larger>';
//		}
//		if (( $debugItem->flags & 0b0001_0000) == 0b0001_0000) {
//			echo '<b>' . ($bt[0]['line'] ?? 'no_line') . '</b>';
//		} else {
//			echo ($bt[0]['line'] ?? 'no_line');
//		}
//		if (( $debugItem->flags & 0b0100_0000) == 0b0100_0000) {
//			echo '</p>';
//		}
//		echo ') ';

		if (( $debugItem->flags & 0b0000_0010) == 0b0000_0010) {
			if (isset($bt[0]['function'])) {
				echo ', func=', $bt[0]['function'] ?? '';
			}
		}
		if (( $debugItem->flags & 0b0000_0001) == 0b0000_0001) {
			if (isset($bt[1]['class'])) {
				echo ', class=', $bt[1]['class'] ?? '';
			}
		}
		if (( $debugItem->flags & 0b0000_0100) == 0b0000_0100) {
			if (isset($bt[1]['type'])) {
				echo ', type=', $bt[1]['type'] ?? '';
			}
		}
		if (( $debugItem->flags & 0b0100_0000) == 0b0100_0000) {
			$separator = '<br>';
		} else {
			$separator = '|';
		}

		if (( $debugItem->flags & 0b0000_1000) == 0b0000_1000) {
			echo $separator;
			if (isset($bt[1]['args'])) {
				echo ', args=', join($separator, ($bt[1]['args'] ?? ''));
			}
		}
		echo '</span><br>' . PHP_EOL;
	}




	/** --------------------------------------------------------------------------
	 *
	 * @param type $flags
	 * @param type $lineNum
	 * @return string
	 */
	protected static function doFormatLineNum( $flags, $lineNum) {
		$s = ' (' . PHP_EOL . PHP_EOL;

		if (( $flags & 0b0100_0000) == 0b0100_0000) {
			//$s .= '<div style="font-size:250%">';
			$textIncrease ='150%';
		} else {
			$textIncrease ='100%';
		}

		if (( $flags & 0b0001_0000) == 0b0001_0000) {
			$s .= '<b  style="font-size:' . $textIncrease .'">' . $lineNum . '</b>';
		} else {
			$s .= $lineNum;
		}
//		if (( $flags & 0b0100_0000) == 0b0100_0000) {
//			$s .= '</div>';
//		}
		$s .= ') ' . PHP_EOL . PHP_EOL . PHP_EOL;

		return $s;
	}






}
