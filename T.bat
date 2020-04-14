@echo on
cls

p:
cd P:\Projects\_PHP_Code\MJMphpLibrary
rem \FlagHandler


rem
rem Set opt=
rem @if (%1)==(d)
rem set opt= --debug

cmd /c phpunit --verbose --debug -c phpunit.xml

p:
cd P:\Projects\_PHP_Code\MJMphpLibrary