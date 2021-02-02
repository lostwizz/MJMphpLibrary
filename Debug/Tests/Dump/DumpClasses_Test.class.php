<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;

use MJMphpLibrary\Debug\Dump\DumpClasses;


class DumpClasses_Test extends TestCase {

	const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, DumpClasses::Version());
	}

}
