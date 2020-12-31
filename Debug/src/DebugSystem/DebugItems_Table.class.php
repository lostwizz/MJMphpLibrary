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
	public static function ReadItemsList( /*$itemsIDList = null */ ) {
		$sql = 'SELECT item_id, codex, description, owner, level, foregroundColor, backgroundColor, textsize, $categoryId '
				. ' FROM debug_items ';
//		if (!is_null($itemsIDList)) {
//			$sql_id_list = join(', ', $itemsIDList);
//			$sql .= ' WHERE item_id IN (' . $sql_id_list . ' )';
//		}

		// read the table
		//iterate thru the results
		foreach (range(1, 10) as $r) {
			$item = new DebugAnItem();

			if (true) {
				$item = self::fakeFillAnItem($item, $r);
			} else {
				$item->item_id = $r['item_id'];
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

		//self::put_ini_file( self::$listOfItems, 'P:\Projects\_PHP_Code\MJMphpLibrary\config\items.ini' , true);

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
		$item->textSize = (7+$num) . 'pt';
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
				$item->textSize = '11pt';
				break;
			case 4:
				$item->codex = 'bob';
				$item->description = 'bob';
				$item->foregroundColor = '#0c0c0c';
				$item->backgroundColor = '#F0EABB';
				$item->textSize = '15pt';
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
				$item->textSize = '25pt';
				$item->flags = 0b0000_0000_0000_0000_0000_0000_0011_0000;
				break;
		}
		return $item;
	}



//	public static function put_ini_file($config, $file= 'P:\Projects\_PHP_Code\MJMphpLibrary\config\items.ini', $has_section = false, $write_to_file = true) {
//		$fileContent = '';
//		////////////////$config = self::$listOfItems;
//		if (!empty($config)) {
//			foreach ($config as $i => $v) {
//				if ($has_section) {
//					$fileContent .= "[$i]" . PHP_EOL . self::put_ini_file($v, $file, false, false);
//				} else {
//					if (is_array($v)) {
//						foreach ($v as $t => $m) {
//							$fileContent .= "$i[$t] = " . (is_numeric($m) ? $m : '"' . $m . '"') . PHP_EOL;
//						}
//					} else $fileContent .= "$i = " . (is_numeric($v) ? $v : '"' . $v . '"') . PHP_EOL;
//				}
//			}
//		}
//
//		if ($write_to_file && strlen($fileContent)) return file_put_contents($file, $fileContent, LOCK_EX);
//		else return $fileContent;
//	}
}

