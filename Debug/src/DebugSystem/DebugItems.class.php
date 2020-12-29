<?php
declare(strict_types=1);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

/**
 * Description of DebugItems
 *
 * @author lost_
 */
class DebugItems {

	public static $listOfItems;

	/** --------------------------------------------------------------------------
	 *  this will read ALL the items defined in the db
	 */
	public static function initialize() {
		DebugItems_Table::ReadItemsList();
		self::$listOfItems = DebugItems_Table::$listOfItems;

//		DebugSystem::debug(null, self::$listOfItems);
//		echo '<pre> debugItems::listofitems ';
//		print_r( self::$listOfItems);
//		echo '</pre>';

	}
}
