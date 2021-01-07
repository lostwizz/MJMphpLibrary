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
 * Description of DebugItems_Table
 *
 * @author lost_
 */
class DebugItems_Table {

	public static $listOfItems = [];

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
	 *
	 */
	public static function ReadItemsList(/* $itemsIDList = null */) {
		$sql = 'SELECT [item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]'
				. ' FROM debugItems ';
//		if (!is_null($itemsIDList)) {
//			$sql_id_list = join(', ', $itemsIDList);
//			$sql .= ' WHERE item_id IN (' . $sql_id_list . ' )';
//		}


		// read the table
		$stmt = DebugSystem::$dbConn->query($sql);

		while ($r = $stmt->fetch()) {
			$item = new DebugAnItem();

			$item->item_id						 = $r['item_id'];
			$item->codex						 = $r['codex'];
			$item->description					 = $r['description'];
			$item->foregroundColor				 = $r['foregroundcolor'];
			$item->backgroundColor				 = $r['backgroundcolor'];
			$item->text_Size					 = $r['text_size'];
			$item->flags						= $r['flags'];
			self::$listOfItems[$item->item_id]	 = $item;
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $num
	 * @return self
	 */
	static function fakeFillAnItem($item, $num) {
		$item->item_id = $num;
		$item->codex = 'codex_' . $num;
		$item->foregroundColor = '#228B22';
		$item->backgroundColor = '#FFFFFF';
		$item->text_Size = (7+$num) . 'pt';
		$item->flags = 0b0000_0000_0000_0000_0000_0000_0000_0000;
//		$item->owner = 'Mike';
//		$item->level = 5;
//		$item->categoryId = 1;

		switch ($num) {
			case 1:
				break;
			case 2:
				$item->codex = '_REQUEST';
				$item->description = 'request';
				$item->foregroundColor = '#0c0c0c';
				$item->backgroundColor = '#ABD8A9';
				$item->flags = 0b0000_0000_0000_0000_0000_0000_0010_1000;
				break;
			case 3:
				$item->codex = 'SQL';
				$item->description = 'request';
				$item->foregroundColor = '#0c0c0c';
				$item->backgroundColor = '#B0ECFB';
				$item->flags = 0b0000_0000_0000_0000_0000_0000_0001_0000;
				$item->text_Size = '11pt';
				break;
			case 4:
				$item->codex = 'bob';
				$item->description = 'bob';
				$item->foregroundColor = '#0c0c0c';
				$item->backgroundColor = '#F0EABB';
				$item->text_Size = '15pt';
				$item->flags = 0b0000_0000_0000_0000_0000_0000_0001_1111;
				break;
			case 5:
				$item->codex = 'sam';
				$item->description = 'request';
				$item->foregroundColor = 'darkblue'; //#0000ff';
				$item->backgroundColor = 'white'; //#ffffff'; //#B0ECFB';
				$item->flags = 0b0000_0000_0000_0000_0000_0000_0011_0010;
				break;
			case 6:
				$item->codex = 'tony';
				$item->description = 'request';
				$item->foregroundColor = '#ffffff';
				$item->backgroundColor = '#000000'; //#B0ECFB';
				$item->flags = 0b0000_0000_0000_0000_0000_0000_0100_1010;
				break;

			case 7:
			case 8:
			case 9:
				//$item->codex = 'menu' . $num;
				$item->description = 'Menu System' . $num;
				$item->flags = 0b0000_0000_0000_0000_0000_0000_0011_0000;
				break;
			case 10:
				$item->codex = 'sqldebug' . $num;
				$item->description = 'SQL System Debug' . $num;
				$item->foregroundColor = '#ffffff';
				$item->backgroundColor = '#ff0000'; //#B0ECFB';
				$item->text_Size = '25pt';
				$item->flags = 0b0000_0000_0000_0000_0000_0000_0011_0000;
				break;
		}
		return $item;
	}

}

