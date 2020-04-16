<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary;

require_once 'P:\Projects\_PHP_Code\MJMphpLibrary\DButils\src\DBUtils.class.php';

/**
 * Description of AuthenticateUserDetailsTable
 *
 * @author merrem
 */
class AuthenticateUserDetailsTable {

	protected $DatabaseTableName = '[Mikes_Application_Store].[dbo].[UserData]';

	private $conn;
	protected $app;

	/**
	 * @var version string
	 */
	private const VERSION = '0.0.3';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}

	function __construct(string $appname, string $dsn, string $username, string $password, $options) {
		$this->app = $appname;
		$this->conn = DBUtils::setupNewPDO( $dsn, $options, $username, $password);
	}

	private function extractResults( array $r) :?array {
//		echo '<pre>';
//		print_r($r);
//		echo '<\pre>';
		return $r;
	}
	public function readUserDetailsByName(string $username): ?array {
		// read the table in the db using the username as the search key
		// return if successfull or not
		$sql = 'SELECT * FROM ' . $this->DatabaseTableName
				. ' WHERE app = :app AND username = :username';
		$params = ['app'=> ['val'=> $this->app, 'type' => \PDO::PARAM_STR],
					'username' => ['val' => $username, 'type' =>\PDO::PARAM_STR]
				];

		$r = DBUtils::doDBSelectSingle( $this->conn, $sql, $params);
		return $this->extractResults($r);
	}

	public function readUserDetailsByID(int $userID): ?array  {

		//':roleid' => ['val' => $roleID, 'type' => \PDO::PARAM_INT],
		$sql = 'SELECT * FROM ' . $this->DatabaseTableName
				. ' WHERE app = :app AND userid = :userid';
		$params = ['app'=>		['val' => $this->app,	'type' => \PDO::PARAM_STR],
					'userid' =>	['val' => $userID,		'type' =>\PDO::PARAM_INT]
				];

		$r = DBUtils::doDBSelectSingle( $this->conn, $sql, $params);
		return $this->extractResults($r);
	}

	public function updateUserDetailsDueToLogon(
			int $userID,
			$logonTime,
			string $Ip,
			string $sessionID,
			int $flags
	): bool {
		// update the table/db with the time the user logged on and the IP
		// return if successfull or not
		$sql = 'UPDATE ' . $this->DatabaseTableName
				. ' SET last_logon_time = :last_logon_time'
				. ', ip = :ip'
				. ', session_id = :session_id'
				. ', flags = :flags'
				. ' WHERE app = :app AND userid = :userid ';

		$params = ['app'=>				['val'=> $this->app, 'type' => \PDO::PARAM_STR],
					'userid' =>			['val'=> $userID,	'type' => \PDO::PARAM_INT],
					'last_logon_time' => ['val'=> $logonTime, 'type' => \PDO::PARAM_STR],
					'ip' =>				['val'=> $Ip,		'type' => \PDO::PARAM_STR],
					'session_id' =>		['val'=> $sessionID, 'type' => \PDO::PARAM_STR],
					'flags' =>			['val'=> $flags,		'type' => \PDO::PARAM_INT]
				];
		$r = DBUtils::doDBUpdateSingle( $this->conn, $sql, $params);
		return $r;
	}

	public function addUserDetailsNewUser(
			string $username,
			string $method,
			string $password,
			string $flags
	): ?int {
		//insert a new row - username method,  -- return the new usersid
		$sql = 'INSERT INTO ' . $this->DatabaseTableName
		. ' ( app'
		. ' , method'
		. ' , username'
		. ' , password'
		. ' , flags'
		. ' ) values ( '
		. '  :app'
		. ' , :method'
		. ' , :username'
		. ' , :password'
		. ' , :flags'
		.')' ;

		$params = ['app'=>				['val'=> $this->app, 'type' => \PDO::PARAM_STR],
					'method' =>			['val'=> $method,	'type' => \PDO::PARAM_STR],
					'username' =>		['val'=> $username,	'type' => \PDO::PARAM_STR],
					'password' =>		['val'=> $password,	'type' => \PDO::PARAM_STR],
					'flags' =>			['val'=> $flags,		'type' => \PDO::PARAM_INT]
				];
		$r = DBUtils::doDBInsertReturnID( $this->conn, $sql, $params);
		return $r;
	}

	/** -----------------------------------------------------------------------------------------------
	 *  NOTE this does not encrypt anything - the encryption happens before the string gets here
	 *
	 * @param int $userid
	 * @param string $newPassword
	 * @return bool
	 */
	public function updateUserDetailsWithNewPassword(
			int $userid,
			string $newPassword
			): bool {
		//if the registered method save the password in the table/db
		//   only db authentication method does (LDAP no, HARDCODED no)
		//  if it does then update the password in the table/db
		$sql = 'UPDATE ' . $this->DatabaseTableName
				. ' SET password = :password'
				. ' WHERE app = :app AND userid = :userid';

		$params = ['app'=>			['val'=> $this->app,		'type' => \PDO::PARAM_STR],
					'userid' =>		['val' => $userid,		'type' => \PDO::PARAM_INT],
					'password' =>	['val'=> $newPassword,	'type' => \PDO::PARAM_STR],
				];
		$r = DBUtils::doDBUpdateSingle( $this->conn, $sql, $params);
		return $r;
	}

	public function removeUserDetailsByUserID($userid) : bool {
		$sql = 'DELETE FROM '. $this->DatabaseTableName
				. ' WHERE userid = :userid AND app = :app';
		$params = ['app'=>			['val'=> $this->app,		'type' => \PDO::PARAM_STR],
					'userid' =>		['val' => $userid,		'type' => \PDO::PARAM_INT],
			];
		$r = DBUtils::doExec( $this->conn, $sql, $params);
		return $r;
	}

}
