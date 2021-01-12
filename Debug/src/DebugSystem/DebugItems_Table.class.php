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
		$sql	 = 'SELECT [item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]'
				. ' FROM debugItems ';
		$stmt	 = DebugSystem::$dbConn->query($sql);

		while ($r = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			$item = new DebugAnItem();

			$item->item_id						 = $r['item_id'];
			$item->codex						 = $r['codex'];
			$item->description					 = $r['description'];
			$item->foreground_color				 = $r['foregroundcolor'];
			$item->background_color				 = $r['backgroundcolor'];
			$item->text_size					 = $r['text_size'];
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
					. 'Description = :description, '
					. 'ForegroundColor = :foregroundcolor, '
					. 'BackgroundColor = :backgroundcolor, '
					. 'Text_Size = :text_size, '
					. 'flags = :flags'
					. ' WHERE item_id = :item_id ';

			$stmt = DebugSystem::$dbConn->prepare($sql);

			$stmt->bindParam(':codex', $item->codex, \PDO::PARAM_STR);

			$stmt->bindParam(':description', $item->description, \PDO::PARAM_STR);
			$stmt->bindParam(':foregroundcolor', $item->foreground_color, \PDO::PARAM_STR);
			$stmt->bindParam(':backgroundcolor', $item->background_color, \PDO::PARAM_STR);
			$stmt->bindParam(':text_size', $item->text_size, \PDO::PARAM_STR);
			$stmt->bindParam(':flags', $item->flags, \PDO::PARAM_INT);
			$stmt->bindParam(':item_id', $item->item_id, \PDO::PARAM_INT);

			$stmt_result = $stmt->execute();
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
			$stmt->bindParam(':codex', $item->codex, \PDO::PARAM_STR);
			$stmt->bindParam(':description', $item->description, \PDO::PARAM_STR);
			$stmt->bindParam(':foregroundcolor', $item->foreground_color, \PDO::PARAM_STR);
			$stmt->bindParam(':backgroundcolor', $item->background_color, \PDO::PARAM_STR);
			$stmt->bindParam(':text_size', $item->text_size, \PDO::PARAM_STR);
			$stmt->bindParam(':flags', $item->flags, \PDO::PARAM_INT);
			$stmt->bindParam(':item_id', $item->item_id, \PDO::PARAM_INT);

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

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public static function ResetItemsToDefaults() {

		$s = <<<EOT
USE [CityJETSystem_DEV]
GO
SET IDENTITY_INSERT [dbo].[DebugItems] ON
GO
INSERT [dbo].[DebugItems] ([item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]) VALUES (1, N'_REQUEST', N'Show the $_request-XXXX', N'#000000', N'#c6a8b8', N'10pt', 170)
GO
INSERT [dbo].[DebugItems] ([item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]) VALUES (2, N'SQL_STMNT', N'Show the SQL Statment in a copyable form', N'#000000', N'#b0ecfb', N'10pt', 48)
GO
INSERT [dbo].[DebugItems] ([item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]) VALUES (3, N'SQL_Results', N'Show the results of a SQL interaction', N'#000000', N'#3fd1f5', N'10pt', 48)
GO
INSERT [dbo].[DebugItems] ([item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]) VALUES (4, N'Menu_General', N'Show some General Menu debug info', N'#ffffff', N'#008040', N'10pt', 112)
GO
INSERT [dbo].[DebugItems] ([item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]) VALUES (5, N'Menu_Detailed', N'Show Detailed Menu debug Info', N'#000000', N'#b8bff1', N'10pt', 16)
GO
INSERT [dbo].[DebugItems] ([item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]) VALUES (6, N'general', N'show general debug info ', N'#ffffff', N'#000000', N'10pt', 16)
GO
INSERT [dbo].[DebugItems] ([item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]) VALUES (7, N'Error', N'Show Error info ', N'#ffffff', N'#ff0000', N'14pt', 112)
GO
INSERT [dbo].[DebugItems] ([item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]) VALUES (8, N'Test1', N'test', N'#800040', N'#ffffff', NULL, 112)
GO
INSERT [dbo].[DebugItems] ([item_id], [codex], [Description], [ForegroundColor], [BackgroundColor], [Text_Size], [flags]) VALUES (11, N'_POST', N'show the $_POST', N'#480000', N'#c2c0d3', N'12pt', 48)
GO
EOT;

		$stmtResult = DebugSystem::$dbConn->exec($s);
		echo 'inserts ' . ( $stmtResult ? 'worked' : ' didnt work');
	}

}
