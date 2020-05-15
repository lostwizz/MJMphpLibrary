<?php declare(strict_types=1);

Class DumpClasses{

	public static function dumpClasses($search = null, ?array $options=null) {
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
		$data = new DumpData();

		self::initConfig($options, self::CLASSES_LOADED);

		self::DumpClassesHelper($data, $bt, $search);
		$s = self::DumpClassBeautifierPRE($data);
		$s .= self::DumpClassGetData($search);
		$s .= self::DumpClassBeautifierPOST($data);
		$s .= self::BeautifyAreaEnd();
		echo $s;

	}

}