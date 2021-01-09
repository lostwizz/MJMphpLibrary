<?php

declare(strict_types=1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpClasses.class.php');

use MJMphpLibrary\Debug\Dump as Dump;

/**
 * Description of DebugItems
 *
 * @author lost_
 */
class DebugItems {

	public static $listOfItems;

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

	/** --------------------------------------------------------------------------
	 *  this will read ALL the items defined in the db
	 */
	public static function initialize() {
		DebugItems_Table::readItemsList();
		self::$listOfItems = DebugItems_Table::$listOfItems;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public static function handleItemDetailsChange(): void {
		if (!empty($_POST['Add_Item']) && $_POST['Add_Item'] == 'Add New Item') {
			self::doShowAddItem();
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 */
	protected static function doShowAddItem() {

	}

}
