<?php
declare(strict_types=1);

use MJMphpLibrary\Settings;
use MJMphpLibrary\Settings\ASetting;
use MJMphpLibrary\Utils\Display_Popups;

use MJMphpLibrary\Debug\Dump\DumpConfigSet;
use MJMphpLibrary\Debug\Dump as Dump;

use \MJMphpLibrary\Debug\DumpClasses;

use \MJMphpLibrary\Dump\MessageLog\MessageLogBaseTrait as MessageLogBaseTrait;




//
////echo __DIR__;
////$ff = __DIR__ . '\FlagHandler\src\FlagHandler.class.php';
//echo '<BR>';
//
////echo $ff;
////echo '<BR>';
//
////echo realpath('.');
////echo '<BR>';
//
////include_once($ff);
//echo __DIR__;
//echo '<BR>';
//
//echo __DIR__ . '\FlagHandler\src\FlagHandler.class.php';
//echo '<BR>';
//
//include_once(__DIR__ . '\FlagHandler\src\FlagHandler.class.php');
////D:\Projects\_PHP_Code\MJMphpLibrary\FlagHandler\src\FlagHandler.class.php
//echo '<BR>';
//
//echo '<pre>';
////print_r( get_declared_classes() );
//echo '</pre>';
//echo '<BR>';
//
//$x = new MJMphpLibrary\FlagHandler(['dummy']);
//
//$y = $x->Version();
//echo 'Version=' . $y;
//
//echo '<BR>';
//
//$x = new MJMphpLibrary\FlagHandler(['dummy', 'dummy two']);
//echo '<pre>';
////print_r( get_declared_classes() );
//print_r( $x);
//
//$x->setFlagOn('dummy');
//print_r( $x);
//$x->setFlagOff('dummy');
//print_r( $x);
//
//$a=$x->isFlagSet('dummy');
//print_r($a ? 'true': 'false');
//
//$a=$x->setFlagOn('dummy');
//print_r($a ? 'true': 'false');
//
//$x->setFlagOn('dummy two');
//$a = $x->isFlagSet('dummy two');
//print_r($a ? 'true': 'false');
//
////print_r($x);
//
//echo '</pre>';
//echo '<BR>';


if (false) {
	require_once ('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationHandler.class.php');
	$auth = new MJMphpLibrary\AuthenticationHandler('TestApp');

	echo '<HR size=2>';

	$auth->showLogin();
	echo '<HR size=2>';

	$auth->showForgotPassword();
	echo '<HR size=2>';

	$auth->showChangePassword();
	echo '<HR size=2>';

	$auth->showSignup();
	echo '<HR size=2>';
}

IF (false) {
	require_once ('P:\Projects\_PHP_Code\MJMphpLibrary\Settings\src\Settings.class.php');
	require_once ('P:\Projects\_PHP_Code\MJMphpLibrary\Settings\src\ASetting.class.php');


	echo '--------hi------------------------<BR>';

	echo Settings::isReady() ? '-y-' : '-n-';
	Settings::init();
	echo Settings::isReady() ? '-y-' : '-n-';

	$value = 4;
	Settings::setValue(Settings::RUNTIME, 'aname', $value);



	$r = Settings::getValue(Settings::RUNTIME, 'aname');
	echo '<pre>';
	print_r($r);
	echo '>>' .$r .'<<';
	echo '</php>';

	//$x = ASetting::DefaultExpireTimeout ;
//	$x = 3;
//	print_r($x);
	$now= new \DateTime('now');
	//$exp = $now + $x;
	$exp = $now->modify("+3 seconds");
	Settings::setValue( Settings::RUNTIME, 'fred', 3.4, null, $exp);

	$r = Settings::getFullSetting(Settings::RUNTIME, 'fred');
	echo '<pre>+++'.PHP_EOL;
	print_r($r);
	echo '[[[' . $r .']]]';

	echo ($r->hasExpired() ? 'Expired' : 'not expired' ) .' '.$r . PHP_EOL;
	sleep (4);
	echo ($r->hasExpired() ? 'Expired' : 'not expired' ) .' '.$r . PHP_EOL;
	sleep(1);
	echo ($r->hasExpired() ? 'Expired' : 'not expired' ). ' '. $r . PHP_EOL;
	sleep(1);
	echo ($r->hasExpired() ? 'Expired' : 'not expired' ). ' '. $r . PHP_EOL;
	//print_r($w1);
	//print_r($w2);
	echo '+++</php>';



	$s = Settings::toString();
	echo '<pre>';
	print_r($s);
	echo '</php>';



	echo $r;
	$r->extendLife( 200);
	echo $r;
	echo '<BR>' . PHP_EOL;

	$r->setProtected(true);
	echo $r;
	$r->extendLife( 200);
	echo $r;
	echo '<BR>' . PHP_EOL;

	$r->setProtected(false);
	$r->setForceExpiry(true);
	echo $r;
	echo '<BR>' . PHP_EOL;

	$r->extendLife( -40);
	echo $r;
	echo '<BR>' . PHP_EOL;

	$now= new \DateTime('now');
	print_r( $now);
	$exp = $now->modify("+2 seconds");
	print_r( $exp);

	echo 'before:' , $r;
	$r->setTimeStamp( $exp);
	echo '%after%%%'.$r;
	sleep( 2);
	echo $r->getValue() ?? ' cant it expired';
	echo '<BR>' . PHP_EOL;

	echo '<BR>--------bye------------------------<BR>';
}

if (false) {

	$x = require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Utils\src\Display_Popups.class.php');

	echo $x ?? false ? '=t=' : '=f=';

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

	$p->javaSriptConfirm('button text', 'popuptext');
	echo '<BR><BR><BR>';
}

if (false) {
	require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpConfigSet.class.php');
	require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\Dump.class.php');

	$configSet = new DumpConfigSet();

//	$u =  0xffffff;
//	$u1 = $u - 0x001100;
//	$u2 = $u1 - 0x001100;
//	dump::dump(  dechex($u), dechex($u1), dechex($u2));


	Dump::Dump(1, 2, 3, 4, 5, 6, 7, 8, 9 ,10,11, 12, 13, 14, 15, 16, $configSet);


	for ($j = 1; $j < 20; $j++) {
		//Dump::Dump($j, $configSet);
		Dump::Dump($j, 1, 2, 3, 4, 5, 6, 7, 8, 9 ,10,11, 12, 13, 14, 15, 16, $configSet);
		$configSet->tabOver();
		echo '<BR> some text <br>';
	}

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

	$a = array(1, 2, 3);
	$b = false;
	$n = 12.13;
	$s = 'hello world';
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

	Dump::Dump(1, 2, 3, 4, 5, 6, 7, 8, 9 ,10,11, 12, 13, 14, 15, 16, $configSet);

	$configSet->reset();
	Dump::Dump([6, 7, 8, 9], $configSet);}




function bob( ) {
	$a= array(1,2,3);
	$b = false;
	$n = 12.13;
	$s = 'hello world';
	Dump::Dump( $a, $b , $s,  $n );


}


if ( false ) {
	require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpClasses.class.php');

	print_r ( get_declared_classes());

	echo '@@@@@@@@@@@@@@@@@@@@@@@@@ dump classes@@@@@@@@@@@@@@';
	//DumpClasses::DumpClasses();
	DumpClasses::DumpClasses();
	echo '@@@@@@@@@@@@@@@@@@@@@@@@@ dump classes@@@@@@@@@@@@@@';
}



if (false) {

	require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\MessageLog\MessageLogBase.trait.php');
	echo '@@@@@@@@@@@@@@@@@@@@@@@@@ dump classes@@@@@@@@@@@@@@';

	echo '<pre>traits';
	print_r( get_declared_traits());
	echo '</pre>';


	class fred {
		use MJMphpLibrary\Dump\MessageLog\MessageLogBaseTrait;


		use MessageLogBaseTrait;
		//use Trait_base_class;

		function __construct(){
			$this->dump();
		}

		function tony($text = 'default'){

			echo '<BR>';echo '<BR>';
			$this->msgLogBegin(' starting function', 3);
			echo 'this is freds tony:'  . $text;
			echo'<BR>';

			$this->msgLogResult(' result in fred', 4,5,6);

			$this->msgLogAssertEquals( $text, 99);
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
	$x->tony( 99);

	echo'^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^<BR>';
	echo'^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^<BR>';

	$x->mask = 0b1111_1111_1111_1111;
	$x->tony(1);



//	$v = $x->Version();
//	echo '******Ver = ', $v, '************';
	#
}


//debugSystem
use MJMphpLibrary\Debug\DebugSystem\DebugSystem as DebugSystem;

include_once ('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\DebugSystem\DebugSystem.class.php');
if (true) {
	echo 'debugsystem starting';

	echo '<pre>';
	print_r( $_REQUEST);
	echo '</pre>';
	DebugSystem::initialize();

	DebugSystem::show();

	DebugSystem::debug('one', 'two', 'three');

	bobby();
}

function bobby() {
	DebugSystem::debug('one', 'two', 'three');

}


echo '<BR>';
echo '<BR>';
echo '<BR>';

//phpinfo();

echo '. all done :-(';