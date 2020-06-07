<?php
declare(strict_types=1);


//***********************************************************************************************
//***********************************************************************************************
/**
 * the message base class for AMessage
 *    - mainly to allow getting the name for the value thru the array $levels
 */
abstract class MessageBase {
	const ROCK_BOTTOM_ALL = -1;
	const ALL = 1;

	const DEBUG_1 = 101;
	const DEBUG_2 = 102;
	const DEBUG_3 = 103;
	const DEBUG_4 = 104;
	const DEBUG_5 = 105;
	const DEBUG_6 = 106;
	const DEBUG_7 = 107;
	const DEBUG_8 = 108;
	const DEBUG_9 = 109;
	const DEBUG = 110;

	const INFO_1 = 201;
	const INFO_2 = 202;
	const INFO_3 = 203;
	const INFO_4 = 204;
	const INFO_5 = 205;
	const INFO_6 = 206;
	const INFO_7 = 207;
	const INFO_8 = 208;
	const INFO_9 = 209;
	const INFO = 210;

	const NOTICE_1 = 251;
	const NOTICE_2 = 252;
	const NOTICE_3 = 253;
	const NOTICE_4 = 254;
	const NOTICE_5 = 255;
	const NOTICE_6 = 256;
	const NOTICE_7 = 257;
	const NOTICE_8 = 258;
	const NOTICE_9 = 259;
	const NOTICE = 260;

	const TODO = 275;
	const WARNING = 300;
	const ERROR = 400;
	const CRITICAL = 500;
	const ALERT = 550;
	const EMERGENCY = 600;

	/**
	 *
	 * @var array $levels - gives a text description of the error type
	 */
	public static $levels = array(
		self::ROCK_BOTTOM_ALL => 'ROCK_BOTTOM_ALL',
		self::ALL => 'All',
		self::DEBUG => 'DEBUG',
		self::DEBUG_1 => 'DEBUG_1',
		self::DEBUG_2 => 'DEBUG_2',
		self::DEBUG_3 => 'DEBUG_3',
		self::DEBUG_4 => 'DEBUG_4',
		self::DEBUG_5 => 'DEBUG_5',
		self::DEBUG_6 => 'DEBUG_6',
		self::DEBUG_7 => 'DEBUG_7',
		self::DEBUG_8 => 'DEBUG_8',
		self::DEBUG_9 => 'DEBUG_9',
		self::INFO => 'INFO',
		self::INFO_1 => 'INFO_1',
		self::INFO_2 => 'INFO_2',
		self::INFO_3 => 'INFO_3',
		self::INFO_4 => 'INFO_4',
		self::INFO_5 => 'INFO_5',
		self::INFO_6 => 'INFO_6',
		self::INFO_7 => 'INFO_7',
		self::INFO_8 => 'INFO_8',
		self::INFO_9 => 'INFO_9',
		self::NOTICE => 'NOTICE',
		self::NOTICE_1 => 'NOTICE_1',
		self::NOTICE_2 => 'NOTICE_2',
		self::NOTICE_3 => 'NOTICE_3',
		self::NOTICE_4 => 'NOTICE_4',
		self::NOTICE_5 => 'NOTICE_5',
		self::NOTICE_6 => 'NOTICE_6',
		self::NOTICE_7 => 'NOTICE_7',
		self::NOTICE_8 => 'NOTICE_8',
		self::NOTICE_9 => 'NOTICE_9',
		self::TODO => 'TODO',
		self::WARNING => 'WARNING',
		self::ERROR => 'ERROR',
		self::CRITICAL => 'CRITICAL',
		self::ALERT => 'ALERT',
		self::EMERGENCY => 'EMERGENCY',
		self::ROCK_BOTTOM_ALL => 'ROCK_BOTTOM_ALL',
	);

	/**
	 * @var version number
	 */
	private const VERSION = '0.3.0';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return type
	 */
	public static function Version() : string{
		return self::VERSION;
	}

	public static function getDefaultLevel(): int {
		return self::NOTICE;
	}

//	abstract function Show() :void;

//	abstract function Set(?int $value = null) : void;

//	abstract function Get();
}


