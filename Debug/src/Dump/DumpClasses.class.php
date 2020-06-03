<?php declare(strict_types=1);


namespace MJMphpLibrary\Debug;

use \MJMphpLibrary\Debug\Dump;
include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\Dump.class.php');

use MJMphpLibrary\Debug\Dump\DumpConfigSet;
require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpConfigSet.class.php');


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


		$configSet = new DumpConfigSet('DumpClasses');
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
		$btLine = '   -- From: ' . $bt[0]['file']  . '(' . $bt[0]['line'] . ')';

		Dump::dump( $btLine,  get_declared_classes(), $configSet );

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