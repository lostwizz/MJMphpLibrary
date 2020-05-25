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
		echo '<pre>   >>';

		print_r($bt);
		echo '<<  </pre>';

		$prettyBT = self::beautifyBackTrace($bt);
		$argsObjects = self::setupVars($args);

		self::showVars($argsObjects, $prettyBT);


//	print_r($args);
//	echo '------------------<BR>' .  PHP_EOL;
//	print_r( self::$CurrentConfigSet);
	}

	public static function setupConfig(array &$args) {
		//foreach( $args as $i){
		for ($i = 0; $i < count($args); $i++) {
			if ($args[$i] instanceof \MJMphpLibrary\Debug\Dump\DumpConfigSet) {
				self::$CurrentConfigSet = $args[$i];
				//echo 'FFREDD';
				unset($args[$i]);
				return;
			}
		}
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



	public static function beautifyBackTrace( $bt) : string {
		$out = '<pre id="Backtrace_' . self::$dumpCount++ .'"';
		$out .= ' style="color: ' . self::$CurrentConfigSet->Beautify_Text_Color . '">';

		foreach( $bt as $btRow){
			$out .= self::beautifyBTRow( $btRow);
		}
		///$out .= self::beautifyBTRow( $bt[1]);
		$out .= '</pre>';
		return $out;
	}

	public static function beautifyBTRow($btRow) : string {
		$out  = '';
		if( !empty( $btRow['file'])) {
			$out .= $btRow['file'];
			$out .= ': ' . $btRow['line'];
			$out .= ' (' . $btRow['function'] . ')';
		}
		$out .= PHP_EOL;
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

	public static function showVars($stringifiedArgs, $prettyBT) {
		echo self::showPreArgs();
		echo self::showMiddleArgs( $stringifiedArgs);
		echo self::showPostArgs($prettyBT);
	}

	public static function showPreArgs(): string {
		$out = '<div'
			. ' id=DumpArea_'				. self::$dumpCount++
			. ' style="background-color: '	. self::$CurrentConfigSet->Beautify_BackgroundColor	. ';'
			. ' border-style: '				. self::$CurrentConfigSet->Beautify_Border_style	. ';'
			. ' border-width: '				. self::$CurrentConfigSet->Beautify_Border_width	. ';'
			. ' border-color: '				. self::$CurrentConfigSet->Area_Border_Color		. ';'
			. ' overflow: '					. self::$CurrentConfigSet->Beautify_Overflow		. ';'
			. ' padding-bottom: '			. self::$CurrentConfigSet->Beautify_Margin_bottom	. ';'
			. ' margin-bottom: '			. self::$CurrentConfigSet->Beautify_Padding_bottom	. ';'
			. ' width: '					. self::$CurrentConfigSet->Beautify_PreWidth		. ';'
			;
		//if ( ! self::$CurrentConfigSet->skipNumLines){
		//	$r .= ' height: '				. self::$CurrentConfigSet->FLAT_WINDOWS_LINES . 'em;';
		//}

		$out .= '">'. PHP_EOL;

		return $out;
	}

	public static function showPostArgs($prettyBT) : string{
		if (  self::$CurrentConfigSet->Show_BackTrace_Num_Lines >0 ){
			$out = $prettyBT;
		} else {
			$out = '';
		}
		$out .=  '</div>' . PHP_EOL;
		return $out;
	}

	public static function showMiddleArgs( $args) : string {
		$out ='';
		foreach( $args as $a){
			$out .= $a . '<BR/>'. PHP_EOL;
		}
		return $out;
	}




}
