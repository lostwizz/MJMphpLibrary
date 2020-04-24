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



require_once ('P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\AuthenticationHandler.class.php');
$auth = new MJMphpLibrary\AuthenticationHandler('TestApp');
$auth->showLogin();


