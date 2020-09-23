<?php declare(strict_types=1);

namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Settings\src\Settings.class.php');
use \MJMphpLibrary\Settings;



//***********************************************************************************************
class anExtendedSettings extends Settings {
	const READYNESS = parent::READYNESS;
	public function ExtendedGiveINISetting($value){
		return parent::giveINISetting($value);
	}

	public function x (){
		return parent::$settingsList;
	}
}


//***********************************************************************************************
    /**
     * @backupStaticAttributes enabled
     */
class Settings_TEST extends TestCase {

	const VERSION = '0.0.1';


	public  function setup(): void{
	//	Settings::$settingsList = [];
		Settings::clearAllSettingLists(false);
	}



	public function test_Versions2() {
		$this->assertEquals(self::VERSION, Settings::Version());
	}

//	public function test_Version() :void {
//		$expected =self::VERSION;
//		$t = new Settings( 'DummyApp');
//
//		$actual = $t->Version();
//		$this->assertEquals($expected, $actual);
//	}

	//protected $backupGlobalsBlacklist= Settings;

	function test_init(){
		$o = new anExtendedSettings();
		fwrite(STDERR, print_r($o, TRUE));
		$actual = $o->x();
		fwrite(STDERR, print_r($actual, TRUE));
		$this->assertEmpty( $actual);
		$this->assertEquals( 0, count($actual));

		$rrr =  anExtendedSettings::READYNESS;
		$o::init();
		$actual = $o->x();
		$this->assertNotEmpty( $actual);
		$this->assertEquals( 3, count($actual));

		$this->assertNotEmpty( $actual[Settings::RUNTIME]);
		$this->assertEquals( 1, count($actual[Settings::RUNTIME]));

		$this->assertTrue( $actual[Settings::RUNTIME][anExtendedSettings::READYNESS]);
		$this->assertTrue( $actual[Settings::PUBLIC][anExtendedSettings::READYNESS]);
		$this->assertTrue( $actual[Settings::PROTECTED][anExtendedSettings::READYNESS]);

		$this->assertFalse( isset($actual[Settings::RUNTIME]['a']) );
	}

	function test_isListReady(){
		$this->assertTrue(Settings::isListReady(Settings::RUNTIME));
		$this->assertTrue(Settings::isListReady(Settings::PUBLIC));
		$this->assertTrue(Settings::isListReady(Settings::PROTECTED));
		$this->assertFalse(Settings::isListReady('a'));
	}



	function test_settingCount() {

	}






}

