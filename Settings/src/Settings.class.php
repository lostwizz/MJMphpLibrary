<?php declare(strict_types=1);

namespace MJMphpLibrary;

require_once ('P:\Projects\_PHP_Code\MJMphpLibrary\Settings\src\ASetting.class.php');
use MJMphpLibrary\Settings\ASetting;



Abstract Class Settings {

	static protected array $public = array(); // For all public strings such as meta stuff for site
	static protected array $runTime = array();  // for runtime vars that will realyonly exist when running

	static protected array $settingsList = [];

	public const RUNTIME ='RunTime';
	public const PUBLIC ='public';
	public const PROTECTED ='Protected';

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

	public static function init() {
		self::$settingsList[	self::RUNTIME] = [self::READYNESS=>true];
		self::$settingsList[	self::PUBLIC] = [self::READYNESS=>true];
		self::$settingsList[	self::PROTECTED] = [self::READYNESS=>true];
	}

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

	public static function setValue( string $whichSettingList = self::PUBLIC, string $settingName, $value) : bool {
		self::$settingsList[$whichSettingList][$settingName] = new ASetting( $settingName, $value);
		return true;
	}

	public static function getValue( string $whichSettingList, string $settingName){
		$r = self::$settingsList[$whichSettingList][$settingName] -> getValue();
		return $r;
	}

	public static function hasKey( string $whichSettingList, string $settingName) : bool  {
		return array_key_exists( (self::$settingsList[$whichSettingList]), $settingName);
	}

//	public function __isset(string $whichSettingList, string $settingName) {
//		return array_key_exists( (self::$settingsList[$whichSettingList]), $settingName);
//	}


}