<?php

declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

/**
 * Description of DebugItems_Table
 *
 * @author lost_
 */
class DebugItems_Table {

	public static $listOfItems = [];

	/** --------------------------------------------------------------------------
	 *
	 */
	public static function ReadItemsList($itemsIDList = null) {
		$sql = 'SELECT item_id, codex, description, owner, level, foregroundColor, backgroundColor, textsize, $categoryId '
				. ' FROM debug_items ';
		if (!is_null($itemsIDList)) {
			$sql_id_list = join(', ', $itemsIDList);
			$sql .= ' WHERE item_id IN (' . $sql_id_list . ' )';
		}

		// read the table
		//iterate thru the results
		foreach (range(1, 10) as $r) {
			$item = new DebugAnItem();

			if (true) {
				$item = self::fakeFillAnItem($item, $r);
			} else {
				$item->itemId = $r['itemId'];
				$item->codex = $r['codex'];
				$item->description = $r['description'];
				$item->owner = $r['owner'];
				$item->level = $r['level'];
				$item->foregroundColor = $r['foregroundColor'];
				$item->backgroundColor = $r['backgroundColor'];
				$item->textSize = $r['textsize'];
				$item->categoryId = $r['$categoryId'];
			}

//			echo '<pre>';
//			print_r($item);
//			echo '</pre>';

			//self::$listOfItems[$item->codex] = $item;
			self::$listOfItems[$item->item_id] = $item;
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $num
	 * @return self
	 */
	static function fakeFillAnItem($item, $num) {
		$item->item_id = $num;
//		$item->owner = 'Mike';
//		$item->level = 5;
		$item->foregroundColor = '#228B22';
		$item->backgroundColor = '#FFFFFF';
		$item->textSize = '9pt';
//		$item->categoryId = 1;
		$item->flags = 0b0000_0000_0000_0000_0000_0000_0000_0000;

		switch ($num) {
			case 2:
				$item->codex = '_REQUEST';
				$item->description = 'request';
				$item->foregroundColor = '#0c0c0c';
				$item->backgroundColor = '#ABD8A9';
				$item->flags = 0b0000_0000_0000_0000_0000_0000_0011_0000;
				break;
			case 3:
				$item->codex = 'SQL';
				$item->description = 'request';
				$item->foregroundColor = '#0c0c0c';
				$item->backgroundColor = '#B0ECFB';
				$item->flags = 0b0000_0000_0000_0000_0000_0000_0011_0000;
				$item->textSize = '11pt';
				break;
			case 4:
				$item->codex = 'fred';
				$item->description = 'fred';
				$item->foregroundColor = '#0c0c0c';
				$item->backgroundColor = '#F0EABB';
				break;
			case 5:
				$item->codex = 'sam';
				$item->description = 'request';
				$item->foregroundColor = '#0000ff';
				$item->backgroundColor = '#ffffff'; //#B0ECFB';
				$item->flags = 0b0000_0000_0000_0000_0000_0000_0011_0010;
				break;

			case 1:
			case 6:
			case 7:
			case 8:
			case 9:
				$item->codex = 'menu' . $num;
				$item->description = 'Menu System' . $num;
				break;
			case 10:
				$item->codex = 'sqldebug' . $num;
				$item->description = 'SQL System Debug' . $num;
				break;
		}
		return $item;
	}


}
