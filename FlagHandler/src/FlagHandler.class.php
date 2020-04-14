<?php

namespace MJMphpLibrary\FlagHandler;

class FlagHandler {

	/**
	 * @var version number
	 */
	private const VERSION = '0.1.0';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return type
	 */
	public static function Version() : string{
		return self::VERSION;
	}

	public function fred() :string {
		return 'Fred was here';
	}

}
