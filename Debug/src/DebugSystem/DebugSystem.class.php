<?php

declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace MJMphpLibrary\Debug\DebugSystem;

echo '<style>';
include_once('DebugSystem.css');
echo '</style>';

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

define('ACTION_SYSTEM', 'ACTION_SYSTEM');
define('ACTION_DETAIL','ACTION_DETAIL');

define( 'DEBUG_SYSTEM', 'DEBUG_SYSTEM');
define( 'DEBUG_SYSTEM_DETAILS', 'DEBUG_SYSTEM_DETAILS');


require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpClasses.class.php');
use MJMphpLibrary\Debug\Dump as Dump;


/** ===================================================================================
 *
 */
Class DebugSystem {

	public static $IS_DEBUG_DEBUGGING = true;

	const DEBUG_SHOW_ALL = -1;

	/*
	 * if this is true then the default preset (-1) uses ALL Items - if false then no items are selected
	 */
	const DEBUG_DEFAULT_PRESET_INCLUDES_ALL_ITEMS =true;

	protected static $currPreset = DebugPresets::DEFAULT_TEMP_PRESET;

	public static $wasPresetJustChanged = false;

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

		DebugItems::initialize();
		DebugPresets::initialize();
		self::HandlePOSTChanges();
	}

	/** --------------------------------------------------------------------------
	 *
	 */
	protected static function HandlePOSTChanges() {

		if (empty($_POST)) {
			return;
		} else {
			self::handleIS_DEBUGGING_post();

			DebugPresets::handlePresetDetailsChange();

			DebugItems::handleItemDetailsChange();

		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public static function handleIS_DEBUGGING_post() : void {
		if (!empty($_POST) && !empty($_POST['ChangeDebuggingSwitch'])) {
			self::$IS_DEBUG_DEBUGGING = ($_POST['ChangeDebuggingSwitch'] == 'DebugSystem_TurnON' );
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return int
	 */
	public static function giveCurrentPresetId(): int {
		return (int)self::$currPreset;
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param int $newVal
	 */
	public static function setCurrentPresetId(int $newVal) {
		self::$currPreset = $newVal;
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return int
	 */
	public static function giveNumberOfItems(): int {
		return count(DebugItems::$listOfItems);
	}


	/** --------------------------------------------------------------------------
	 *
	 * @throws Exception
	 */
	protected static function DebugStartDBConnection() {
		if (defined('DB_DATABASE') && defined('DB_SERVER')) {
			$schema		 = DB_DATABASE;
			$host		 = DB_SERVER;
			$username	 = DB_USERNAME;
			$password	 = DB_PASSWORD;
		} else {
			$host		 = 'pv00dbsmss01';
			$schema		 = 'CityJETSystem_DEV';
			$username	 = 'jet_system';
			$password	 = 'jet_system99A';
		}
		try {
			$dsn			 = 'sqlsrv:Server=' . $host . ';Database=' . $schema;
			self::$dbConn	 = new \pdo($dsn, $username, $password);

			self::$dbConn->setattribute(\PDO::ATTR_PERSISTENT, true);
			self::$dbConn->setattribute(\PDO::ATTR_CASE, \PDO::CASE_LOWER);
			self::$dbConn->setattribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e) {
			print "<hr>Error!: " . $e->getMessage() . "<br/>";
			print "stmt: " . $e->getCode() . '<br>';
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
	 * @param type $debugCodex
	 * @param type $vars
	 */
	public static function debug($debugCodex = self::DEBUG_SHOW_ALL, ...$vars): void {
		if (!self::$IS_DEBUG_DEBUGGING) {
			return;
		}
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);

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

		$lll = DebugPresets::$listOfPresets[self::$currPreset]->listOfItemIds;

		if (empty($lll)) {
			return false;
		} else {
			foreach ($lll as $i) {
				$theItem = DebugItems::$listOfItems[$i];

				if ($debugCodex == strtoupper($theItem->codex)) {
					return true;
				}
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
				if ($debugCodex == strtoupper($i->codex)) {
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
			. ($debugItem->background_color ?? '#ffffff')
			. '; color:' . ($debugItem->foreground_color ?? '#0000ff')
			. '; font-size:' . ($debugItem->text_size ?? '9pt')
			. ';"';
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $vars
	 * @param type $bt
	 */
	public static function printDebugInfo($debugCodex, $vars, $bt) {
		$debugItem = self::findPresetItemsWithCodex($debugCodex);
		echo '&nbsp;';
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

		if ( DebugAnItem::isFlagMaskSet( 'Path', $debugItem->flags  )) {
			$fn = ($bt[0]['file'] ?? 'no_file');
		} else {
			$fn = basename(($bt[0]['file'] ?? 'no_file'));
		}

		if ( DebugAnItem::isFlagMaskSet( 'italics filename', $debugItem->flags  )) {
			echo '<i>', $fn. '</i>';
		} else {
			echo $fn;
		}

		echo self::doFormatLineNum( $debugItem->flags, ($bt[0]['line'] ?? 'no_line') );

		if ( DebugAnItem::isFlagMaskSet( 'add func', $debugItem->flags  )) {
			if (isset($bt[0]['function'])) {
				echo ', func=', $bt[0]['function'] ?? '';
			}
		}

		if ( DebugAnItem::isFlagMaskSet( 'add Class', $debugItem->flags  )) {
			if (isset($bt[1]['class'])) {
				echo ', class=', $bt[1]['class'] ?? '';
			}
		}

		if ( DebugAnItem::isFlagMaskSet( 'add type', $debugItem->flags  )) {
			if (isset($bt[1]['type'])) {
				echo ', type=', $bt[1]['type'] ?? '';
			}
		}

		if ( DebugAnItem::isFlagMaskSet( 'args diff ln', $debugItem->flags  )) {
			$separator = '<br>';
		} else {
			$separator = '|';
		}

		if ( DebugAnItem::isFlagMaskSet( 'add args', $debugItem->flags  )) {
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
	protected static function doFormatLineNum($flags, $lineNum) {
		$s = ' (' . PHP_EOL . PHP_EOL;

		if ( DebugAnItem::isFlagMaskSet( 'ln# large',  $flags )) {
			$textIncrease = '150%';
		} else {
			$textIncrease = '100%';
		}

		if ( DebugAnItem::isFlagMaskSet( 'bold line#',  $flags )) {
			$s .= '<b  style="font-size:' . $textIncrease . '">' . $lineNum . '</b>';
		} else {
			$s .= $lineNum;
		}
		$s .= ') ' . PHP_EOL . PHP_EOL . PHP_EOL;

		return $s;
	}

}
