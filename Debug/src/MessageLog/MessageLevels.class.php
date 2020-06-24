<?php  declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

///namespace php_base\Utils;
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

	public static $levels = array(
		self::ROCK_BOTTOM_ALL => 'ROCK_BOTTOM_ALL',
		self::ALL => 'All',
		self::DEBUG => 'DEBUG',
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
