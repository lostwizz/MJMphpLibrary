<?php declare(strict_types=1);

namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

//use \MJMphpLibrary\Settings;
//use \MJMphpLibrary\Settings\ASetting;

//include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Settings\src\ASetting.class.php');
use MJMphpLibrary\Settings\ASetting as ASetting;
use MJMphpLibrary\Settings\Settings;
/** ===================================================================================================
 *
 * @covers \ASetting
 */
class ASetting_TEST extends TestCase {

	const VERSION = '0.0.2';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, ASetting::Version());
	}

	function test_construct1(){
		$this->expectException(\ArgumentCountError::class);
		$as = new ASetting();
	}

	function test_construct2(){
		$this->expectException(\ArgumentCountError::class);
		$as = new ASetting('bob');
	}

	/**
	 * @depends test_construct1
	 * @depends test_construct2
	 */
	function test_construct3_andGetName(){
		$expectedName = 'bob';
		$expectedValue = 'fred';
		$as = new ASetting($expectedName, $expectedValue);

		$this->assertNotNull($as);

		$this->assertNotNull( $as->getName());

		$actualName= $as->getName($expectedName);
		$this->assertEquals($expectedName, $actualName);

		$actual = $as->getValue($expectedName);
		$this->assertEquals($expectedValue, $actual);

		$as = new ASetting($expectedName, null);
		$this->assertNotNull($as);

		$this->assertNotNull( $as->getName());
		$actualName= $as->getName($expectedName);
		$this->assertEquals($expectedName, $actualName);

		$actual = $as->getValue($expectedName);
		$this->assertNull( $actual);
	}

	/**
	 * @depends test_construct3_andGetName
	 */
	function test_setName() {
				$expectedName = 'bob';
		$expectedValue = 'fred';
		$as = new ASetting($expectedName, $expectedValue);

		$this->assertNotNull($as);

		$this->assertNotNull( $as->getName());

		$expectedNewName = 'Tony';
		$as->setName($expectedNewName);
		$this->assertNotNull( $as->getName());
		$actual_name = $as->getName();
		$this->assertEquals( $expectedNewName , $actual_name);

	}


	/**
	 * @depends test_setName
	 */
	function test_construct_codeDetails(){
		$expectedName = 'bob';
		$expectedValue = 'fred';
		$expectedCodeDetails ='some code details';
		$as = new ASetting($expectedName, $expectedValue, $expectedCodeDetails);

		$actualCD = $as->getCodeDetails($expectedName);
		$this->assertEquals( $expectedCodeDetails, $actualCD);


		$as = new ASetting($expectedName, $expectedValue, null);
		$actualCD = $as->getCodeDetails($expectedName);
		$this->assertNull(  $actualCD);
	}

	/**
	 * @depends test_construct_codeDetails
	 */
	function test_construct_timestamp(){
		$expectedName = 'bob';
		$expectedValue = 'fred';
		$expectedCodeDetails ='some code details';
		$expectedTS = (new \DateTime('now'))->modify("2 minutes 30 seconds");

		$as = new ASetting($expectedName, $expectedValue, $expectedCodeDetails);

		$actualTS = $as->getTimeStamp();
//		fwrite(STDERR, print_r($actualTS, TRUE));

		$this->assertNotEquals( $expectedTS, $actualTS);


		$expectedTS = (new \DateTime('now'))->modify("2 minutes 30 seconds");
		$as = new ASetting($expectedName, $expectedValue, $expectedCodeDetails, $expectedTS);
		$actualTS = $as->getTimeStamp();

		$this->assertEquals( $expectedTS, $actualTS);
//fwrite(STDERR, $as. PHP_EOL);

	}

	/**
	 * @depends test_construct_timestamp
	 */
	function test_isProtected(){
		$expectedName = 'bob';
		$expectedValue = 'fred';
		$expectedCodeDetails ='some code details';
		$expectedTS = new \DateTime('23:55:30');
		$as = new ASetting($expectedName, $expectedValue, $expectedCodeDetails, null);
		$actualValue = $as->getValue($expectedName);
		$this->assertEquals($expectedValue, $actualValue);

		$newExpected = 'NOT FRED';
		$as->setValue($newExpected);
		$actualValue = $as->getValue($expectedName);
		$this->assertEquals( $newExpected, $actualValue);

		$as =  new ASetting($expectedName, $expectedValue, $expectedCodeDetails, null, true);
		$newExpected = 'NOT FRED';
		$as->setValue($newExpected);
		$actualValue = $as->getValue(); //$expectedName
		$this->assertNotEquals( $newExpected, $actualValue);
		$this->assertEquals( $expectedValue, $actualValue);

		$newName ='NOT_BOB';
		$as->setName( $newName);
		$actualName  = $as->getName();
		$this->assertNotEquals($newName, $actualName);
		$this->assertEquals($expectedName, $actualName);

		$expectedNewCD = 'NOT SOME CODE DETAILS';
		$as->setCodeDetails($expectedNewCD);
		$actualCD = $as->getCodeDetails();
		$this->assertNotEquals( $expectedNewCD, $actualCD);
		$this->assertEquals($expectedCodeDetails, $actualCD);

	}

	/**
	 * @depends test_isProtected
	 */
	function test_expired() {
		$expectedName = 'bob';
		$expectedValue = 'fred';
		$expectedCodeDetails ='some code details';
		$expectedTS = (new \DateTime('now'))->modify("2 minutes 30 seconds");

		$as = new ASetting($expectedName, $expectedValue, $expectedCodeDetails, $expectedTS, false, false);

		$actualFE = $as->getForceExpiry();
		$this->assertFalse( $actualFE);
fwrite(STDERR, $as. PHP_EOL);


		$expectedTS = (new \DateTime('now'))->modify(" 10 seconds");
		$as = new ASetting($expectedName, $expectedValue, $expectedCodeDetails, $expectedTS, false, true);
		$actualFE = $as->getForceExpiry();
		$this->assertTrue( $actualFE);

fwrite(STDERR, $as. PHP_EOL);
		$actualExpired = $as->hasExpired();
		$this->assertFalse( $actualExpired);
		sleep(11);
		$actualExpired = $as->hasExpired();
		$this->assertTrue( $actualExpired);
fwrite(STDERR, $as. PHP_EOL);




	}

	function test_extendLife() {

	}


/// do something here
	function test_something22222333333() {
		$this->assertTrue(true);
	}

}