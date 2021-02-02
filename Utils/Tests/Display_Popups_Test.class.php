<?php declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Tests\Test;
use \PHPUnit\Framework\TestCase;


//include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Utils\src\Display_Popups.class.php');
use \MJMphpLibrary\Utils\Display_Popups;


/** ===================================================================================================
 *
 * @covers \Display_popups
 */
class Display_Popups_TEST extends TestCase {

	const VERSION = '0.0.1';

	public function test_Versions2() {
		$this->assertEquals(self::VERSION, Display_Popups::Version());
	}

	function test_javaScriptAlert() {
		//$this->assertFalse(true);
		$p = new Display_Popups();
		$p->javaScriptAlert('ABCDE');

		$this->expectOutputRegex('/display: inline-block;/');
//                                cursor: pointer;\r\n
//                                -webkit-user-select: none;\r\n
//                                -moz-user-select: none;\r\n
//                                -ms-user-select: none;\r\n
//                                user-select: none;\r\n/');

		$out = $this->getActualOutput();
//fwrite(STDERR, print_r($out, TRUE));
		$this->assertStringContainsString('style', $out);
		$this->assertStringContainsString('popup', $out);
		$this->assertStringContainsString('.popup', $out);
		$this->assertStringContainsString('.popup .popuptext {', $out);
		$this->assertStringContainsString('.popup .popuptext {', $out);

		$this->assertStringContainsString('.popup .popuptext::after {', $out);
		$this->assertStringContainsString('.popup .show {', $out);
		$this->assertStringContainsString('@-webkit-keyframes fadeIn {', $out);
		$this->assertStringContainsString('@keyframes fadeIn {', $out);

		$this->assertStringContainsString('</style>', $out);
		$this->assertStringContainsString('<script>', $out);

		$this->assertStringContainsString('function popUpFunction(eid) {', $out);
		$this->assertStringContainsString('var popup = document.getElementById(eid);', $out);
		$this->assertStringContainsString('popup.classList.toggle("show");', $out);

		$this->assertStringContainsString('</script>', $out);
		$this->assertStringContainsString('</script><script type="text/javascript">', $out);
		$this->assertStringContainsString("alert('ABCDE');", $out);


	}

	/**
	 * @depends test_javaScriptAlert
	 */
	function test_popup() {
		//$this->assertFalse(true);
		$p = new Display_Popups();



		//  it is needed to surpress   the output
		$this->expectOutputRegex('/@keyframes/');

		$p->popup('GHI', 'JKL');
		$out = $this->getActualOutput();

////fwrite(STDERR, print_r($out, TRUE));

		$this->assertStringContainsString('</script><div class="popup" ', $out);
		$this->assertStringContainsString('onclick="popUpFunction(\'myFunc_1\')">', $out);
		$this->assertStringContainsString('GHI<span class="popuptext" ', $out);
		$this->assertStringContainsString('id="myFunc_1">JKL</span>', $out);
		$this->assertStringContainsString('</div>', $out);

	}


}
