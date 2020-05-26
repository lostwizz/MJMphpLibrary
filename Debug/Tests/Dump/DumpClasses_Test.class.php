<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;

use \MJMphpLibrary\Debug\DumpClasses;
//use \MJMphpLibrary\Debug\Dump\Dump\Dump;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpClasses.class.php');


class DumpClasses_Test extends TestCase {

	const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, DumpClasses::Version());
	}

}
