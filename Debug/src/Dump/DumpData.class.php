<?php
 declare(strict_types=1);


class DumpData {

	public $backTrace;
	public $variableName;
	public $fileName;
	public $lineNum;
	public $codeLine;
	public $serverName;
	public $title;
	public $variable;
	public $preCodeLines = array();
	public $postCodeLines = array();


	/**
	 * @var version number
	 */
	private const VERSION = '0.0.1';

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
	 * @return array
	 */
	public function ToArray(): array {
		return array('backTrace' => $this->backTrace,
			'variableName' => $this->variableName,
			'fileName' => $this->fileName,
			'lineNum' => $this->lineNum,
			'codeLine' => $this->codeLine,
			'serverName' => $this->serverName,
			'title' => $this->title,
			'variable' => $this->variable,
			'preCodeLines' => $this->preCodeLines,
			'postCodeLines' => $this->postCodeLines,
		);
	}

}
