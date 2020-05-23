<?php  declare(strict_types=1);

namespace Tests\Test;
use PHPUnit\Framework\TestCase;

use \MJMphpLibrary\Debug\Dump;
//use \MJMphpLibrary\Debug\Dump\Dump\Dump;

include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\Dump.class.php');


class Dump_Test extends TestCase {

	const VERSION = '0.0.1';

	public function test_Versions2() {


		$this->assertEquals(self::VERSION, Dump::Version());
	}



	public static function setUpBeforeClass(): void   {
		// do things before any tests start -- like change some settings
		//unlink('f:\temp\data.txt');

		$myfile = fopen('f:\temp\data.txt', "w") or die("Unable to open file!");

		for ( $i = 1; $i <100;$i++){
			fwrite($myfile, 'This is line ' . $i . PHP_EOL);
		}
		$txt = "end of fileline" . PHP_EOL;
		fwrite($myfile, $txt);
		fclose($myfile);

	}


	public static  function tearDownAfterClass() :void {
		unlink('f:\temp\data.txt');

	}







//	public function test_Version() :void {
//		$expected = self::VERSION;
//		$t = new Dump( ['flag1']);
//
//		$actual = $t->Version();
//		$this->assertEquals($expected, $actual);
//	}

	function getFileLines_DataProvider(){
		return [
			[ 1, 10,  10, 0, 0],
			[ 2, 9,  10,  1, 0],
			[ 3, 8,  10,  2 ,0],
			[ 2, 10, 10, 0, 1],
			[ 3, 10, 10, 0, 2],
			[ 4, 10, 10, 0, 3],

			[ 3, 9,  10,  1, 1],
			[ 4, 9,  10,  1, 2],
			[ 4, 8,  10,  2, 1],

			[ 5, 8,  10,  2, 2],

			[],
			[ 1,  1],
			[ 1,  1, 1],
			[ 1,  1, 1],
			[ 1,  2, 2],
			
			[ 2,  1, 2],

			[ 1,  1, 3],

//			[ 3,  10, 2],
//			[ 3,  10, 3],
//			[ 2, 15, 15, 0, 1],
//			[ 2, 15, 15, 0, 2],
//			[ 2, 15, 15, 0, 3],
//			[ 2, 15, 15, 0, 0],
//			[ 2, 14, 15, 1, 1],

			];
	}


	/**
	* @dataProvider getFileLines_DataProvider
	*/
	function test_getFileLines($numLines = 1, $inStart = 1, $inLineNum = 1, $inPreCeding = 0, $inFollowing = 0) {
//		$lines = file('f:\temp\data.txt');
//		print_r( $lines[0]);
//		echo '---------------------------';


		$ln = Dump::getFileLines('f:\temp\data.txt', $inLineNum, $inPreCeding, $inFollowing);
		$ln2 = str_replace(PHP_EOL, '', $ln);

		$expected = '';

		for ( $i = $inStart; $i < $inStart + $numLines ; $i++ ) {
			$expected .= 'This is line ' . $i;
		}

		//fwrite(STDERR, print_r($ln2, TRUE). PHP_EOL);
		//fwrite(STDERR, print_r($expected, TRUE));
		$this->assertEquals($expected, $ln2);
	}

}