<?php

declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\DebugSystem\DebugPresets.class.php');
include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\DebugSystem\DebugSystem_Display.class.php');
include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\DebugSystem\DebugPresets_Table.class.php');
include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\DebugSystem\DebugCategories.class.php');
include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\DebugSystem\DebugItem.class.php');
include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\DebugSystem\DebugItems_Table.class.php');
include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\DebugSystem\DebugPresetItems_Table.class.php');

Class DebugSystem {

	public static function initialize() {
		echo 'hello world';
		DebugPresets::initialize();
	}

	public static function show() {
		DebugSystem_Display::showDebugSettingSetup(true);
	}

	public static function debug($debugCode = '', ...$vars) {
		$bt = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
		if ($debugCode)

//		echo '<pre>';
//		 debug_print_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
//		echo '</pre>';
			;
		echo '<h2>';
		//echo ' line=', $bt[0]['line'] ?? 'no_line';

		foreach ($vars as $v) {
			echo print_r($v, true);
			echo '|';
		}

		echo ' file=', basename(($bt[0]['file'] ?? 'no_file')) . '(' . ($bt[0]['line'] ?? 'no_line') . ')';

		if (isset($bt[0]['function'])) {
			echo ' func=', $bt[0]['function'] ?? '';
		}
		if (isset($bt[1]['class'])) {
			echo ' class=', $bt[1]['class'] ?? '';
		}
		if (isset($bt[1]['type'])) {
			echo ' type=', $bt[1]['type'] ?? '';
		}

		echo '</h2>';
	}

}
