<?php

namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\DBUtils;



include_once('P:\Projects\_PHP_Code\MJMphpLibrary\DBUtils\src\DBUtils.class.php');


class DBUtils_TEST extends TestCase {

	const VERSION = '0.0.0';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, DBUtils::Version());
	}


}