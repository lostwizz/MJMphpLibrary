<?php

namespace MJMphpLibrary;

class FlagHandler {

	/**
	 *
	 * @var int  the value of the flags
	 */
	protected $value;

	/**
	 *
	 * @var array string - an array of the the names of the flags
	 */
	protected $listOfFlags;

	/**
	 * @var version string
	 */
	private const VERSION = '0.1.0';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}

	function __construct(array $initialListOfFlags, int $initialValue = 0) {
		$this->listOfFlags = $this->convetToLowerCaseValues($initialListOfFlags);
		if ($initialValue >= 0) {
			$this->value = $initialValue;
		} else {
			$this->value = 0;
		}
	}

	private function convetToLowerCaseValues( $orig ): array {
		$ar =[];
		foreach($orig as $i){
			$ar[] = strtolower($i);
		}
		return $ar;
	}

	public function getListOfFlags() : array{
		return $this->listOfFlags;
	}

	public function getIntValue(): int {
		return $this->value;
	}

	public function setValueToInt(int $val): void {
		$this->value = $val;
	}

	public function setFlagOn(string $whichFlag): void {
		$pos = array_search( strtolower($whichFlag), $this->listOfFlags);
		if ( $pos !== false ){
			$x = $this->value | (2 ** $pos);
			$this->value = $x;
		}
	}

	public function setFlagOff(string $whichFlag): void {
		$pos = array_search( strtolower($whichFlag), $this->listOfFlags);
		if ( $pos !== false ){
			$x = $this->value & (~((2 ** $pos)));
			$this->value = $x;
		}
	}

	public function isFlagSet(string $whichFlag): bool {
		$pos = array_search( strtolower($whichFlag), $this->listOfFlags);
		if ( $pos !== false ){
			//echo '>', (2 ** $pos) ,'<';
			$r = $this->value & (2 ** $pos);
			//echo '[', $r, ']';
			return ( $r >0);
		}
		return false;
	}

}
