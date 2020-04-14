<?php

//echo __DIR__;
//$ff = __DIR__ . '\FlagHandler\src\FlagHandler.class.php';
echo '<BR>';

//echo $ff;
//echo '<BR>';

//echo realpath('.');
//echo '<BR>';

//include_once($ff);
echo __DIR__;
echo '<BR>';

echo __DIR__ . '\FlagHandler\src\FlagHandler.class.php';
echo '<BR>';

include_once(__DIR__ . '\FlagHandler\src\FlagHandler.class.php');
//D:\Projects\_PHP_Code\MJMphpLibrary\FlagHandler\src\FlagHandler.class.php
echo '<BR>';

echo '<pre>';
print_r( get_declared_classes() );
echo '</pre>';
echo '<BR>';

$x = new MJMphpLibrary\FlagHandler(['dummy']);

$y = $x->Version();
echo 'Version=' . $y;
