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
	 * @return void
	 */
	public static function readItemsList(): void {
		$sql = 'SELECT [item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]'
				. ' FROM debugItems ';
		$stmt = DebugSystem::$dbConn->query($sql);

		while ($r = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			$item = new DebugAnItem();

			$item->item_id						 = $r['item_id'];
			$item->codex						 = $r['codex'];
			$item->description					 = $r['description'];
			$item->foregroundColor				 = $r['foregroundcolor'];
			$item->backgroundColor				 = $r['backgroundcolor'];
			$item->text_Size					 = $r['text_size'];
			$item->flags						 = $r['flags'];
			self::$listOfItems[$item->item_id]	 = $item;
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param DebugAnItem $item
	 * @return void
	 * @throws Exception
	 */
	public static function updateItem(DebugAnItem $item): void {
		try {
			$sql = 'UPDATE DebugItems'
					. ' SET codex = :codex, '
					. 'description = :description, '
					. 'foregroundcolor = :foregroundcolor, '
					. 'backgroundcolor = :backgroundcolor, '
					. 'text_size = :text_size, '
					. 'flags = :flags'
					. ' WHERE item_id = :item_id ';

			$stmt = DebugSystem::$dbConn->prepare($sql);
			$stmt->bindParam(':codex', $preset->codex, \PDO::PARAM_STR);
			$stmt->bindParam(':description', $preset->description, \PDO::PARAM_STR);
			$stmt->bindParam(':foregroundcolor', $preset->foregroundcolor, \PDO::PARAM_STR);
			$stmt->bindParam(':backgroundcolor', $preset->backgroundcolor, \PDO::PARAM_STR);
			$stmt->bindParam(':text_size', $preset->text_size, \PDO::PARAM_STR);
			$stmt->bindParam(':flags', $preset->flags, \PDO::PARAM_INT);
			$stmt->bindParam(':item_id', $preset->item_id, \PDO::PARAM_INT);

			$stmt->execute();
		} catch (PDOException $e) {
			print "<hr>Error!: " . $e->getMessage() . "<br/>";
			print "stmt: " . $e->getCode() . '<br>';

			throw new Exception("ERROR: fetchAll failed with: " . $e->getMessage());
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param DebugAnItem $item
	 * @return int
	 * @throws Exception
	 */
	public static function insertItem(DebugAnItem $item): int {
		try {
			$sql = 'INSERT INTO  DebugItems'
					. ' ( codex, description, foregroundcolor, backgroundcolor, text_size, flags )'
					. ' VALUES '
					. ' ( :codex, :description, :foregroundcolor, :backgroundcolor, :text_size, :flags )';


			$stmt = DebugSystem::$dbConn->prepare($sql);
			$stmt->bindParam(':codex', $preset->codex, \PDO::PARAM_STR);
			$stmt->bindParam(':description', $preset->description, \PDO::PARAM_STR);
			$stmt->bindParam(':foregroundcolor', $preset->foregroundcolor, \PDO::PARAM_STR);
			$stmt->bindParam(':backgroundcolor', $preset->backgroundcolor, \PDO::PARAM_STR);
			$stmt->bindParam(':text_size', $preset->text_size, \PDO::PARAM_STR);
			$stmt->bindParam(':flags', $preset->flags, \PDO::PARAM_INT);
			$stmt->bindParam(':item_id', $preset->item_id, \PDO::PARAM_INT);

			$stmt->execute();
			if ($r) {
				$r = DebugSystem::$dbConn->lastInsertId();
				return $r;
			}
		} catch (PDOException $e) {
			print "<hr>Error!: " . $e->getMessage() . "<br/>";
			print "stmt: " . $e->getCode() . '<br>';

			throw new Exception("ERROR: fetchAll failed with: " . $e->getMessage());
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param DebugAnItem $item
	 * @return void
	 * @throws Exception
	 */
	public static function delteItem(DebugAnItem $item): void {
		try {
			$sql = 'DELETE FROM DebugItems WHERE item_id = :item_id';
			$stmt->bindParam(':item_id', $preset->item_id, \PDO::PARAM_INT);

			$r = $stmt->execute();
			if ($r) {
				$r = DebugSystem::$dbConn->lastInsertId();
			}
		} catch (Exception $ex) {
			print "<hr>Error!: " . $e->getMessage() . "<br/>";
			print "stmt: " . $e->getCode() . '<br>';

			throw new Exception("ERROR: fetchAll failed with: " . $e->getMessage());
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $num
	 * @return self
	 */
	/*
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
	 */
}
