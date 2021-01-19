<?php  declare(strict_types=1);



namespace Tests\Test;
use PHPUnit\Framework\TestCase;


include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Encryption\src\Encryption.class.php');

use \MJMphpLibrary\Encryption;


/** ===================================================================================================
 *
 * @covers \Encryption
 */
class Encryption_Test extends TestCase {
	const VERSION = '0.5.0';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, Encryption::Version());
	}

//	public function test_Version() :void {
//		$expected = self::VERSION;
//		$t = new Encryption( ['flag1']);
//
//		$actual = $t->Version();
//		$this->assertEquals($expected, $actual);
//	}


	public function test_construct(){

		$encriptionCL = new Encryption( 'This is some random encryption key');

		$expected = 'aaa';
		$encrypted = $encriptionCL->encrypt( $expected, false);
		$unencrypted = $encriptionCL->decrypt($encrypted, false);
		$this->assertEquals( $expected, $unencrypted);

		$encriptionCL2 = new Encryption( 'This is some random encryption key');


		$expected = 'aaa';
		$encrypted = $encriptionCL->encrypt( $expected, false);
		$unencrypted = $encriptionCL2->decrypt($encrypted, false);
		$this->assertEquals( $expected, $unencrypted);

		$encriptionCL3 = new Encryption( 'This is some OTHER random encryption key');

		$expected = 'aaa';
		$encrypted = $encriptionCL->encrypt( $expected, false);
		$unencrypted = $encriptionCL3->decrypt($encrypted, false);
		$this->assertNotEquals( $expected, $unencrypted);




	}
}