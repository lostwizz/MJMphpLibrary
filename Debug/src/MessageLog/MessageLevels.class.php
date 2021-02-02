<?php  declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

///namespace php_base\Utils;
//namespace MJMphpLibrary\Debug\MessageLog;

namespace MJMphpLibrary\Debug\MessageLog;



/**
 * Description of MessageLevels
 *
 * @author lost_
 */
abstract class MessageLevels {


	const ROCK_BOTTOM_ALL = -1;
	const ALL = 1;
	const DEBUG = 110;
	const INFO = 210;
	const NOTICE = 260;
	const TODO = 275;
	const WARNING = 300;
	const ERROR = 400;
	const CRITICAL = 500;
	const ALERT = 550;
	const EMERGENCY = 600;


	public static $levels = array(
		self::ROCK_BOTTOM_ALL => 'ROCK_BOTTOM_ALL',
		self::ALL => 'ALL',
		self::DEBUG => 'DEBUG',
		self::INFO => 'INFO',
		self::NOTICE => 'NOTICE',
		self::TODO => 'TODO',
		self::WARNING => 'WARNING',
		self::ERROR => 'ERROR',
		self::CRITICAL => 'CRITICAL',
		self::ALERT => 'ALERT',
		self::EMERGENCY => 'EMERGENCY',
		);



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

}
