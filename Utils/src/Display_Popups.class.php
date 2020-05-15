<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//https://www.c-sharpcorner.com/UploadFile/c63ec5/popup-boxes-in-php/

namespace MJMphpLibrary\Utils;

Class Display_Popups {


	private static int $fncounter = 1;

	/**
	 * @var version string
	 */
	private const VERSION = '0.0.1';


	function __construct() {
		$this->bringInCSS();
		$this->bringInJavaScriptAlert();
//		$this->bringInJavaScriptConfirm();
	}

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	function javaScriptAlert(string $text) {
		?><script type="text/javascript">
			alert('<?php echo $text; ?>');
		</script><?php
	}

/*	function javaSriptConfirm( string $buttonText, string $text) {
		$fnId = 'myFunc_' . strval(self::$fncounter++);

/*		?><button onclick="myFunction(<?php echo "'" . $text . "','". $fnId . "'"; ?>)"><?php echo $buttonText; ?></button>
		You Pressed <span class="{visibility: hidden;}" id="//<?php echo $fnId; ?>">!</span>

		//<?php
	}
*/

	/** -----------------------------------------------------------------------------------------------
	 *
	 * https://www.w3schools.com/howto/howto_js_popup.asp
	 *
	 * @param string $textForLink
	 * @param string $popUptext
	 * @return void
	 */
	function popup(string $textForLink, string $popUptext) :void {
		$fnId = 'myFunc_' . strval(self::$fncounter++);
		?><div class="popup" onclick="popUpFunction('<?php echo $fnId; ?>')"><?php echo $textForLink; ?>
<span class="popuptext" id="<?php echo $fnId; ?>"><?php echo $popUptext; ?></span>
</div><?php
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public function bringInJavaScriptAlert() :void {
		?><script>
			// When the user clicks on <div>, open the popup
			function popUpFunction(eid) {
				var popup = document.getElementById(eid);
				popup.classList.toggle("show");
			}
		</script><?php
	}

/*
	public function bringInJavaScriptConfirm() {
		?><script>
			function myFunction(text, eId) {
				var r = confirm(text);
				if (r == true) {
					x = "OK!";
				} else {
					x = "Cancel!";
				}
				document.getElementById(eId).innerHTML = x;
			}
		</script><?php
	}
*/


	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public function bringInCSS() :void {
		?><style>
			/* Popup container - can be anything you want */
			.popup {
				position: relative;
				display: inline-block;
				cursor: pointer;
				-webkit-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
			}

			/* The actual popup */
			.popup .popuptext {
				visibility: hidden;
				width: 160px;
				background-color: #555;
				color: #fff;
				text-align: center;
				border-radius: 6px;
				padding: 8px 0;
				position: absolute;
				z-index: 1;
				bottom: 125%;
				left: 50%;
				margin-left: -80px;
			}

			/* Popup arrow */
			.popup .popuptext::after {
				content: "";
				position: absolute;
				top: 100%;
				left: 50%;
				margin-left: -5px;
				border-width: 5px;
				border-style: solid;
				border-color: #555 transparent transparent transparent;
			}

			/* Toggle this class - hide and show the popup */
			.popup .show {
				visibility: visible;
				-webkit-animation: fadeIn 1s;
				animation: fadeIn 1s;
			}

			/* Add animation (fade in the popup) */
			@-webkit-keyframes fadeIn {
				from {opacity: 0;}
				to {opacity: 1;}
			}

			@keyframes fadeIn {
				from {opacity: 0;}
				to {opacity:1 ;}
			}
		</style><?php
	}

}
