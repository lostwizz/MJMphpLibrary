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
 * Description of DebugPresets_Table
 *
 * @author lost_
 */
class DebugPresets_Table {

	public static $listOfPresets = [];

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
	 */
	public static function initialize(): void {
		self::readTable();
		self::$listOfPresets[DebugPresets::DEFAULT_TEMP_PRESET]				 = new DebugAPreset();
		self::$listOfPresets[DebugPresets::DEFAULT_TEMP_PRESET]->preset_id	 = DebugPresets::DEFAULT_TEMP_PRESET;
		self::$listOfPresets[DebugPresets::DEFAULT_TEMP_PRESET]->name		 = 'Default';
		self::$listOfPresets[DebugPresets::DEFAULT_TEMP_PRESET]->description = 'Default preset with every item';

		if (DebugSystem::DEBUG_DEFAULT_PRESET_INCLUDES_ALL_ITEMS) {
			//	self::$listOfPresets[DebugPresets::DEFAULT_TEMP_PRESET]->listOfItemIds = range(1, DebugSystem::giveNumberOfItems());

			foreach (array_keys(DebugItems::$listOfItems) as $i) {
				self::$listOfPresets[DebugPresets::DEFAULT_TEMP_PRESET]->listOfItemIds[$i] = $i;
			}
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public static function readTable(): void {
		$sql	 = 'SELECT preset_id, name, description, listOfItemIDs FROM debugPresets';
		$stmt	 = DebugSystem::$dbConn->query($sql);

		while ($r = $stmt->fetch(\PDO::FETCH_ASSOC)) {
			$preset				 = new DebugAPreset();
			$preset->preset_id	 = $r['preset_id'];
			$preset->name		 = $r['name'];
			$preset->description = $r['description'];

			if (empty($r['listofitemids'])) {
				$preset->listOfItemIds = [];
			} else {
				$items = \explode(',', $r['listofitemids']);

				foreach ($items as $value) {
					$preset->listOfItemIds[$value] = $value;
				}
				asort($preset->listOfItemIds);
			}
			self::$listOfPresets[$preset->preset_id] = $preset;
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $preset
	 * @throws Exception
	 */
	public static function updatePreset(DebugAPreset $preset): void {
		try {
			$sql	 = 'UPDATE debugPresets'
					. ' SET name  = :name, description =  :description, listOfItemIDs = :listOfItemIDs'
					. ' WHERE preset_id = :preset_id';
			$stmt	 = DebugSystem::$dbConn->prepare($sql);
			$stmt->bindParam(':name', $preset->name, \PDO::PARAM_STR);
			$stmt->bindParam(':description', $preset->name, \PDO::PARAM_STR);
			if (empty($preset->listOfItemIds)) {
				$nn = null;
				$stmt->bindParam(':listOfItemIDs', $nn, \PDO::PARAM_STR);
			} else {
				$j = join(',', $preset->listOfItemIds);
				$stmt->bindParam(':listOfItemIDs', $j, \PDO::PARAM_STR);
			}
			$stmt->bindParam(':preset_id', $preset->preset_id, \PDO::PARAM_INT);

			$r = $stmt->execute();
		} catch (PDOException $e) {
			print "<hr>Error!: " . $e->getMessage() . "<br/>";
			print "stmt: " . $e->getCode() . '<br>';

			throw new Exception("ERROR: fetchAll failed with: " . $e->getMessage());
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $preset
	 * @throws Exception
	 */
	public static function insertPreset(DebugAPreset $preset): int {
		try {
			$sql = 'INSERT INTO debugPresets '
					. '( name, description, listOfItemIDs ) '
					. ' VALUES '
					. '( :name, :description, :listOfItemIDs )';

			$stmt = DebugSystem::$dbConn->prepare($sql);
			$stmt->bindParam(':name', $preset->name, \PDO::PARAM_STR);
			$stmt->bindParam(':description', $preset->description, \PDO::PARAM_STR);
			if (empty($preset->listOfItemIds)) {
				$nn = null;
				$stmt->bindParam(':listOfItemIDs', $nn, \PDO::PARAM_STR);
			} else {
				$j = join(',', $preset->listOfItemIds);
				$stmt->bindParam(':listOfItemIDs', $j, \PDO::PARAM_STR);
			}
			//$stmt->bindParam(':preset_id', $preset->preset_id, \PDO::PARAM_INT);

			$r = $stmt->execute();
			if ($r) {
				$lii = DebugSystem::$dbConn->lastInsertId();
				return (int)$lii;
			} else {
				return -1;
			}
		} catch (PDOException $e) {
			print "<hr>Error!: " . $e->getMessage() . "<br/>";
			print "stmt: " . $e->getCode() . '<br>';

			throw new Exception("ERROR: fetchAll failed with: " . $e->getMessage());
		}
	}

	/** --------------------------------------------------------------------------
	 *
	 * @param type $preset
	 * @return void
	 * @throws Exception
	 */
	public static function deletePreset(DebugAPreset $preset): void {
		try {
			$idToDelete	 = $preset->preset_id;
			$sql		 = 'DELETE FROM debugPresets WHERE preset_id = :preset_id';
			$stmt		 = DebugSystem::$dbConn->prepare($sql);
			$stmt->bindParam(':preset_id', $preset->preset_id, \PDO::PARAM_INT);

			$r = $stmt->execute();
			if ($r) {
				$r = DebugSystem::$dbConn->lastInsertId();
			}
		} catch (PDOException $e) {
			print "<hr>Error!: " . $e->getMessage() . "<br/>";
			print "stmt: " . $e->getCode() . '<br>';

			throw new Exception("ERROR: fetchAll failed with: " . $e->getMessage());
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public static function ResetPresetsToDefaults() {

		$s			 = <<<EOT2

USE [CityJETSystem_DEV]
GO

/****** Object:  Table [dbo].[DebugPresets]    Script Date: 12-Jan-2021 11:11:56 AM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[DebugPresets](
	[preset_id] [int] IDENTITY(1,1) NOT NULL,
	[name] [varchar](50) NULL,
	[Description] [varchar](150) NULL,
	[listOfItemIDs] [varchar](2000) NULL
) ON [PRIMARY]
GO

GO
SET IDENTITY_INSERT [dbo].[DebugPresets] ON
GO
INSERT [dbo].[DebugPresets] ([preset_id], [name], [Description], [listOfItemIDs]) VALUES (1, N'General_Debug-XXtttwwwww', N'General_Debug-XXtttwwwww', N'1,6,7')
GO
INSERT [dbo].[DebugPresets] ([preset_id], [name], [Description], [listOfItemIDs]) VALUES (2, N'SQL_Detailed_Debug', N'SQL_Detailed_Debug', N'1,2,3,4,5,6,7,8,11,23')
GO
INSERT [dbo].[DebugPresets] ([preset_id], [name], [Description], [listOfItemIDs]) VALUES (3, N'Menu_System_Detail_Debug', N'Show as much as possible for Menu Debugging', N'4,5,1')
GO
INSERT [dbo].[DebugPresets] ([preset_id], [name], [Description], [listOfItemIDs]) VALUES (8, N'fred was here', N'fred was here', N'1,2,3,4,5,6,7,8,11')
GO
INSERT [dbo].[DebugPresets] ([preset_id], [name], [Description], [listOfItemIDs]) VALUES (9, N'detail on jobs', N'detail on jobs', N'1,3,5,7')
GO
INSERT [dbo].[DebugPresets] ([preset_id], [name], [Description], [listOfItemIDs]) VALUES (23, N'New Preset', N'New Preset', N'2,4,6,8')
GO
SET IDENTITY_INSERT [dbo].[DebugPresets] OFF
GO

EOT2;
		$stmtResult	 = DebugSystem::$dbConn->exec($s);
		echo 'inserts ' . ( $stmtResult ? 'worked' : ' didnt work');
	}

}
