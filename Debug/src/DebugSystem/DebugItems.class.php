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

		foreach( self::$listOfItems as $i) {

			$anyDetailNeedChanging = false;
			$id = $i->item_id;

//dump::dump($i->codex,  $_POST['codex'][$id]);


			if ( $i->codex != $_POST['codex'][$id]){
				$str = $_POST['codex'][$id];
				$i->codex  = (string) filter_var($str, FILTER_SANITIZE_STRING);
				$anyDetailNeedChanging	= true;
			}
//dump::dump( $i->description , $_POST['desc'][$id]);

			if ( $i->description != $_POST['desc'][$id]){
				$str = $_POST['desc'][$id];
				$i->description  = (string) filter_var($str, FILTER_SANITIZE_STRING);
				$anyDetailNeedChanging	= true;
			}
//dump::dump( $i->foreground_color, $_POST['forecolor'][$id], $anyDetailNeedChanging );
			if ( $i->foreground_color != $_POST['forecolor'][$id]){
				$str = $_POST['forecolor'][$id];
				$i->foreground_color  = (string) filter_var($str, FILTER_SANITIZE_STRING);
				$anyDetailNeedChanging	= true;
			}
//dump::dump( $i->background_color, $_POST['backcolor'][$id], $anyDetailNeedChanging );
			if ( $i->background_color != $_POST['backcolor'][$id]){
				$str = $_POST['backcolor'][$id];
				$i->background_color  = (string) filter_var($str, FILTER_SANITIZE_STRING);
				$anyDetailNeedChanging	= true;
			}
//dump::dump( $i->text_size, $_POST['size'][$id], $anyDetailNeedChanging  );
			if ( $i->text_size != $_POST['size'][$id]){
				$str = $_POST['size'][$id];
				$i->text_size  = (string) filter_var($str, FILTER_SANITIZE_STRING);
				$anyDetailNeedChanging	= true;
			}

			$c = 0;
			foreach($_POST['flags'][$id] as $f ){
				$ff = (int)filter_var($f, FILTER_SANITIZE_NUMBER_INT);
				$c += $ff;
			}

			//if ( $i->flags != $_POST['flags'][$id]){
			if ( $i->flags != $c){
				//$str = $_POST['flags'][$id];
				//$i->flags  = (string) filter_var($str, FILTER_SANITIZE_NUMBER_INT);
				$i->flags  = $c;
				$anyDetailNeedChanging	= true;
			}

			if ( $anyDetailNeedChanging) {
				DebugItems_Table::updateItem( $i);
			}
		}

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
