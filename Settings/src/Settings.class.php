<?php

namespace MJMphpLibrary;

class Settings {

	/**
	 * @var version string
	 */
	private const VERSION = '0.0.0';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}
}