<?php
namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\AuthenticateUserDetailsTable;



include_once('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticateUserDetailsTable.class.php');


class AuthenticateUserDetailsTable_Test extends TestCase {

	const VERSION = '0.0.2';

	///protected $UserDetailsDB;

	private $app = 'TestApp';
	private $DB_Username = 'Mikes_DBLogging_User';
	private $DB_Password =  'DonaldDuck96';

	private $DB_Type ='sqlsrv';
	private $DB_Server= 'vm-db-prd4';
	private $DB_Database = 'Mikes_Application_Store';

	private $DB_DSN =  'sqlsrv:server=vm-db-prd4;database=Mikes_Application_Store';

	private $DB_DSN_OPTIONS = array( \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
									\PDO::ATTR_CASE=> \PDO::CASE_UPPER,
									\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
													//PDO::ATTR_PERSISTENT => true
											);

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, AuthenticateUserDetailsTable::Version());
	}

	public function test__construct1(){
		//$this->UserDetailsDB
		$conn =	new AuthenticateUserDetailsTable(
				$this->app,
				$this->DB_DSN,
				$this->DB_Username,
				$this->DB_Password,
				$this->DB_DSN_OPTIONS
				);
		$this->assertNotNull( $conn);
		return $conn;
	}

	/**
	 * @depends test__construct1
	 */
	public function test_readUserDetailsByName($conn) {

		$r = $conn->readUserDetailsByName('merrem');
		//fwrite(STDERR, print_r(' at 3 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		$this->assertNotNull($r);
		$this->assertEquals( 'merrem', $r['USERNAME']);
		$this->assertEquals(1, $r['USERID']);
		$this->assertEquals('LDAP', $r['METHOD']);
		$this->assertEquals('TestApp', $r['APP']);

		$r = $conn->readUserDetailsByName('m');
		//fwrite(STDERR, print_r(' at 4 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		$this->assertNotNull($r);
		$this->assertEquals( 'm', $r['USERNAME']);
		$this->assertEquals(10, $r['USERID']);
		$this->assertEquals('DB_Table', $r['METHOD']);
		$this->assertEquals('TestApp', $r['APP']);

	}


	/**
	 * @depends test__construct1
	 */
	public function test_readUserDetailsByID($conn) {

		$r = $conn->readUserDetailsByID(1);
		//fwrite(STDERR, print_r(' at 5 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		$this->assertNotNull($r);
		$this->assertEquals( 'merrem', $r['USERNAME']);
		$this->assertEquals(1, $r['USERID']);
		$this->assertEquals('LDAP', $r['METHOD']);
		$this->assertEquals('TestApp', $r['APP']);

		$r = $conn->readUserDetailsByID(10);
		//fwrite(STDERR, print_r(' at 6 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		$this->assertNotNull($r);
		$this->assertEquals( 'm', $r['USERNAME']);
		$this->assertEquals(10, $r['USERID']);
		$this->assertEquals('DB_Table', $r['METHOD']);
		$this->assertEquals('TestApp', $r['APP']);

	}

	/**
	 * @depends test__construct1
	 */
	public function test_updateUserDetailsDueToLogon($conn) {

		$r = $conn->updateUserDetailsDueToLogon(1,'2020-12-25 01:01:01', 'this ip', 'this sess id', 3 );
		$this->assertTrue($r);

		$r = $conn->readUserDetailsByID(1);

		//fwrite(STDERR, print_r(' at 7 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));

		$this->assertNotNull($r);
		$this->assertEquals( 'merrem', $r['USERNAME']);
		$this->assertEquals(1, $r['USERID']);
		$this->assertEquals('LDAP', $r['METHOD']);
		$this->assertEquals('TestApp', $r['APP']);
		$this->assertEquals('2020-12-25 01:01:01', $r['LAST_LOGON_TIME']);
		$this->assertEquals('this ip', $r['IP']);
		$this->assertEquals('this sess id', $r['SESSION_ID']);
		$this->assertEquals(3, $r['FLAGS']);

		$r = $conn->updateUserDetailsDueToLogon(1,'2020-12-26 02:02:02', 'this ip2', 'this sess id2', 4 );
		$this->assertTrue( $r);

		$r = $conn->readUserDetailsByID(1);
		$this->assertNotNull($r);
		$this->assertEquals( 'merrem', $r['USERNAME']);
		$this->assertEquals(1, $r['USERID']);
		$this->assertEquals('LDAP', $r['METHOD']);
		$this->assertEquals('TestApp', $r['APP']);
		$this->assertEquals('2020-12-26 02:02:02', $r['LAST_LOGON_TIME']);
		$this->assertEquals('this ip2', $r['IP']);
		$this->assertEquals('this sess id2', $r['SESSION_ID']);
		$this->assertEquals(4, $r['FLAGS']);
	}

	/**
	 * @depends test__construct1
	 */
	public function test_addUserDetailsNewUser($conn){


		$randomSuffix = rand(100,999999);
		//fwrite(STDERR, print_r(' at 8 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($randomSuffix, TRUE));

		$newId = $conn->addUserDetailsNewUser('testusr_' . $randomSuffix,
				'DB_TABLE',
				'password_'. $randomSuffix,
				7
				);

		$r = $conn->readUserDetailsByID($newId);
		//fwrite(STDERR, print_r(' at 9 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));
		$this->assertNotNull($r);
		$this->assertEquals( 'testusr_' . $randomSuffix, $r['USERNAME']);
		$this->assertEquals($newId, $r['USERID']);
		$this->assertEquals('DB_TABLE', $r['METHOD']);
		$this->assertEquals(7, $r['FLAGS']);

		return $newId;
	}

	/**
	 * @depends test__construct1
	 * @depends test_addUserDetailsNewUser
	 *
	 * NOTE: this just test saving a string not encrypting a password - that is handle up stream
	 *          from this class - it will be passed a string which is the encrypted password
	 */
	public function test_updateUserDetailsWithNewPassword($conn, $justAddedUserID){

		$this->assertNotNull( $justAddedUserID);
		$this->assertIsInt( $justAddedUserID);
		$this->assertTrue( $justAddedUserID >0);

		$r = $conn->readUserDetailsByID($justAddedUserID);
		$oldPassword = $r['PASSWORD'];
		$this->assertNotNull( $oldPassword);

		$randomSuffix = rand(100,999999);
		$newPWD = 'NEW_PWD_' .$randomSuffix;
		$r = $conn->updateUserDetailsWithNewPassword($justAddedUserID, $newPWD);
		$this->assertTrue( $r);

		$r = $conn->readUserDetailsByID($justAddedUserID);
		$this->assertNotEquals( $oldPassword, $r['PASSWORD']);
		$this->assertEquals( $newPWD, $r['PASSWORD']);
		$this->assertEquals( $justAddedUserID, $r['USERID']);
		//fwrite(STDERR, print_r(' at 10 ---------------------------------' .PHP_EOL, TRUE));
		//fwrite(STDERR, print_r($r, TRUE));

	}

}