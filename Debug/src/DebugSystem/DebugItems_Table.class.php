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


	protected static $listOfItems = [];


	/** --------------------------------------------------------------------------
	 *
	 */
	public static function ReadItemsList($itemsIDList) {
		$sql_id_list = join(', ', $itemsIDList);
		$sql = 'SELECT item_id, code, description, owner, level, foregroundColor, backgroundColor, textsize, category_id '
				. ' FROM items WHERE item_id IN ' . $sql_id_list;

		// read the table
		//iterate thru the results
		foreach (range(1, 10) as $r) {
			$item = new DebugItem();

			if (true) {
				$item = DebugItem::fakeFillItem($r);
			} else {
				$item->itemId = $r['itemId'];
				$item->code = $r['code'];
				$item->description = $r['description'];
				$item->owner = $r['owner'];
				$item->level = $r['level'];
				$item->foregroundColor = $r['foregroundColor'];
				$item->backgroundColor = $r['backgroundColor'];
				$item->textSize = $r['textsize'];
				$item->categoryId = $r['category_id'];
			}
			self::$listOfItems[$itemId] = $item;
		}
	}

}
