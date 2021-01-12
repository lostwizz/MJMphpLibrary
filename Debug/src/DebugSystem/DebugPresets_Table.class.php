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
			$stmt->bindParam(':preset_id', $preset->preset_id, \PDO::PARAM_INT);

			$r = $stmt->execute();
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
SET IDENTITY_INSERT [dbo].[DebugItems] OFF
GO
SET IDENTITY_INSERT [dbo].[DebugPresets] ON
GO
INSERT [dbo].[DebugPresets] ([preset_id], [name], [Description], [listOfItemIDs]) VALUES (1, N'General_Debug-XXtttwwwww', N'General_Debug-XXtttwwwww', N'1,6,7')
GO
INSERT [dbo].[DebugPresets] ([preset_id], [name], [Description], [listOfItemIDs]) VALUES (2, N'SQL_Detailed_Debug', N'SQL_Detailed_Debug', N'1,2,3,4,5,6,7,8,11')
GO
INSERT [dbo].[DebugPresets] ([preset_id], [name], [Description], [listOfItemIDs]) VALUES (3, N'Menu_System_Detail_Debug', N'Show as much as possible for Menu Debugging', N'4,5,1')
GO
SET IDENTITY_INSERT [dbo].[DebugPresets] OFF
GO
EOT2;
		$stmtResult	 = DebugSystem::$dbConn->exec($s);
		echo 'inserts ' . ( $stmtResult ? 'worked' : ' didnt work');
	}

}
