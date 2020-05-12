
/**
 * a message class
 *     - the base has the text and level
 */
class AMessage extends MessageBase {
	protected $text; // the messageText message
	protected $timeStamp;  // time stamp for the message (for displaying the time)
	protected $level; // level of the message (see defines at top)

	protected $codeDetails;   //  usually something like: filename(line num)function/method name

	/**
	 * @var version number
	 */
	private const VERSION = '0.3.0';

	/** -----------------------------------------------------------------------------------------------
	 * construct a message
	 * @param type $text
	 * @param type $timestamp
	 * @param type $level
	 */
	public function __construct($text = null, $timestamp = null, $level = null, ?string $codeDetails = null) {
		$this->setText($text);
		$this->setTimeStamp($timestamp);
		$this->setLevel($level);
		$this->setCodeDetails($codeDetails);
	}

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return type
	 */
	public static function Version() :string {
		return self::VERSION;
	}

	/** -----------------------------------------------------------------------------------------------
	 * converts the message into a string which is formatted [time] level - text
	 * @return type
	 */
	public function __toString() : string {
		return $this->timeStamp . ' (Level: ' . parent::$levels[$this->level] . ') ' . $this->text;
	}

	/** -----------------------------------------------------------------------------------------------
	 * dump the contents of this message
	 * @return void or string
	 */
	public function dump( $returnString = false)  {
		$s =  'msg='. $this->text. ' time='. $this->timeStamp. ' level='. parent::$levels[$this->level] .  '<Br>';

		if ( $returnString){
			return $s;
		} else {
			echo $s ;
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 * set the contents of the message
	 *     -could be just a string or could be an array( string, timestamp, level)
	 * @param type $textOrArray
	 * @param type $timeStamp
	 * @param type $level
	 * @return void
	 */
	public function set($textOrArray = null, $timeStamp = null, $level = null, ?string $codeDetails = null) :void {
		if (!empty($textOrArray) and is_array($textOrArray)) {
			$this->setFromArray($textOrArray);
		} else {
			$this->setFromArray([$textOrArray, $timeStamp, $level, $codeDetails]);
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *  format things
	 * @param type $ar
	 * @return void
	 */
	protected function setFromArray($ar = null): void {
		if (array_key_exists(AR_TEXT, $ar)) {
			$this->setText($ar[AR_TEXT]);
		}
		if (array_key_exists(AR_TimeStamp, $ar)) {
			$this->setTimeStamp($ar[AR_TimeStamp]);
		}
		if (array_key_exists(AR_LEVEL, $ar)) {
			$this->setLevel($ar[AR_LEVEL]);
		}
		if (array_key_exists(AR_CODEDETAILS, $ar)) {
			$this->setCodeDetails($ar[AR_CODEDETAILS]);
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 * set the text of the message
	 * @param type $textString
	 * @return void
	 */
	protected function setText($textString = null): void {
		if (empty($textString)) {
			$this->text = '';
		} else {
			$this->text = $textString;
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 * set the timestamp - it does not have to be a time it can be any string
	 *      - if timestamp it must be formatted properly before getting here
	 * @param string $timeStamp
	 */
	protected function setTimeStamp(string $timeStamp = null) : void {
		if (defined("IS_PHPUNIT_TESTING")) {
			$this->timeStamp = '23:55:30';
			if (empty($timeStamp)) {
				$this->timeStamp = '23:55:30';
			} else {
				$this->timeStamp = $timeStamp;
			}
		} else {
			if (empty($timeStamp)) {
				$this->timeStamp = date('g:i:s'); // current timestamp
			} else {
				$this->timeStamp = $timeStamp;
			}
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 * set the level of the message
	 * @param type $level
	 */
	protected function setLevel($level = null) : void{
		if (empty($level) ) {
			$this->level = AMessage::NOTICE;   //Default
		} else if (array_key_exists($level, parent::$levels)) {
			$this->level = $level;
		} else {
			$this->level = AMessage::NOTICE;   //Default
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string|null $codeDetails
	 * @return void
	 */
	public function setCodeDetails( ?string $codeDetails = null) : void {
		if (empty( $codeDetails)) {
			$this->codeDetails ==null;
		} else {
			$this->codeDetails = $codeDetails;
		}
	}


	/** -----------------------------------------------------------------------------------------------
	 * return the contents of this message in the form of an array
	 *
	 * @return type
	 */
	public function get() : array{
		$a = array($this->text,
			$this->timeStamp,
			$this->level,
			$this->codeDetails
		);
		return $a;
	}

	/** -----------------------------------------------------------------------------------------------
	 * return  appropriate style
	 * @param type $level
	 * @return string
	 */
	protected function getShowStyle($level): string {
		if (array_key_exists($level, parent::$levels)) {
			return 'msg_style_' . parent::$levels[$level];
		} else {
			return 'msg_style_UNKNOWN';
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 * show the appropriate level text
	 * @param type $level
	 * @return string
	 */
	protected function getShowTextLeader($level) : string{
		if (array_key_exists($level, parent::$levels)) {
			return parent::$levels[$level] . ' ';
		} else {
			return 'UNKNOWN ';
		}
	}


	/** -----------------------------------------------------------------------------------------------
	 * return the message all pretty like spans with style
	 * @param type $style
	 * @return string
	 */
	protected function getPrettyLine($style = null) : string {
//dump::dumpA($this,substr_count($this->text, '<BR>'), substr_count($this->text, chr(10)), strlen($this->text )  );

//    $string = $this->text;
//    $resultArr = [];
//    $strLength = strlen($string);
//    for ($i = 0; $i < $strLength; $i++) {
//        $resultArr[$i] = ord($string[$i]);
//    }
//    print_r($resultArr);

		$s = '';
		$textLeader = $this->getShowTextLeader($this->level);

		if (!empty($style)) {
			$lineStyle = $style;
		} else {
			$lineStyle = $this->getShowStyle($this->level);
		}

		/* look for multi line output */
		if ( ( ! is_string($this->text))
				or (substr_count($this->text, '<BR>') > 0)
				or (substr_count($this->text, chr(10)) > 0)
				or (strlen($this->text) > 90)
				or ( substr_count($this->text, ' Object ') > 0 )
				or ( substr_count( $this->text,' Array') > 0)
			) {
			$s .= '<div class="' . $lineStyle . '">';
		} else {
			$s .= '<div class="' . $lineStyle . '" style="display: inline;">';
		}

		if (!empty($this->timeStamp)) {
			$s .= '[' . $this->timeStamp . '] ';
		}
		$s .= $textLeader;

		if ( SETTINGS::getPublic('Show MessageLog Display Mode Short Color')){
			$s .= '</div>';
		}

		$s .= ': ';

		if (is_array($this->text)) {
			$this->text = \print_r($this->text, true);
			$x = str_replace("\n", '<BR>', $this->text);
			$y = str_replace(' ', '&nbsp;', $x);
			$z = str_replace("\t", '&nbsp;&nbsp;&nbsp;', $y);
			$s .= $z;
		} else if ( !empty($this->text) and is_string($this->text) and substr_count(strtolower($this->text), '/table' ) > 0){
			$s .= '<pre>';
			$s .= $this->text;
			$s .= '</pre>';
		} else {
			$x = str_replace("\n", '<BR>', $this->text);
			$y = str_replace(' ', '&nbsp;', $x);
			$z = str_replace("\t", '&nbsp;&nbsp;&nbsp;', $y);
			$s .= $z;
		}

		if ( !empty( $this->codeDetails)){
			$s .= '&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; - &nbsp;  ';
			//$s .= '<span style="text-align: right;">';
			$s .= (!empty( $this->codeDetails) ? $this->codeDetails : '' );
			//$s .= '</span>';
		}

		if ( ! SETTINGS::getPublic('Show MessageLog Display Mode Short Color')){
			$s .= '</div>';
		}

		$s .= '<BR>';
		$s .= PHP_EOL;
		return $s;
	}

	/** -----------------------------------------------------------------------------------------------
	 * show the contents of this message -- with the appropriate formatting etc
	 *
	 * @param type $style
	 */
	public function show($style = null) :void {
		$r= $this->getPrettyLine($style);
		echo $r;
	}

}
