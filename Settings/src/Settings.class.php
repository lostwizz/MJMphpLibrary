<?php declare(strict_types=1);

namespace MJMphpLibrary;

Abstract Class Settings {

	static protected array $public = array(); // For all public strings such as meta stuff for site
	static protected array $runTime = array();  // for runtime vars that will realyonly exist when running

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