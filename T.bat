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

set TESTSUITE=

rem set TESTSUITE=FlagHandler
rem set TESTSUITE=AuthenticationHandler
rem set TESTSUITE=Utils
rem set TESTSUITE=Settings
rem set TESTSUITE=Encryption
rem set TESTSUITE=HTML
rem set TESTSUITE=Menus
rem set TESTSUITE=Debug_MessageLog

set TESTSUITE=Debug_Dump

rem set TESTSUITE=Debug_History
rem -------------------------set TESTSUITE=Debug_ErrorHandler
rem set TESTSUITE=Debug_DebugSystem
rem set TESTSUITE=Debug_NullAbsorber
rem set TESTSUITE=autoload
rem set TESTSUITE=Wild_card_all_tests


rem  @echo on
if (%TESTSUITE%)==() goto  AllSuites
	@echo on
	cmd /c phpunit --debug --verbose   -c phpunit.xml --testsuite %TESTSUITE%
	@echo off

   goto afterTest


:AllSuites
	@echo on
   cmd /c phpunit --debug --verbose   -c phpunit.xml
   @echo off
   goto afterTest

:afterTest
p:
cd P:\Projects\_PHP_Code\MJMphpLibrary