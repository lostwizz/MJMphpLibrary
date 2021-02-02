<?php
declare(strict_types=1);

namespace MJMphpLibrary\Debug\MessageLog;

define ('MSGLOG_BEGIN',				0b0000_0000_0000_0001);
define ('MSGLOG_RESULT',			0b0000_0000_0000_0010);
define ('MSGLOG_ERROR',				0b0000_0000_0000_0100);
define ('MSGLOG_UNEXPECTED',		0b0000_0000_0000_1000);
define ('MSGLOG_ASSERT_NOT_EQUALS',	0b0000_0000_0001_0000);
define ('MSGLOG_ASSERT_EQUALS',		0b0000_0000_0010_0000);
define ('MSGLOG_ASSERT_NOT_NULL',	0b0000_0000_0100_0000);
define ('MSGLOG_ASSERT_NULL',		0b0000_0000_1000_0000);
define ('MSGLOG_ASSERT_EMPTY',		0b0000_0001_0000_0000);
define ('MSGLOG_ASSERT_NOT_EMPTY',	0b0000_0010_0000_0000);



//trait Trait_base_class {
trait MessageLogBaseTrait {

	public $mask = MSGLOG_BEGIN || MSGLOG_RESULT;

	public $fakeBTforTesting = null;
	public $fakeBTextraForTesting = 0;

	function dump(){

		ECHO '<BR>';
		echo 'msglog_begin=' , MSGLOG_BEGIN;
		ECHO '<BR>';
		echo 'msglog_RESULT=' , MSGLOG_RESULT;
		ECHO '<BR>';

		ECHO 'MSGLOG_BEGIN AND B0001=';
		ECHO ( MSGLOG_BEGIN & 0b0001);
		ECHO '<BR>';

		ECHO 'MSGLOG_BEGIN AND B0010=';
		ECHO ( MSGLOG_BEGIN & 0b0010);
		ECHO '<BR>';

		ECHO 'MSGLOG_BEGIN AND B0011=';
		ECHO ( MSGLOG_BEGIN & 0b0011);
		ECHO '<BR>';

	}

	function giveLocation($bt_extra =0){
		if (defined("IS_PHPUNIT_TESTING")) {
			$bt = $this->fakeBTforTesting;
			$bt_extra = $this->fakeBTextraForTesting;
		} else {
			$bt = debug_backtrace( 0);
		}
		$bt = $bt[ count($bt)  - $bt_extra -1 ];

		$out = '';
		$out .= basename( $bt['file']);
		$out .= '-';
		if ( array_key_exists('class', $bt)){
			$out .= $bt['class'] ;
		}
		$out .= '->';
		$out .= $bt['function'];
		$out .= '(';
		//$out .= print_r($bt['args'], true);
		$out .= serialize($bt['args']);
		$out .= ')';
		$out .= ' {line:' . $bt['line'] . '}';
		$out .= ' #' . $this->mask . '#';

		return $out;
	}


	function msg($ar, $bt_extra = 0) {
		if (defined("IS_PHPUNIT_TESTING")) {
			$bt = $this->fakeBTforTesting;
			$bt_extra = $this->fakeBTextraForTesting;

			$l = $this->giveLocation($bt_extra, $bt);
		} else {
			$l = $this->giveLocation($bt_extra);
		}

		$out = $l;
		//echo '<BR>';
		$out .= '&nbsp;';
		if ( is_string( $ar)) {
			$out .= $ar;
		} else {
			$out .= print_r( $ar, true) ;
		}
		$out .= '<BR>'; // . PHP_EOL;

		if (defined("IS_PHPUNIT_TESTING")) {
			return $out;
		} else {
			echo $out;
			return true;
		}
	}

	function msgLogBegin(...$ar){
		if ( ($this->mask & MSGLOG_BEGIN)){
			return $this->msg($ar, 2);
		}
	}

	function msgLogResult( ...$ar) {
		if ( ($this->mask & MSGLOG_RESULT)){
			return $this->msg($ar, 2);
		}
	}

	function msgLogAssertEquals( $a, $b){
		if (($this->mask & MSGLOG_ASSERT_EQUALS)) {
			if ($a == $b ){
				$ar[] = ' ASSERTED-EQUALS ';
			} else {
				$ar[] = ' ASSERTED-EQUALS(NOT!) ';
			}
			return $this->msg( $ar, 2);
		}
	}

	function msgLogAssertNotEquals( $a, $b) {
		if (($this->mask & MSGLOG_ASSERT_NOT_EQUALS)) {
			if ($a != $b ){
				$r = ' ASSERTED-NOT-EQUALS ';
			} else {
				$r = ' ASSERTED-EQUALS(bad) ';
			}
			return $this->msg( $r, 2);
		}
	}

	function msgLogAssertNull($a){
		if (($this->mask & MSGLOG_ASSERT_NULL)) {
			if ( is_null( $a)) {
				$r =  ' ASSERTED-NULL';
			} else {
				$r = ' ASERTED-NULL(NOT!)';
			}
			return $this->msg( $r, 2);
		}
	}

	function msgLogAssertNotNull($a){
		if (($this->mask & MSGLOG_ASSERT_NOT_NULL)) {
			if ( ! is_null( $a)) {
				$r =  ' ASSERTED-NOT-NULL';
			} else {
				$r = ' ASERTED-NULL(bad))';
			}
			return $this->msg( $r, 2);
		}
	}

	function msgLogAsertEmpty($a) {
		if (($this->mask & MSGLOG_ASSERT_EMPTY)) {
			if ( empty( $a)) {
				$r =  ' ASSERTED-EMPTY';
			} else {
				$r = ' ASERTED-EMPTY(NOT!)';
			}
			return $this->msg( $r, 2);
		}
	}

	function msgLogAsertNotEmpty($a) {
		if (($this->mask & MSGLOG_ASSERT_NOT_EMPTY)) {
			if ( empty( $a)) {
				$r =  ' ASSERTED-NOT-EMPTY';
			} else {
				$r = ' ASERTED-EMPTY(bad)';
			}
			return $this->msg( $r, 2);
		}
	}



}







/*
 *
 * Example code:
 *
 *
 */
/*


class fred {
	use Trait_base_class;

	function __construct(){
		$this->dump();
	}

	function tony($text = 'default'){

		echo '<BR>';echo '<BR>';
		$this->msgLogBegin(' starting function', 3);
		echo 'this is freds tony:'  . $text;
		echo'<BR>';

		$this->msgLogResult(' result in fred', 4,5,6);

		$this->msgLogAssertEquals( $text, 0);
	}

	function msgit($text) {
		$this->msg( $text, 1);
	}


}

$x = new fred();
$x2 = new fred();

$x->mask = 0b0011;
$x->tony('+++++++++');
$x->msgit('hi');

$x2->mask = 0b0010;

$x2->msgit('x2');
$x2->tony();

$x->msgit('x');


$x->mask = 0b0010;
$x->tony('%%%%%%%%%%%%%%%%');


$x->mask = 0b0011;
$x->tony('***t2****');

$x->mask = 0b0100;
$x->tony('***t3****');


echo'^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^<BR>';
$x->mask = ($x->mask | MSGLOG_ASSERT_EQUALS) ;
$x->tony( 1);
$x->tony( 0);

echo'^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^<BR>';
echo'^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^<BR>';

$x->mask = 0b1111_1111_1111;
$x->tony(1);


#

echo '<BR>';
echo '. all done :-(';


*/