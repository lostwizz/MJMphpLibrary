<?php

declare(strict_types=1);

ini_set('display_errors', '1');

//define( 'MyLibDIR', realpath('.') );
include_once( realpath('.') . '\autoload.php');

use MJMphpLibrary\FlagHandler\FlagHandler as FlagHandler;

if (false) {
	echo '--------FlagHandler section------------------------<BR>';

	echo '<pre>';
	//print_r( get_declared_classes() );
	echo '</pre>';
	echo '<BR>';

	$x = new FlagHandler(['dummy']);

	$y = $x->Version();
	echo 'Version=' . $y;

	echo '<BR>';

	$x = new FlagHandler(['dummy', 'dummy two']);
	echo '<pre>';
	//print_r( get_declared_classes() );
	print_r($x);

	$x->setFlagOn('dummy');
	print_r($x);
	$x->setFlagOff('dummy');
	print_r($x);

	$a = $x->isFlagSet('dummy');
	print_r($a ? 'true' : 'false');

	$a = $x->setFlagOn('dummy');
	print_r($a ? 'true' : 'false');

	$x->setFlagOn('dummy two');
	$a = $x->isFlagSet('dummy two');
	print_r($a ? 'true' : 'false');

	//print_r($x);

	echo '</pre>';
	echo '<BR>';
	echo '<BR>--------Done------------------------<BR><HR color="blue" size=4><BR>';
}

use MJMphpLibrary\AuthenticationHandler\AuthenticationHandler as AuthenticationHandler;
if (false) {
	echo '--------AuthenticationHandler section------------------------<BR>';

	//$auth = new MJMphpLibrary\AuthenticationHandler\AuthenticationHandler('TestApp');
	$auth = new AuthenticationHandler('TestApp');

	echo '<HR size=2>';

	$auth->showLogin();
	echo '<HR size=2>';

	$auth->showForgotPassword();
	echo '<HR size=2>';

	$auth->showChangePassword();
	echo '<HR size=2>';

	$auth->showSignup();
	echo '<HR size=2>';
	echo '<BR>--------Done------------------------<BR><HR color="blue" size=4><BR>';
}

use MJMphpLibrary\Settings\Settings as Settings;
use MJMphpLibrary\Settings\ASetting as ASetting;
IF (false) {
	echo '--------Settings section------------------------<BR>';

	echo Settings::isReady() ? '-y-' : '-n-';
	Settings::init();
	echo Settings::isReady() ? '-y-' : '-n-';

	$value = 4;
	Settings::setValue(Settings::RUNTIME, 'aname', $value);

	$r = Settings::getValue(Settings::RUNTIME, 'aname');
	echo '<pre>';
	print_r($r);
	echo '>>' . $r . '<<';
	echo '</php>';

	//$x = ASetting::DefaultExpireTimeout ;
//	$x = 3;
//	print_r($x);
	$now = new \DateTime('now');
	//$exp = $now + $x;
	$exp = $now->modify("+3 seconds");
	Settings::setValue(Settings::RUNTIME, 'fred', 3.4, null, $exp);

	$r = Settings::getFullSetting(Settings::RUNTIME, 'fred');
	echo '<pre>+++' . PHP_EOL;
	print_r($r);
	echo '[[[' . $r . ']]]';

	echo ($r->hasExpired() ? 'Expired' : 'not expired' ) . ' ' . $r . PHP_EOL;
	sleep(4);
	echo ($r->hasExpired() ? 'Expired' : 'not expired' ) . ' ' . $r . PHP_EOL;
	sleep(1);
	echo ($r->hasExpired() ? 'Expired' : 'not expired' ) . ' ' . $r . PHP_EOL;
	sleep(1);
	echo ($r->hasExpired() ? 'Expired' : 'not expired' ) . ' ' . $r . PHP_EOL;
	//print_r($w1);
	//print_r($w2);
	echo '+++</php>';

	$s = Settings::toString();
	echo '<pre>';
	print_r($s);
	echo '</php>';

	echo $r;
	$r->extendLife(200);
	echo $r;
	echo '<BR>' . PHP_EOL;

	$r->setProtected(true);
	echo $r;
	$r->extendLife(200);
	echo $r;
	echo '<BR>' . PHP_EOL;

	$r->setProtected(false);
	$r->setForceExpiry(true);
	echo $r;
	echo '<BR>' . PHP_EOL;

	$r->extendLife(-40);
	echo $r;
	echo '<BR>' . PHP_EOL;

	$now = new \DateTime('now');
	print_r($now);
	$exp = $now->modify("+2 seconds");
	print_r($exp);

	echo 'before:', $r;
	$r->setTimeStamp($exp);
	echo '%after%%%' . $r;
	sleep(2);
	echo $r->getValue() ?? ' cant it expired';
	echo '<BR>' . PHP_EOL;

	echo '<BR>--------Done------------------------<BR><HR color="blue" size=4><BR>';
}

use MJMphpLibrary\Utils\Display_Popups;
if (false) {
	echo '--------popups section------------------------<BR>';

	//echo $x ?? false ? '=t=' : '=f=';
//echo '<script type="text/javascript">
//          window.onload = function () { alert("Welcome at c-sharpcorner.com."); }
//</script>';

	echo '<BR><BR><BR>';
// https://www.w3schools.com/howto/howto_js_popup.asp


	$p = new Display_Popups();
	$p->javaScriptAlert(' Mike was here');

	$p->popup('click to see mike', 'mike left here');

	echo '<BR><BR><BR>';
	$p->popup('click to see fred', ' fred was sometimes here');
	$p->popup('click to see sam', ' sam gone');
	echo '<BR><BR><BR>';

	/////////$p->javaSriptConfirm('button text', 'popuptext');
	echo '<BR><BR><BR>';
	echo '<BR>--------Done------------------------<BR><HR color="blue" size=4><BR>';
}

use MJMphpLibrary\Debug\Dump\DumpConfigSet;
use MJMphpLibrary\Debug\Dump\Dump as Dump;
if (false) {

	echo '--------Dump section------------------------<BR>';







	$a=1; $b =2; $c=3;



	$configSet = new DumpConfigSet();

//	$u =  0xffffff;
//	$u1 = $u - 0x001100;
//	$u2 = $u1 - 0x001100;
//	dump::dump(  dechex($u), dechex($u1), dechex($u2));

///	$fn =  'F:\temp\__data__.txt';
///	$y = file($fn);
//	$count = 1;
//	foreach( $y as $i){
//		echo '<Br>', $count++, '==>', $i;
//	}
	$x = Dump::getFileLines($fn,10,1,1 );
	echo '<pre>X';
	print_r( $x);
	echo 'X</pre>';

	Dump::Dump(1, 2, 3, 4, 5, /*6, 7, 8, 9, 10, 11, 12, 13,*/ 14, 15, 16, $configSet);


	for ($j = 1; $j < 10; $j++) {
		//Dump::Dump($j, $configSet);
		Dump::Dump($j, 1, 2, /*3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13,*/ 14, 15, 16, $configSet);
		$configSet->tabOver();
		echo '<BR> some text <br>';
	}

	MJMphpLibrary\Debug\Dump\dumpZ('fred was here');

//		echo '<pre>';
//		print_r($x->tabOverSet);
//		echo '</pre>';
//  -- broke when i made the var protected rather than public
//	foreach ($configSet->tabOverSet as $i) {
//		echo '<span style="background-color: ' . $i['OverallBackgroundColor'] . '; color: ' . $i['OverallText_Color'] . '">';
//		echo $i['OverallBackgroundColor'];
//		echo '&nbsp;&nbsp;&nbsp;';
//		echo $i['OverallText_Color'];
//
//		echo '</span>';
//		echo '<br>' . PHP_EOL;
//	}
	//echo '<pre>';
	//print_r( get_declared_classes());
	//print_r( get_class_methods( 'MJMphpLibrary\Debug\Dump' ));
	//echo '++++++++++>';
	echo $configSet->OverallBackgroundColor;
	//echo '<++++++++++';
	//echo '</pre>';

	$a	 = array(1, 2, 3);
	$b	 = false;
	$n	 = 12.13;
	$s	 = 'hello world';
	Dump::Dump($a, $b, $s, $configSet, $n);

	Dump::Dump($configSet);

	//$configSet = new DumpConfigSet();
	Dump::Dump([6, 7, 8, 9]);

	bob();

	$configSet->tabBack();
	$configSet->tabBack();

	Dump::Dump($_SERVER, $configSet);

	$configSet->tabOver();
	Dump::Dump([6, 7, 8, 9], $configSet);

	Dump::Dump(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, $configSet);

	$configSet->reset();
	Dump::Dump([6, 7, 8, 9], $configSet);
	echo '<BR>--------Done------------------------<BR><HR color="blue" size=4><BR>';
}

function bob() {
	$a	 = array(1, 2, 3);
	$b	 = false;
	$n	 = 12.13;
	$s	 = 'hello world';

echo '</pre>';
	Dump::Dump($a, $b, $s, $n);

}


use \MJMphpLibrary\Debug\Dump\DumpClasses as DumpClasses;
if (false) {

	echo '--------DumpClasses section------------------------<BR>';

	//print_r(get_declared_classes());

	echo '@@@@@@@@@@@@@@@@@@@@@@@@@ dump classes@@@@@@@@@@@@@@';
	//DumpClasses::DumpClasses();
	DumpClasses::DumpClasses();
	echo '@@@@@@@@@@@@@@@@@@@@@@@@@ dump classes@@@@@@@@@@@@@@';
	echo '<BR>--------Done------------------------<BR><HR color="blue" size=4><BR>';
}

use MJMphpLibrary\Dump\MessageLog\MessageLogBaseTrait as MessageLogBaseTrait;
if (false) {
	echo '--------MessageLog section------------------------<BR>';

	echo '@@@@@@@@@@@@@@@@@@@@@@@@@ dump classes@@@@@@@@@@@@@@';

	echo '<pre>traits';
	print_r(get_declared_traits());
	echo '</pre>';

	class fred {

		use MJMphpLibrary\Debug\MessageLog\MessageLogBaseTrait;

		function __construct() {
			$this->dump();
		}

		function tony($text = 'default') {

			echo '<BR>';
			echo '<BR>';
			$this->msgLogBegin(' starting function', 3);
			echo 'this is freds tony:' . $text;
			echo'<BR>';

			$this->msgLogResult(' result in fred', 4, 5, 6);

			$this->msgLogAssertEquals($text, 99);
		}

		function msgit($text) {
			$this->msg($text, 1);
		}

	}

	$x	 = new fred();
	$x2	 = new fred();

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
	$x->mask = ($x->mask | MSGLOG_ASSERT_EQUALS);
	$x->tony(1);
	$x->tony(99);

	echo'^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^<BR>';
	echo'^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^<BR>';

	$x->mask = 0b1111_1111_1111_1111;
	$x->tony(1);



//	$v = $x->Version();
//	echo '******Ver = ', $v, '************';
	#
	echo '<BR>--------Done------------------------<BR><HR color="blue" size=4><BR>';
}

//debugSystem
use MJMphpLibrary\Debug\DebugSystem\DebugSystem as DebugSystem;
if (false) {
	echo '--------DebugSystem section------------------------<BR>';

//	MJMphpLibrary\Debug\Dump::dump( 'info', $postVars);
//	echo '<pre>request=';
////	print_r( $_REQUEST);
//	print_r( $_POST);
//	echo '</pre>';

	DebugSystem::initialize();

	//DebugSystem::debug(null, get_defined_functions());
	//DebugSystem::debug( '_REQUEST', $_REQUEST);
	DebugSystem::debug('_POST', $_POST);
	echo '<hr size=4 color=cyan">';

//	$postVars = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING);
//	Dump::dump( $postVars);
//	DebugSystem::debug( 'sam', $postVars);

	DebugSystem::debug('info', PHP_INT_SIZE); //prints 4
	echo '----';
	DebugSystem::debug('info', PHP_INT_MAX); //prints 2147483647
	echo '<hr size=1>';

	DebugSystem::showSettings();
	echo '<hr size=1>';

	//DebugSystem::debug( DebugSystem::DEBUG_SHOW_ALL, 'one', 'two', 'three');
	DebugSystem::debug(null, 'one', 'two', 'three');

	//DebugSystem::debug( '_REQUEST',  'two', $_REQUEST);
	DebugSystem::debug('_request', 'three', $_POST);

	echo '<hr size=1>';
	$sql = 'SELECT item_id, codex, description, owner, level, foregroundColor, backgroundColor, textsize, $categoryId '
			. ' FROM debug_items ';
	DebugSystem::debug('SQL', $sql);
	echo '<hr size=1>';
	DebugSystem::debug('bob', 'bob was here');
	echo '<hr size=1>';

	bobby();
	echo '<hr size=1>';
	DebugSystem::debug(null, 'nine', 'ten');
	echo '<hr size=1>';

	//echo MJMphpLibrary\Debug\DebugSystem\DebugAnItem::giveFlagSelect( 5, 33);
//	for( $i=0 ; $i< 2048; $i++) {
//		$s = MJMphpLibrary\Debug\DebugSystem\DebugAnItem::strFlags( $i);
//		echo $i, '-' , $s;
//		echo '<br>' . PHP_EOL;
//	}
	echo '<BR>--------Done------------------------<BR><HR color="blue" size=4><BR>';
}

function bobby() {
	DebugSystem::debug('sAm', 'five', 'six', 'seven', 'method=', __METHOD__);
	DebugSystem::debug(null, 'one-bobby', 'two-bobby', 'three-bobby');
}

use MJMphpLibrary\Encryption\Encryption as Encryption;
if (false) {
	echo '--------Encryption section------------------------<BR>';

	// encryption testing

	$encrypt = new Encryption('fred was here');

	$x	 = 'This has been sucessfully Decrypted!';
	$en	 = $encrypt->encrypt($x, false);
	echo $en;
	echo '<BR>';
	echo '<BR>';
	$un	 = $encrypt->decrypt($en, false);
	echo $un;
	echo '<BR>';
	echo ($x == $un) ? 'ok on decrypt' : 'error on decrypt';
	echo '<BR>';


	$x	 = 'This has been sucessfully Decrypted!';
	$en	 = $encrypt->encrypt($x, true);
	echo 'this---', $en;
	echo '<BR>';
	echo '<BR>';
	//echo hex2bin( $en);
	echo '<BR>';
	echo '<BR>';
	$un	 = $encrypt->decrypt($en, true);
	echo $un;
	echo '<BR>';
	echo ($x == $un) ? 'ok on decrypt' : 'error on decrypt';
	echo '<BR>';

	$x	 = 123456789;
	$en	 = $encrypt->encrypt((string) $x, false);
	echo $en;
	echo '<BR>';
	echo '<BR>';
	echo '<BR>';
	$un	 = $encrypt->decrypt($en, false);
	echo $un;
	echo '<BR>';
	echo ($x == $un) ? 'ok on decrypt' : 'error on decrypt';
	echo '<BR>';


	$x	 = 'This has been sucessfully Decrypted!';
	$en	 = '4ON1faF2c2zb7fxtIvQ3Vdry3T1JfGqFjaEe07g/5GOJYq8tOjp6+MvwDaINsIs6YItII9iV';
	echo '<BR>';
	echo '<BR>';
	$un	 = $encrypt->decrypt($en, true);
	echo $un;
	echo '<BR>';
	echo ($x == $un) ? 'ok on decrypt' : 'error on decrypt';
	echo '<BR>';

	echo '<BR>--------Done------------------------<BR><HR color="blue" size=4><BR>';
}


if (false) {
	echo '--------test a class thing section------------------------<BR>';

	$a = new one();
	$a->a()->b()->c();

//	$data = [ 'c','d', 'e','f','g','h'];
//
//	dump::dump( array_fill(0, count($data), ','));
//
//		$csvLines='';
//		$data = array_filter($data);
//	dump::dump($data);
//
//		$csvLines =+ array_map('implode', $data, array_fill(0, count($data), ','));
//
//	dump::dump($csvLines);
	echo '<BR>--------Done------------------------<BR><HR color="blue" size=4><BR>';
}



//use thecodeholic\phpmvc\Application;
if ( true) {
	$dirry = dirname(__DIR__) . '\MJMphpLibrary';

	$dirry2 =  $dirry . '\\vendor\\autoload.php';
	require_once $dirry2 ;
	$dotenv = \Dotenv\Dotenv::createImmutable($dirry);

	$dotenv->load();

//	dump::dump( $_ENV);

	$dsn = $_ENV['DB_CONNECTION'] . ':Server=' . $_ENV['DB_HOST'] . ';Database='. $_ENV['DB_DATABASE'];
	dump::dump($_ENV['DB_DSN']?? 'nul' );

dump::dump( $dsn);




}




class one {

	function __construct() {

	}

	public function a() {
		echo 'a';
		return $this;
	}

	public function b() {
		echo 'b';
		return $this;
	}

	public function c() {
		echo 'c';
		return $this;
	}

}

echo '--------doing the Ending section------------------------<BR>';



echo '<BR>';
echo '<BR>';

echo '<BR>';

//phpinfo();
//xdebug_info();

echo '. all done :-(';
echo '<BR>--------Done------------------------<BR><HR color="blue" size=4><BR>';
