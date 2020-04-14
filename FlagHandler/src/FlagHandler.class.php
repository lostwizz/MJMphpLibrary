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
		$this->listOfFlags = $initialListOfFlags;
		if ($initialValue >= 0) {
			$this->value = $initialValue;
		} else {
			$this->value = 0;
		}
	}

	public function getIntValue(): int {
		return $this->value;
	}

	public function setValueToInt(int $val): void {
		$this->value = $val;
	}

	public function setFlagOn(string $whichFlag): void {

	}

	public function setFlagOff(string $whichFlag): void {

	}

	public function getFlagOnOff(string $whichFlag): bool {

	}

}
