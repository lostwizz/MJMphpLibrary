<?php
  declare(strict_types=1);
/**
 *
 */
abstract class BackTraceProcessor {

	/**
	 * @var version number
	 */
	private const VERSION = '0.3.0';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return type
	 */
	public static function Version() {
		return self::VERSION;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $bt
	 * @return type
	 */
	public static function ProcessBackTrace($bt) {
		$output = '';
		foreach ($bt as $btFunc) {
			$output .= self::ProcessBTFunc($btFunc);
		}
		return $output;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $bt
	 * @return type
	 */
	public static function ExtractCallingLine($bt) {
		$fn = $bt[0]['file'];
		$lineNum = $bt[0]['line'];
		return array($fn, $lineNum);
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $fn
	 * @param type $lineNum
	 * @return type
	 */
	public static function ExtractCodeLine($fn, int $lineNum) {
		$lines = file($fn);
		return $lines[$lineNum - 1];   //zero based lines
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $fn
	 * @param type $lineNum
	 * @param type $preLines
	 * @return type
	 */
	public static function ExtractPreLines($fn, int $lineNum, int $preLines) {
		$lines = file($fn);
		$r = array();
		for ($i = ($lineNum - $preLines - 1); $i < ($lineNum - 1); $i++) {
			if (!empty($lines[$i])) {
				$r[$i] = $lines[$i];
			}
		}
		return $r;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $fn
	 * @param type $lineNum
	 * @param type $postLines
	 * @return type
	 */
	public static function ExtractPostLines($fn, int $lineNum, int $postLines) {
		//echo 'X=', 		$lineNum + $postLines+1,' - ' ,$postLines , '<br>';
		return SELF::ExtractPreLines($fn, $lineNum + $postLines + 1, $postLines);
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $btFunc
	 * @return string
	 */
	protected static function ProcessBTFunc($btFunc) {
		// $btFunc['function'] != 'dump') {   // dont dump the dump
		$output = '';
		if (!empty($btFunc['file'])) {
			$output .= $btFunc['file'];
			$output .= ':' . $btFunc['line'];
			$output .= '(' . $btFunc['function'] . ')';
		}
		$args = array();

		//if ( false) {   /** simplify the backtrace by ignoring the "Arguments" and/or variables */
		//	foreach ($btFunc['args'] as $anArg) {
		//		$args[] = self::ProcessBTArgs($anArg);
		//	}
		//	$output .= implode(', ', $args);
		//}

		$output .= "\n";
		return $output;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $anArg
	 * @return string
	 */
	protected static function ProcessBTArgs($anArg): string {
		switch (gettype($anArg)) {
			case "boolean":
				$output = ($anArg) ? '-True-' : '-False-';
				break;
			case "integer":
			case "double":
				$output = (string) $anArg;
				break;
			case "string":
				$output = $anArg;
				break;
			case "array":
			case "object":
			case "resource":
			case "resource (closed)":
				$output = print_r($anArg, true);
				//$output = serialize( $anArg);
				break;
			case "NULL":
				$output = '-Null-';
			case "unknown type":
			default:
				$output = '-Unknown-';
				break;
		}
		return $output;
	}

}

