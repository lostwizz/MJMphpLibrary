<?php declare(strict_types=1);

namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\Settings;
use \MJMphpLibrary\Settings\ASetting;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Settings\src\ASetting.class.php');

class ASetting_TEST extends TestCase {

	const VERSION = '0.0.0';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, ASetting::Version());
	}



}