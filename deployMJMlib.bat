rem deployMJMlib.bat


rem example
rem
rem deploymjmlib P:\Projects\_PHP_Code\COW_Apps\CityJETSystem\CityJETSystem_V3.0.5-Dev_On_App5
rem

set DEST=%1
if (%1)== 90 goto endIt


mkdir %DEST%\MJMphpLibrary

mkdir %DEST%\MJMphpLibrary\Utils
copy P:\Projects\_PHP_Code\MJMphpLibrary\Utils\src\*.php %DEST%\MJMphpLibrary\Utils


mkdir %DEST%\MJMphpLibrary\AuthenticationHandler
copy P:\Projects\_PHP_Code\MJMphpLibrary\AuthenticationHandler\src\*.php %DEST%\MJMphpLibrary\AuthenticationHandler

mkdir %DEST%\MJMphpLibrary\Encryption
copy P:\Projects\_PHP_Code\MJMphpLibrary\encryption\src\*.php %DEST%\MJMphpLibrary\Encryption

mkdir %DEST%\MJMphpLibrary\FlagHandler
copy P:\Projects\_PHP_Code\MJMphpLibrary\FlagHandler\src\*.php %DEST%\MJMphpLibrary\FlagHandler

mkdir %DEST%\MJMphpLibrary\HTML
copy P:\Projects\_PHP_Code\MJMphpLibrary\HTML\Src\*.php %DEST%\MJMphpLibrary\HTML


mkdir %DEST%\MJMphpLibrary\Menus
copy P:\Projects\_PHP_Code\Menus\src\*.php %DEST%\MJMphpLibrary\Menus


mkdir %DEST%\MJMphpLibrary\Settings
copy P:\Projects\_PHP_Code\MJMphpLibrary\settings\src\*.php %DEST%\MJMphpLibrary\Settings


mkdir %DEST%\MJMphpLibrary\Debug
mkdir %DEST%\MJMphpLibrary\Debug\DebugSystem
copy P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\DebugSystem\*.php %DEST%\MJMphpLibrary\DebugSystem

mkdir %DEST%\MJMphpLibrary\Debug\Dump
copy P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\*.php %DEST%\MJMphpLibrary\Dump

mkdir %DEST%\MJMphpLibrary\Debug\ErrorHandler
copy P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\ErrorHandler\*.php %DEST%\MJMphpLibrary\ErrorHandler

mkdir %DEST%\MJMphpLibrary\Debug\History
copy P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\DebugHistory\*.php %DEST%\MJMphpLibrary\DebugHistory

mkdir %DEST%\MJMphpLibrary\Debug\MessageLog
copy P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\MessageLog\*.php %DEST%\MJMphpLibrary\MessageLog

mkdir %DEST%\MJMphpLibrary\Debug\MonoLogExtention
copy P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\MonoLogExtention\*.php %DEST%\MJMphpLibrary\MonoLogExtention

mkdir %DEST%\MJMphpLibrary\Debug\NullAbsorber
copy P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\NullAbsorber\*.php %DEST%\MJMphpLibrary\NullAbsorber










:endIt