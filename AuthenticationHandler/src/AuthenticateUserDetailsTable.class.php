<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary;



/**
 * Description of AuthenticateUserDetailsTable
 *
 * @author merrem
 */
class AuthenticateUserDetailsTable {

	protected $DatabaseTableName = '[Mikes_Application_Store].[dbo].[UserData]';

	protected function readUserDetailsByName(string $username, string $app): bool {
		// read the table in the db using the username as the search key
		// return if successfull or not
		$sql = 'SELECT * FROM ' . $this->DatabaseTableName
				. ' WHERE app = :app AND username = :username';
	}

	protected function readUserDetailsByID(int $userID, string $app): bool {
		$sql = 'SELECT * FROM ' . $this->DatabaseTableName
				. ' WHERE app = :app AND userid = :userid';
	}

	protected function updateUserDetailsDueToLogon(
			int $userID,
			string $app,
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
	}

	protected function updateUserDetailsWithNewPassword(
			int $userid,
			string $app,
			string $newPassword): bool {
		//if the registered method save the password in the table/db
		//   only db authentication method does (LDAP no, HARDCODED no)
		//  if it does then update the password in the table/db
		$sql = 'UPDATE ' . $this->DatabaseTableName
				. ' SET password = :password'
				. ' WHERE app = :app AND userid = :userid';
	}

	protected function addUserDetailsNewUser(
			string $username,
			string $app,
			string $method
	): int {
		//insert a new row - username method,
		$sql = 'INSERT INTO ' . $this->DatabaseTableName
		. ' ( userid'
		. ' , app'
		. ' , method'
		. ' , username'
		. ' , password'
		. ' , flags'
		. ' ) values ( '
		. ' :userid'
		. ' , :app'
		. ' , :method'
		. ' , :username'
		. ' , :password'
		. ' , :flags'
		.')'
//		 [UserId]
//      ,[app]
//      ,[method]
//      ,[username]
//      ,[password]
//      ,[Flags]
//      ,[ip]
//      ,[last_logon_time]
//      ,[session_id]
	}

}
