<?php
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


 if ( false) {
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

require_once ('P:\Projects\_PHP_Code\MJMphpLibrary\Settings\src\Settings.class.php');
use MJMphpLibrary\Settings;

echo '--------hi------------------------<BR>';

echo Settings::isReady() ? '-y-' : '-n-';
Settings::init();
echo Settings::isReady() ? '-y-' : '-n-';

$value = 4;
Settings::setValue( Settings::RUNTIME, 'aname', $value);


$r = Settings::getValue( Settings::RUNTIME, 'aname');
echo '<pre>';
print_r( $r);
echo '</php>';

echo '<BR>--------bye------------------------<BR>';



$x = require_once('P:\Projects\_PHP_Code\MJMphpLibrary\Utils\src\Display_Popups.class.php');
use MJMphpLibrary\Utils\Display_Popups;

echo $x?? false ? '=t=' : '=f=';

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
