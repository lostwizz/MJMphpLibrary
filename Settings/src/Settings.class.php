<?php

declare(strict_types=1);

namespace MJMphpLibrary;

require_once ('P:\Projects\_PHP_Code\MJMphpLibrary\Settings\src\ASetting.class.php');

use MJMphpLibrary\Settings\ASetting;

Abstract Class Settings {

	static protected array $settingsList = [];
	//static protected array $public = array();
	//static protected array $runTime = array();
	//static protected array $protected = array();  // for runtime vars that will realyonly exist when running

	public const RUNTIME = 'RunTime';
	public const PUBLIC = 'Public';
	public const PROTECTED = 'Protected';

	protected const READYNESS = '__READY__';

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

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public static function init() {
		self::initList(self::RUNTIME);		// for runtime vars that will realy only exist when running  - and do not get saved in ini or database
		self::initList(self::PUBLIC);		// For all public strings such as meta stuff for site
		self::initList(self::PROTECTED);	// for things that should only be set once and then read from then on
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $whichSettingsList
	 */
	public static function initList(string $whichSettingsList) {
		self::$settingsList[$whichSettingsList] = [self::READYNESS => true];
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $whichSettingsList
	 * @return type
	 */
	public static function isListReady(string $whichSettingsList) {
		$r = self::$settingsList[$whichSettingsList]['__READY__'] ?? false;
		return $r;
	}

	/** -----------------------------------------------------------------------------------------------
	 *  simple test to see if the settings has already been used (or it might exist but nothing has ever been set
	 */
	public static function isReady(): bool {
		return (self::isListReady(self::RUNTIME)
				and self::isListReady(self::PUBLIC)
				and self::isListReady(self::PROTECTED)
				);
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @param string $whichSettingList
	 * @param string $settingName
	 * @param type $value
	 * @return bool-
	 */
	public static function setValue(string $whichSettingList = self::PUBLIC, string $settingName, $value, ?string $codeDetails=null, ?int $timeStamp=null): bool {
		self::$settingsList[$whichSettingList][$settingName] = new ASetting($settingName, $value, $codeDetails, $timeStamp);
		return true;
	}


	public static function getFullSetting( string $whichSettingList, string $settingName) : ASetting {
		$r = self::$settingsList[$whichSettingList][$settingName];
		return $r;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $whichSettingList
	 * @param string $settingName
	 * @return type
	 */
	public static function getValue(string $whichSettingList, string $settingName) {
		$r = self::$settingsList[$whichSettingList][$settingName]->getValue();
		return $r;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $whichSettingList
	 * @param string $settingName
	 * @return bool
	 */
	public static function hasKey(string $whichSettingList, string $settingName): bool {
		return array_key_exists((self::$settingsList[$whichSettingList]), $settingName);
	}

//	public function __isset(string $whichSettingList, string $settingName) {
//		return array_key_exists( (self::$settingsList[$whichSettingList]), $settingName);
//	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $whichSettingList
	 */
	public static function clearAll(string $whichSettingList) {
		self::$settingsList = [];
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public static function clearAllSettingLists(bool $doInit = true) {
		foreach (self::$settingsList as $key => $value) {
			self::clearAll(self::$key);
		}
		if ( $doInit){
			self::init();
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $whichSettingList
	 * @return type
	 */
	public static function count(string $whichSettingList = null) {
		if (empty($whichSettingList)) {
			$count = 0;
			foreach (self::$settingsList as $key => $value) {
				$count = $count + count(self::$key);
			}
			return $count;
		} else {
			return count(self::$settingsList);
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return string
	 */
	public static function toString(): string {
		$s = '';
		foreach (self::$settingsList as $key => $value) {
			$s .= '--List ' . $key . ' --';
			$s .= '<br>' . PHP_EOL;
			$s .= print_r(self::$settingsList[$key], true);
			$s .= '<br>' . PHP_EOL;
		}
		return $s;
	}

}
