@echo off
cls

p:
cd P:\Projects\_PHP_Code\MJMphpLibrary

rem ------------------------- P:\Projects\_PHP_Code\MJMphpLibrary\vendor\bin
rem - to install phpunit use
rem   composer require --dev phpunit/phpunit ^9.5 --with-all-dependencies
rem
rem goggle how to install composer

rem
rem Set opt=
rem @if (%1)==(d)
rem set opt= --debug
rem --testdox

cmd /c phpunit --debug --verbose   -c phpunit.xml


p:
cd P:\Projects\_PHP_Code\MJMphpLibrary