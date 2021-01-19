<?php  declare(strict_types=1);

namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\DATA_AuthenticateUserDetailsTable;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\DATA_AuthenticateUserDetailsTable.class.php');


/** ===================================================================================================
 *
 * @covers \DATA_AuthenticateUserDetailsTable
 */
class DATA_AuthenticateUserDetailsTable_Test  extends TestCase {
	//extends PHPUnit_Framework_TestCase

	const VERSION = '0.0.3';

	///protected $UserDetailsDB;

	private $app = 'TestApp';
	private $DB_Username = 'Mikes_DBLogging_User';
	private $DB_Password =  'DonaldDuck96';

	private $DB_Type ='sqlsrv';
	private $DB_Server= 'vm-db-prd4';
	private $DB_Database = 'Mikes_Application_Store';

	private $DB_DSN =  'sqlsrv:server=vm-db-prd4;database=Mikes_Application_Store';

	private $DB_DSN_OPTIONS =
			array(   /*\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,*/
									/*\PDO::ATTR_CASE=> \PDO::CASE_UPPER,*/
									/*\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC*/
													//PDO::ATTR_PERSISTENT => true
											);

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, DATA_AuthenticateUserDetailsTable::Version());
	}

	public function test__construct1(){
		//$this->UserDetailsDB
		$UserDetailsTbl =	new DATA_AuthenticateUserDetailsTable(
				$this->app,
				$this->DB_DSN,
				$this->DB_Username,
				$this->DB_Password,
				//$this->DB_DSN_OPTIONS
				);
		$this->assertNotNull( $UserDetailsTbl);
		return $UserDetailsTbl;
	}

	/**
	 * @depends test__construct1
	 */
	public function test_readUserDetailsByName($UserDetailsTbl) {

		$r = $UserDetailsTbl->readUserDetailsByName('merrem');
		//fwrite(STDERR, print_r(' at 3 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		$this->assertNotNull($r);
		$this->assertEquals( 'merrem', $r['username']);
		$this->assertEquals(1, $r['userid']);
		$this->assertEquals('LDAP', $r['method']);
		$this->assertEquals('TestApp', $r['app']);

		$r = $UserDetailsTbl->readUserDetailsByName('m');
		//fwrite(STDERR, print_r(' at 4 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		$this->assertNotNull($r);
		$this->assertEquals( 'm', $r['username']);
		$this->assertEquals(10, $r['userid']);
		$this->assertEquals('DB_Table', $r['method']);
		$this->assertEquals('TestApp', $r['app']);

		$r = $UserDetailsTbl->readUserDetailsByName('-NAME THAT DOES NOT EXIST');
		//fwrite(STDERR, print_r(' at 4a ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		$this->assertNull($r);



	}


	/**
	 * @depends test__construct1
	 */
	public function test_readUserDetailsByID($UserDetailsTbl) {

		$r = $UserDetailsTbl->readUserDetailsByID(1);
		//fwrite(STDERR, print_r(' at 5 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		$this->assertNotNull($r);
		$this->assertEquals( 'merrem', $r['username']);
		$this->assertEquals(1, $r['userid']);
		$this->assertEquals('LDAP', $r['method']);
		$this->assertEquals('TestApp', $r['app']);

		$r = $UserDetailsTbl->readUserDetailsByID(10);
		//fwrite(STDERR, print_r(' at 6 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		$this->assertNotNull($r);
		$this->assertEquals( 'm', $r['username']);
		$this->assertEquals(10, $r['userid']);
		$this->assertEquals('DB_Table', $r['method']);
		$this->assertEquals('TestApp', $r['app']);

	}

	/**
	 * @depends test__construct1
	 */
	public function test_updateUserDetailsDueToLogon($UserDetailsTbl) {

		$r = $UserDetailsTbl->updateUserDetailsDueToLogon(1,'2020-12-25 01:01:01', 'this ip', 'this sess id', 3 );
		$this->assertTrue($r);

		$r = $UserDetailsTbl->readUserDetailsByID(1);

		//fwrite(STDERR, print_r(' at 7 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));

		$this->assertNotNull($r);
		$this->assertEquals( 'merrem', $r['username']);
		$this->assertEquals(1, $r['userid']);
		$this->assertEquals('LDAP', $r['method']);
		$this->assertEquals('TestApp', $r['app']);
		$this->assertEquals('2020-12-25 01:01:01', $r['last_logon_time']);
		$this->assertEquals('this ip', $r['ip']);
		$this->assertEquals('this sess id', $r['session_id']);
		$this->assertEquals(3, $r['flags']);

		$r = $UserDetailsTbl->updateUserDetailsDueToLogon(1,'2020-12-26 02:02:02', 'this ip2', 'this sess id2', 4 );
		$this->assertTrue( $r);

		$r = $UserDetailsTbl->readUserDetailsByID(1);
		$this->assertNotNull($r);
		$this->assertEquals( 'merrem', $r['username']);
		$this->assertEquals(1, $r['userid']);
		$this->assertEquals('LDAP', $r['method']);
		$this->assertEquals('TestApp', $r['app']);
		$this->assertEquals('2020-12-26 02:02:02', $r['last_logon_time']);
		$this->assertEquals('this ip2', $r['ip']);
		$this->assertEquals('this sess id2', $r['session_id']);
		$this->assertEquals(4, $r['flags']);
	}

	/**
	 * @depends test__construct1
	 */
	public function test_addUserDetailsNewUser($UserDetailsTbl){


		$randomSuffix = rand(100,999999);
		//fwrite(STDERR, print_r(' at 8 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($randomSuffix, TRUE));

		$newId = $UserDetailsTbl->addUserDetailsNewUser('testusr_' . $randomSuffix,
				'password_'. $randomSuffix,
				'DB_TABLE',
				7
				);

		$r = $UserDetailsTbl->readUserDetailsByID($newId);
		//fwrite(STDERR, print_r(' at 9 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		$this->assertNotNull($r);
		$this->assertEquals( 'testusr_' . $randomSuffix, $r['username']);
		$this->assertEquals($newId, $r['userid']);
		$this->assertEquals('DB_TABLE', $r['method']);
		$this->assertEquals(7, $r['flags']);

		return $newId;
	}

	/**
	 * @depends test__construct1
	 * @depends test_addUserDetailsNewUser
	 *
	 * NOTE: this just test saving a string not encrypting a password - that is handle up stream
	 *          from this class - it will be passed a string which is the encrypted password
	 */
	public function test_updateUserDetailsWithNewPassword($UserDetailsTbl, $justAddedUserID){

		$this->assertNotNull( $justAddedUserID);
		$this->assertIsInt( $justAddedUserID);
		$this->assertTrue( $justAddedUserID >0);

		$r = $UserDetailsTbl->readUserDetailsByID($justAddedUserID);
		$oldPassword = $r['password'];
		$this->assertNotNull( $oldPassword);

		$randomSuffix = rand(100,999999);
		$newPWD = 'NEW_PWD_' .$randomSuffix;
		$r = $UserDetailsTbl->updateUserDetailsWithNewPassword($justAddedUserID, $newPWD);
		$this->assertTrue( $r);

		$r = $UserDetailsTbl->readUserDetailsByID($justAddedUserID);
		$this->assertNotEquals( $oldPassword, $r['password']);
		$this->assertEquals( $newPWD, $r['password']);
		$this->assertEquals( $justAddedUserID, $r['userid']);
		//fwrite(STDERR, print_r(' at 10 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		return $justAddedUserID;
	}

	/**
	 * @depends test__construct1
	 * @depends test_updateUserDetailsWithNewPassword
	 */
	public function test_removeUserDetailsByUserID( $UserDetailsTbl, $justAddedUserID) {

		$this->assertNotNull( $justAddedUserID);
		$this->assertIsInt( $justAddedUserID);
		$this->assertTrue( $justAddedUserID >0);

		$r = $UserDetailsTbl->readUserDetailsByID($justAddedUserID);
		$this->assertEquals( $justAddedUserID, $r['userid']);

		$x = $UserDetailsTbl->removeUserDetailsByUserID( $justAddedUserID);

		$r = $UserDetailsTbl->readUserDetailsByID($justAddedUserID);

		//fwrite(STDERR, print_r(' at 11 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));

		$this->assertNull($r);
	}

}