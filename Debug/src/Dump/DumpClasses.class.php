<?php declare(strict_types=1);


namespace MJMphpLibrary\Debug;

Abstract Class DumpClasses{

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




	public static function dumpClasses($search = null, ?array $options=null) {
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
//		$data = new DumpData();
//
//		self::initConfig($options, self::CLASSES_LOADED);
//
//		self::DumpClassesHelper($data, $bt, $search);
//		$s = self::DumpClassBeautifierPRE($data);
//		$s .= self::DumpClassGetData($search);
//		$s .= self::DumpClassBeautifierPOST($data);
//		$s .= self::BeautifyAreaEnd();
//		echo $s;

	}

}