<?php

declare(strict_types=1);

namespace MJMphpLibrary;

define('MyLibDIR', realpath('.'));
//echo '=========', MyLibDIR;
//echo '<BR>';


//include_once( MyLibDIR . '\autoload.php');

$loader = new Psr4AutoloaderClass();

$loader->register();
//$loader->isDebugging = true;




$loader->addNamespace('MJMphpLibrary\AuthenticationHandler', MyLibDIR . '/AuthenticationHandler/src');
$loader->addNamespace('MJMphpLibrary\Encryption', MyLibDIR . '/Encryption/src');
$loader->addNamespace('MJMphpLibrary\FlagHandler', MyLibDIR . '/FlagHandler/src');
$loader->addNamespace('MJMphpLibrary\Settings', MyLibDIR . '/Settings/src');
$loader->addNamespace('MJMphpLibrary\Utils', MyLibDIR . '/Utils/src');
$loader->addNamespace('MJMphpLibrary\HTML', MyLibDIR . '/HTML/src');
$loader->addNamespace('MJMphpLibrary\MenuHandler', MyLibDIR . '/Menus/src');
$loader->addNamespace('MJMphpLibrary\Debug', MyLibDIR . '/Debug/src');
$loader->addNamespace('MJMphpLibrary\Debug\DebugSystem', MyLibDIR . '/Debug/src/DebugSystem');
$loader->addNamespace('MJMphpLibrary\Debug\Dump', MyLibDIR . '/Debug/src/Dump');
$loader->addNamespace('MJMphpLibrary\Debug\ErrorHandler', MyLibDIR . '/Debug/src/ErrorHandler');
$loader->addNamespace('MJMphpLibrary\Debug\History', MyLibDIR . '/Debug/src/History');
$loader->addNamespace('MJMphpLibrary\Debug\MessageLog', MyLibDIR . '/Debug/src/MessageLog');
$loader->addNamespace('MJMphpLibrary\Debug\NullAbsorber', MyLibDIR . '/Debug/src/NullAbsorber');


if (defined("IS_PHPUNIT_TESTING")) {
	$loader->addNamespace('MJMphpLibrary\AuthenticationHandler', MyLibDIR . '/AuthenticationHandler/TESTS');
	$loader->addNamespace('MJMphpLibrary\Encryption', MyLibDIR . '/Encryption/TESTS');
	$loader->addNamespace('MJMphpLibrary\FlagHandler', MyLibDIR . '/FlagHandler/TESTS');
	$loader->addNamespace('MJMphpLibrary\Settings', MyLibDIR . '/Settings/TESTS');
	$loader->addNamespace('MJMphpLibrary\HTML', MyLibDIR . '/HTML/TESTS');
	$loader->addNamespace('MJMphpLibrary\MenuHandler', MyLibDIR . '/Menus/TESTS');
	$loader->addNamespace('MJMphpLibrary\Utils', MyLibDIR . '/Utils/TESTS');
	$loader->addNamespace('MJMphpLibrary\Debug', MyLibDIR . '/Debug/TESTS');
	$loader->addNamespace('MJMphpLibrary\Debug\DebugSystem', MyLibDIR . '/Debug/TESTS/DebugSystem');
	$loader->addNamespace('MJMphpLibrary\Debug\Dump', MyLibDIR . '/Debug/TESTS/Dump');
	$loader->addNamespace('MJMphpLibrary\Debug\ErrorHandler', MyLibDIR . '/Debug/TESTS/ErrorHandler');
	$loader->addNamespace('MJMphpLibrary\Debug\History', MyLibDIR . '/Debug/TESTS/History');
	$loader->addNamespace('MJMphpLibrary\Debug\MessageLog', MyLibDIR . '/Debug/TESTS/MessageLog');
	$loader->addNamespace('MJMphpLibrary\Debug\NullAbsorber', MyLibDIR . '/Debug/TESTS/NullAbsorber');
}

/** * ***************************************************************************
 * An example of a general-purpose implementation that includes the optional
 * functionality of allowing multiple base directories for a single namespace
 * prefix.
 *
 * Given a foo-bar package of classes in the file system at the following
 * paths ...
 *
 *     /path/to/packages/foo-bar/
 *         src/
 *             Baz.php             # Foo\Bar\Baz
 *             Qux/
 *                 Quux.php        # Foo\Bar\Qux\Quux
 *         tests/
 *             BazTest.php         # Foo\Bar\BazTest
 *             Qux/
 *                 QuuxTest.php    # Foo\Bar\Qux\QuuxTest
 *
 * ... add the path to the class files for the \Foo\Bar\ namespace prefix
 * as follows:
 *
 *      <?php
 *      // instantiate the loader
 *      $loader = new \Example\Psr4AutoloaderClass;
 *
 *      // register the autoloader
 *      $loader->register();
 *
 *      // register the base directories for the namespace prefix
 *      $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/src');
 *      $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/tests');
 *
 * The following line would cause the autoloader to attempt to load the
 * \Foo\Bar\Qux\Quux class from /path/to/packages/foo-bar/src/Qux/Quux.php:
 *
 *      <?php
 *      new \Foo\Bar\Qux\Quux;
 *
 * The following line would cause the autoloader to attempt to load the
 * \Foo\Bar\Qux\QuuxTest class from /path/to/packages/foo-bar/tests/Qux/QuuxTest.php:
 *
 *      <?php
 *      new \Foo\Bar\Qux\QuuxTest;
 */
class Psr4AutoloaderClass {

	/**
	 * An associative array where the key is a namespace prefix and the value
	 * is an array of base directories for classes in that namespace.
	 *
	 * @var array
	 */
	protected $prefixes = array();

	/**
	 * Array of suffixes to append the file name with == could also do _test.class.php
	 * @var array
	 */
	protected $suffixes = [
		'.class.php',
		'.php',
		'.trait.php',
			//	'_Test.class.php'
	];   // the order can be important

	/**
	 * if true then show the class and files it is looking for
	 * 		- helps when you are not sure why the class file is not loading
	 * 		- default is false and will not show anything
	 *
	 * @var bool
	 */
	public bool $isDebugging = false;

	/**
	 * Register loader with SPL autoloader stack.
	 *
	 * @return void
	 */
	public function register(): void {
		spl_autoload_register(array($this, 'loadClass'));
	}

	/**
	 * Adds a base directory for a namespace prefix.
	 *
	 * @param string $prefix The namespace prefix.
	 * @param string $base_dir A base directory for class files in the
	 * namespace.
	 * @param bool $prepend If true, prepend the base directory to the stack
	 * instead of appending it; this causes it to be searched first rather
	 * than last.
	 * @return void
	 */
	public function addNamespace($prefix, $base_dir, $prepend = false): void {
		// normalize namespace prefix
		$prefix = trim($prefix, '\\') . '\\';

		// normalize the base directory with a trailing separator
		$base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';

		// initialize the namespace prefix array
		if (isset($this->prefixes[$prefix]) === false) {
			$this->prefixes[$prefix] = array();
		}

		// retain the base directory for the namespace prefix
		if ($prepend) {
			array_unshift($this->prefixes[$prefix], $base_dir);
		} else {
			array_push($this->prefixes[$prefix], $base_dir);
		}
	}

	/**
	 * this is for a list of suffixes that it will use to search for the file
	 * 		i.e. ".php" or ".class.php" or ".trait.php" (these are also the defaults )
	 * 	- mainly so you don't have to worry about if it is a class file or just a regular one
	 *
	 * @param type $suffix
	 */
	public function addSuffix($suffix): void {
		$this->suffixes[] = $suffix;
	}

	/**
	 * Loads the class file for a given class name.
	 *
	 * @param string $class The fully-qualified class name.
	 * @return mixed The mapped file name on success, or boolean false on
	 * failure.
	 */
	public function loadClass($class) {
		if ($this->isDebugging) {
			echo '<span style="color: red;"> loadClass($class): ', $class, '</span>';
		}

		// the current namespace prefix
		$prefix = $class;

		// work backwards through the namespace names of the fully-qualified
		// class name to find a mapped file name
		while (false !== $pos = strrpos($prefix, '\\')) {

			// retain the trailing namespace separator in the prefix
			$prefix = substr($class, 0, $pos + 1);

			// the rest is the relative class name
			$relative_class = substr($class, $pos + 1);

			// try to load a mapped file for the prefix and relative class
			$mapped_file = $this->loadMappedFile($prefix, $relative_class);
			if ($mapped_file) {
				return $mapped_file;
			}

			// remove the trailing namespace separator for the next iteration
			// of strrpos()
			$prefix = rtrim($prefix, '\\');
		}

		// never found a mapped file
		return false;
	}

	/**
	 * Load the mapped file for a namespace prefix and relative class.
	 *
	 * @param string $prefix The namespace prefix.
	 * @param string $relative_class The relative class name.
	 * @return mixed Boolean false if no mapped file can be loaded, or the
	 * name of the mapped file that was loaded.
	 */
	protected function loadMappedFile($prefix, $relative_class) {

		// are there any base directories for this namespace prefix?
		if (isset($this->prefixes[$prefix]) === false) {
			return false;
		}
		// look through base directories for this namespace prefix
		foreach ($this->prefixes[$prefix] as $base_dir) {

			foreach ($this->suffixes as $aSuffix) {

				// replace the namespace prefix with the base directory,
				// replace namespace separators with directory separators
				// in the relative class name, append with .php
				$file = $base_dir
						. str_replace('\\', '/', $relative_class)
						. $aSuffix;

				// if the mapped file exists, require it
				if ($this->requireFile($file)) {
					// yes, we're done
					return $file;
				}
			}
		}

		// never found it
		return false;
	}

	/**
	 * If a file exists, require it from the file system.
	 *
	 * @param string $file The file to require.
	 * @return bool True if the file exists, false if not.
	 */
	protected function requireFile($file): bool {
		if ($this->isDebugging) {
			echo '<BR><span style="color: DarkCyan;"> looking for file: ', $file;
		}

		if (file_exists($file)) {
			//require $file;
			require_once $file;
			if ($this->isDebugging) {
				echo '-found </span><br>';
			}
			return true;
		}
		if ($this->isDebugging) {
			echo '-not found</span>';
		}
		return false;
	}

}
