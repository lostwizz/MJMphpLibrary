<?php

echo __DIR__;
$ff = __DIR__ . '\FlagHandler\FlagHandler.class.php';
echo '<BR>';

echo $ff;
echo '<BR>';

echo realpath('.');
echo '<BR>';

include_once($ff);

$x = new FlagHandler();

$y = $x->Version();
echo 'Version=' . $y;
