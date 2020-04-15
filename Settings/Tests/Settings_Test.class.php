<?php

namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Settings\src\Settings.class.php');
use \MJMphpLibrary\Settings;


class Settings_TEST extends TestCase {

	public function test_Versions2() {
		$this->assertEquals('0.1.0', Settings::Version());
	}

	public function test_Version() :void {
		$expected ='0.1.0';
		$t = new Settings( 'DummyApp');

		$actual = $t->Version();
		$this->assertEquals($expected, $actual);
	}
}