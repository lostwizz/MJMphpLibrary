<?php declare(strict_types=1);

namespace Tests\Test;
use \PHPUnit\Framework\TestCase;

use \MJMphpLibrary\Utils\DBUtils;

//include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Utils\src\DBUtils.class.php');


/** ===================================================================================================
 *
 * @covers \DBUtils
 */
class DBUtils_TEST extends TestCase {

	const VERSION = '0.1.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, DBUtils::Version());
	}


//	function test_doExec() {
//		$this->markTestIncomplete('This test has not been implemented yet' );
//	}

	function test_checkPDOSettings(){
		$this->markTestIncomplete('This test has not been implemented yet!' );


	}



}