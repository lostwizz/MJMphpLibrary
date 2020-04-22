@echo off
cls

p:
cd P:\Projects\_PHP_Code\MJMphpLibrary

rem
rem Set opt=
rem @if (%1)==(d)
rem set opt= --debug
rem --testdox

cmd /c phpunit --debug --verbose -c phpunit.xml


p:
cd P:\Projects\_PHP_Code\MJMphpLibrary