<?php
declare(strict_types=1);

/** * ********************************************************************************************
 * dump.class.php
 *
 * Summary maintains 3 queues (Pre/Dispatcher/Post) and executes thing in the queues.  These classes should not depend on anything else
 *
 *
 *
 * @author mike.merrett@whitehorse.ca
 * @version 0.4.1
 * $Id: 78e8b42cf06dbbe1222406a4bf8b3140b2a407ae $
 *
 * Description.
 * maintains 3 queues and then executes them in order -- and checks the response of the execution
 *    and may abort or continue on processing.
 *
 *
 *
 * @package ModelViewController - Dispatcher
 * @subpackage Dispatcher
 * @since 0.4.0
 *
 * @example
 *        use \php_base\Utils\Dump\Dump as Dump;
 *        useage: Dump::dump($fred);
 *
 * Dump::dump('hello world', 'the world');
 *
 * Dump::dump('!!!!!!!!!!!!! at TestController', 'now at', array('Show BackTrace Num Lines' => 5,'Beautify_BackgroundColor' => '#FFAA55') );
 *
 * dump::Dump('array("1"=>4)',null,array('Show BackTrace Num Lines' => 5,'Beautify_BackgroundColor' => '#FFAA55') );
 *
 * @todo Description
 *
 */
//**********************************************************************************************
//https://docs.phpdoc.org/references/phpdoc/tags/index.html


namespace MJMphpLibrary\Debug;

//namespace MJMphpLibrary\Debug\Dump;

use MJMphpLibrary\Debug\Dump\DumpConfigSet;


include_once('P:\Projects\_PHP_Code\MJMphpLibrary\Debug\src\Dump\DumpConfigSet.class.php');

//***********************************************************************************************************
//***********************************************************************************************************
/* * ******************************************************************************
 *  Dump
 *     - a utility to output a vaiable - and the line it was called from (usefull for tracing
 */
abstract class Dump {

	protected static $CurrentConfigSet = null;
	protected static $dumpCount =1;


	/**
	 * @var version string
	 */
	private const VERSION = '0.0.1';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}







	public static function doDump(...$args) {
		echo 'hi';
		self::setupConfig($args);

		$bt = debug_backtrace( DEBUG_BACKTRACE_PROVIDE_OBJECT, self::$CurrentConfigSet->Show_BackTrace_Num_Lines +1);
//echo '<pre>   >>';
//print_r($bt);
//echo '<<  </pre>';

		$fileLine = self::getCodeLine($bt);

		$argsObjects = self::setupVars($args);

		self::showVars($argsObjects, $bt, $fileLine);


//print_r($args);
//echo '------------------<BR>' .  PHP_EOL;
//print_r( self::$CurrentConfigSet);
	}

	public static function setupConfig(array &$args) {
		for ($i = 0; $i < count($args); $i++) {
			if ($args[$i] instanceof DumpConfigSet) {
				self::$CurrentConfigSet = $args[$i];
				unset($args[$i]);
				return;
			}
		}
		// give it the default
		self::$CurrentConfigSet = new DumpConfigSet();
	}

	public static function getCodeLine($bt, $which=0) {
		return self::getFileLines(
				$bt[$which]['file'],
				$bt[$which]['line'],
				self::$CurrentConfigSet->PRE_CodeLines,
				self::$CurrentConfigSet->POST_CodeLines
				);
	}

	public static function getFileLines( string $fileName, int $lineNum, int $precedingLines = 0, int $followingLines = 0) : string {
		$lines = file($fileName);
		$out = '';

		for ( $i =$lineNum - $precedingLines -1; ($i< $lineNum-1) ; $i++) {
			$out .= $lines[$i] ;
		}
		$out .= $lines[ $lineNum -1];

		for ( $i  = $lineNum;	$i < ($lineNum + $followingLines);	$i++) {
				$out .= $lines[$i];
		}
		return $out;
	}




	public static function beautifyBTRow($btRow) : string {
		$out  = '<font style="'
				. 'color: ' . self::$CurrentConfigSet->Beautify_Title_Color . '; '
				. 'background-color: ' . self::$CurrentConfigSet->Beautify_Var_Name_BackgroundColor . '; '
				. 'font-size: ' . self::$CurrentConfigSet->Beautify_Var_Name_Font_size . '; '
				. '">';

		if( !empty( $btRow['file'])) {
			$out .= $btRow['file'];
			$out .= ': ' . $btRow['line'];
			$out .= ' (' . $btRow['function'] . ')';
		}
		$out .= ' </font>' .PHP_EOL;
		return $out;
	}



	public static function setupVars(array $args): array {
		$r = [];
		foreach ($args as $a) {
			$r[] = self::makeBeauitiful($a);
		}
		return $r;
	}

	public static function makeBeauitiful($obj): string {
		switch (gettype($obj)) {
			case 'NULL':
				$r = '-null-';
				break;
			case 'boolean':
				$r = $obj ? '-t-' : '-f-';
				break;
			case 'integer':
				$r = strval($obj);
				break;
			case 'double':
			case 'float':
				$r = strval($obj);
				break;
			case 'string':
				$r = $obj;
				break;
			case 'array':
			case 'object':
			case 'resource':
			case 'resource (closed)':
			case 'unknown type':
			default:
				$r = print_r($obj, true);
				break;
		}
		return $r;
	}

	public static function showVars( array $stringifiedArgs, array $bt, string $fileLine) {
		echo self::$CurrentConfigSet->giveOverallDiv( self::$dumpCount++);

		echo self::$CurrentConfigSet->giveTitleSpan( self::$dumpCount++);
		echo self::giveTitle( $fileLine);
		echo self::$CurrentConfigSet->giveTitleAfterSpan();

		echo self::$CurrentConfigSet->giveVarPre(self::$dumpCount++);
		echo self::giveVarOutput($stringifiedArgs);
		echo self::$CurrentConfigSet->giveVarAfterPre();

		echo self::$CurrentConfigSet->giveLineInfoDiv( self::$dumpCount++);
		echo self::giveServerFileLineInfo($bt);
		echo self::$CurrentConfigSet->giveLineInfoAfterDiv();

		echo self::$CurrentConfigSet->giveOverallAfterDiv();
	}





	public static function giveTitle( $line) : string {
		$s = 'Dump::doDump(';
		$ll = strlen($s)  ;
		$ln = trim($line);

		if ( strncmp($ln, $s,$ll) ===0) {
			$ln = substr($ln, $ll, strlen($ln));
		}
		if ( substr($ln,-2) == ');'){
			$ln  = substr($ln, 0, strlen($ln)-2);
		}

//		$ln .= '>>>>>>>>>>>'. $line;
		return  $ln . PHP_EOL;
	}




	public static function giveVarOutput($stringifiedArgs) :string {
		$out ='';
		$out .= '<hr size=1>';
		foreach( $stringifiedArgs as $i){
			$out .= $i;
			$out .= '<hr size=1>';
			//$out .= PHP_EOL;
		}
		return $out;
	}


	public static function giveServerFileLineInfo($bt) : string{
		$out = '';
		$out .= self::$CurrentConfigSet->giveLineInfoSubSpanServerAndPathLines( self::$dumpCount++);
		//echo 'server and path';
		$out .= self::giveServerAndPathInfo($bt);
		$out .= self::$CurrentConfigSet->giveLineInfoSubSpanAfterServerAndPathLines();

		$out .= self::$CurrentConfigSet->giveLineInfoSubSpanFileAndLine( self::$dumpCount++);
		//cho 'file and line num';
		$out .= self::giveFileAndLine( $bt);
		$out .= self::$CurrentConfigSet->giveLineInfoSubSpanAfterFileAndLine();
		return $out;
	}

	public static function giveServerAndPathInfo($bt) :string {
		$out = empty($_SERVER['SERVER_NAME']) ? 'unknown' : $_SERVER['SERVER_NAME'];
		$out .= '&nbsp; - &nbsp;';
		$path_parts = pathinfo($bt[0]['file']);

		$out .= $path_parts['dirname'] . '\\';
		return $out;
	}


	public static function giveFileAndLine($bt) : string {
		$out = basename($bt[0]['file']);
		$out .= '&nbsp;(';
		$out .= $bt[0]['line'];
		$out .= ')';
		return $out;
	}


}
