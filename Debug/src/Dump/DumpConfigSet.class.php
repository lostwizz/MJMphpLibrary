<?php
declare(strict_types=1);

namespace MJMphpLibrary\Debug\Dump;


Class DumpConfigSet {
	/**
	 * @var version number
	 */
	private const VERSION = '0.0.2';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return type
	 */
	public static function Version() {
		return self::VERSION;
	}


	/*
	 * a color changing switch  - not somuch indenting but changing the color
	 */
	public static int $currentIndentLevel =0;

	/*
	 * the array with
	 */
	//protected $originalConfigArray = null;

	/*
	 * list of the different presets
	 */
	const LISTOFPRESETS = ['DumpClasses'];

	protected $currentSet = array(
		'FLAT_WINDOWS_LINES' => 7, //  big a output block can be before adding scrollbars
		'PRE_CodeLines' => 0, // show the number of lines before the call
		'POST_CodeLines' => 0, // show the number of lines after the call
//		'Show_BackTrace_Num_Lines' => 1, // show the backtrace calls (how many lines in the history
//		'Only_Return_Output_String' => false, // dont print/echo anything just return a string with it all
//		'skipNumLines' => false,
//		'Area_Border_Color' => '#950095',
//		'is_On' => true, // make the output look pretty

		'OverallText_Color' => '#0000FF',
		'OverallBackgroundColor' => '#FFFDCC', //'#E3FCFD',		// set the background color
		'OverallHeight' => '0px;',  // '7em',
		'OverallWidth' => '95%',
		'OverallPadding_bottom' => '0px',
		'OverallMargin' => '0px 50px 0px 50px',
		'OverallOverflow' => 'auto',
		'OverallBorder_style' => 'dashed',
		'OverallBorder_width' => '1px',
		'OverallArea_Border_Color' => '#950095',
		'OverallBorder_radius' => '5px',

		'TitleColor' => 'green',
		'TitleBackgroundColor' => '#7DEEA2',
		'TitleFontWeight' => '100',

		'HRseparatorSize' => '1',
		'HRseparatorPadding' =>'0px',
		'HRseparatorMargin' => '0px',

		'PreAreaBackGround' => '#ADFF2F', //#7DEEA2',
		//'preAreaBorderColor' => '#950095',
		//'preAreaTextColor' => '#0000FF',
		'preAreaFontWeight' => '400',
		'preAreaBorderStyle' => 'none',
		'preAreaMargin' => '0px',

		'PreAreaBackGround' => '#C7BFB8',
		///'PreAreaBackGround' => '#B7B7B7',

		'Var_Name_Font_size' => 'large',
		//'Var_Text_Color' => '#950095',
		'Var_Font_weight' => '300',
		'Var_Data_Font_size' => 'large',

		'LineInfoTextAlign' => 'right',
		'LineInfoMargin' => '0px 22px 0px 22px',
		'LineInfoPadding' => '0px',

		'Line_Data_Font_size' => 'x-small',
		'Line_Data_Font_style' => 'normal', //italic
		'Line_Data_Text_Color' => 'gray', //#FF8000',
		'Line_Data_Text_Align' => 'right',

		'Line_Data_Basename_Font_size' => 'small',
		'Line_Data_Basename_Font_style' => 'bold',
		'Line_Data_Basename_Text_Color' =>  '#000000',  //#8266F2', //#FF8000',
		'Line_Data_Basename_Text_Align' => 'right',
		'Line_Data_Basename_Font_weight' => 'bolder',

//		'PrePost_Line_Font_size' => 'small',
//		'PrePost_Line_Font_style' => 'italic',
//		'PrePost_Line_Text_Color' => '#417232',
//		'PrePost_Line_BackgroundColor' => 'LightGray',
//		'PrePost_Line_Margin' => '25px',
	);

	/*
	 * for the tab indent these are the changed parameters
	 *		(could also include indent if we actually want a leading indent)
	 */
	protected $tabOverSet = [
		0 => ['OverallBackgroundColor'=> '#FFFDCC', 'OverallText_Color' => '#0000FF',],
		1=>  ['OverallBackgroundColor'=> '#FBECC1', 'OverallText_Color' => '#228B22',],
		2=>  ['OverallBackgroundColor'=> '#BC986A', 'OverallText_Color' => '#FFFFFF',],
		3=>  ['OverallBackgroundColor'=> '#DAAD86', 'OverallText_Color' => '#0000CC',],
		4=>  ['OverallBackgroundColor'=> '#659DBD', 'OverallText_Color' => '#FFFFFF',],
		5=>  ['OverallBackgroundColor'=> '#8D8741', 'OverallText_Color' => '#FFFFFF',],
		6=>  ['OverallBackgroundColor'=> '#EDF5E1', 'OverallText_Color' => '#0000DD',],
		7=>  ['OverallBackgroundColor'=> '#8EE4AF', 'OverallText_Color' => '#0000DD',],
		8=>  ['OverallBackgroundColor'=> '#5CDB95', 'OverallText_Color' => '#FFFFFF',],
		9=>  ['OverallBackgroundColor'=> '#379683', 'OverallText_Color' => '#FFFFFF',],
		10=>  ['OverallBackgroundColor'=> '#CAFAFE','OverallText_Color' => '#000000',],
		11=>  ['OverallBackgroundColor'=> '#97CAEF','OverallText_Color' => '#ffffff',],
		12=>  ['OverallBackgroundColor'=> '#55BCC9','OverallText_Color' => '#0000DD',],
		13=>  ['OverallBackgroundColor'=> '#3FEEE6','OverallText_Color' => '#0000DD',],
		14=>  ['OverallBackgroundColor'=> '#907163','OverallText_Color' => '#FFFFFF',],
		15=>  ['OverallBackgroundColor'=> '#379683','OverallText_Color' => '#0000DD',],
	];

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $presetName
	 */
	public function __construct(string $presetName = 'none') {

		$this->originalConfigArray = serialize($this->currentSet);

		if (method_exists($this, $presetName)  and in_array($presetName, self::LISTOFPRESETS)) {
			$this->$presetName();
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function DumpClasses() {
		$this->OverallBackgroundColor = '#FDF100';
		$this->OverallText_Color = '#000000';
		$this->preAreaBorderColor = '#000000';
		$this->preAreaFontWeight = '600';
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function reset() {
		self::$currentIndentLevel =0;
		$this->currentSet= unserialize($this->originalConfigArray);
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function tabOver(){
		self::$currentIndentLevel = (self::$currentIndentLevel +1) % 15;

		$this->copyChangesToSetting( $this->tabOverSet[self::$currentIndentLevel ]);
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function tabBack(){
		self::$currentIndentLevel --;
		if (self::$currentIndentLevel <0) {
			self::$currentIndentLevel =0;
		}
		$this->copyChangesToSetting( $this->tabOverSet[self::$currentIndentLevel ]);
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param array $diffSettings
	 * @return boolean
	 */
	protected function copyChangesToSetting(array $diffSettings) {
		foreach ($diffSettings as $key => $value) {
			$this->currentSet[$key] = $value;
		}
		return false;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $name
	 * @return bool
	 */
	public function __isset($name) :bool {
		RETURN isset( $this->currentSet[$name]);
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $name
	 * @param type $value
	 */
	public function __set($name, $value) {
		$this->currentSet[$name] = $value;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $name
	 * @return type
	 */
	public function __get($name) {
		if ( isset($this->currentSet[$name])) {
			RETURN $this->currentSet[$name];
		} else {
			return null;
		}
	}

	/**
	<div id="dumpAreaStart_a"
			style="background-color: #F0FFD5; "
			. "border-style: dashed; "
			. "border-width: 1px; "
			. "border-color: #950095; "
			. "overflow: auto; "
			. "padding-bottom: 1px; "
			. "margin-bottom: 1px; "
			. "width: 95%; "
			. "height: -1em;"
			>
		<span id="varName" style="font-size: large; "
			. "background-color: #7DEEA2; "
			. "color: #950095; "
			. "font-weight: 100;">
			filter_input_array(\INPUT_POST, \FILTER_SANITIZE_STRING)
		</span>
		<pre id="varData" style="font-size: large; "
				. "background-color: ; "
				. "color: #950095; "
				. "font-weight: normal;">
			-=Null=-
		</pre>
		<div style="text-align: right;">
			<span id="LineData_A" style="font-size: small; font-style: normal; color:#FF8000; text-align: right;">
				server=localhost P:\Projects\NB_projects\php_code_base\src\
			</span>
			<span id="LineData_B" style="font-size: medium; font-style: bold; color:#8266F2; font-weight:bolder; text-align: right;">
				resolver.class.php (line: 140)
			</span>
		</div>
	</div>
	**/


	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $counter
	 * @return string
	 */
	public function giveOverallDiv( $counter): string {
		$out = '<div'
			. ' id=DumpArea_'				. $counter
			. ' style="'
				. 'color: '					. $this->OverallText_Color			. '; '
				. 'background-color: '		. $this->OverallBackgroundColor		. '; '
				. 'border-style: '			. $this->OverallBorder_style		. '; '
				. 'border-width: '			. $this->OverallBorder_width		. '; '
				. 'border-color: '			. $this->OverallArea_Border_Color	. '; '
				. 'border-radius: '			. $this->OverallBorder_radius		. '; '
				. 'overflow: '				. $this->OverallOverflow			. '; '
				. 'padding-bottom: '		. $this->OverallPadding_bottom		. '; '
				. 'margin: '				. $this->OverallMargin				. '; '
				. 'width: '					. $this->OverallWidth				. '; '
				// . 'height: ' . $this->OverallHeight . ';'
			. '">' . PHP_EOL;
		return $out;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return string
	 */
	public function giveOverallAfterDiv(): string {
		return '</div>' . PHP_EOL;
	}


	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return string
	 * 		<span id="varName" style="font-size: large; "
			. "background-color: #7DEEA2; "
			. "color: #950095; "
			. "font-weight: 100;">

	 */
	public function giveTitleSpan($counter) : string {
		$out = '<span id="TitleName_' . $counter. '"'
				. ' style="'
					. 'background-color: ' . $this->TitleBackgroundColor . '; '
				//	. 'color: ' . $this->TitleColor . '; '
					. 'font-weight: ' . $this->TitleFontWeight . '; '
					. '">' . PHP_EOL;
		return $out;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return string
	 */
	public function giveTitleAfterSpan() :string{
		return '</span>' . PHP_EOL;
	}

	/**
	 *
	 	<pre id="varData" style="font-size: large; "
				. "background-color: ; "
				. "color: #950095; "
				. "font-weight: normal;">
			-=Null=-
		</pre>

	 */


	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $counter
	 * @return string
	 */
	public function giveVarPre($counter){
		$out = '<div id="varValue_' . $counter. '" '
				. 'style="'
				//. 'background-color: ' . $this->PreAreaBackGround . '; '
				. 'border-style: ' . $this->preAreaBorderStyle . '; '
				. 'font-weight: ' .  $this->preAreaFontWeight .'; '
			//	. 'color: ' . $this->preAreaBorderColor . '; '
				. 'margin: ' . $this->preAreaMargin  . ';'
				.'">' . PHP_EOL;
		return $out;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return type
	 */
	public function giveVarAfterPre() {
		return '</div>' . PHP_EOL;
	}

	/*
		<div style="text-align: right;">
			<span id="LineData_A" style="font-size: small; font-style: normal; color:#FF8000; text-align: right;">
				server=localhost P:\Projects\NB_projects\php_code_base\src\
			</span>
			<span id="LineData_B" style="font-size: medium; font-style: bold; color:#8266F2; font-weight:bolder; text-align: right;">
				resolver.class.php (line: 140)
			</span>
		</div>
	*/


	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $counter
	 * @return string
	 */
	public function giveLineInfoDiv($counter) {
		$out = '<div id="lineinfo_' . $counter .'" '
				. 'style="'
					. 'text-align: ' . $this->LineInfoTextAlign . '; '
					. 'margin: ' . $this->LineInfoMargin . '; '
					. 'padding: ' . $this->LineInfoPadding . '; '
					.'">' . PHP_EOL;
		return $out;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return string
	 */
	public function giveLineInfoAfterDiv() :string {
		return '</div>' . PHP_EOL;
	}

	/** -----------------------------------------------------------------------------------------------
	 * 			<span id="LineData_A" style="font-size: small; font-style: normal; color:#FF8000; text-align: right;">
	*/
	public function giveLineInfoSubSpanServerAndPathLines($counter) :string {
		$out = '<span id="ServerPath_' . $counter . '" '
				. 'style="'
				. 'font-size: '		. $this->Line_Data_Font_size .'; '
				. 'font-style: '	. $this->Line_Data_Font_style . '; '
				. 'color:'			. $this->Line_Data_Text_Color . '; '
				. 'text-align: '	. $this->Line_Data_Text_Align . '; '
				. '">' .PHP_EOL;
		return $out;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return string
	 */
	public function giveLineInfoSubSpanAfterServerAndPathLines() : string{
		return '</span>' . PHP_EOL;
	}

	/** -----------------------------------------------------------------------------------------------
		<span id="LineData_B" style="font-size: medium; font-style: bold; color:#8266F2; font-weight:bolder; text-align: right;">
	*/
	public function giveLineInfoSubSpanFileAndLine($counter) : string {
		$out = '<span id="ServerPath_' . $counter . '" '
				. 'style="'
				. 'font-size: '		. $this->Line_Data_Basename_Font_size .'; '
				. 'font-style: '	. $this->Line_Data_Basename_Font_style . '; '
				. 'color:'			. $this->Line_Data_Basename_Text_Color . '; '
				. 'text-align: '	. $this->Line_Data_Basename_Text_Align . '; '
				. 'font-weight: '	. $this->Line_Data_Basename_Font_weight .'; '
				. '">' . PHP_EOL;
		return $out;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return string
	 */
	public function giveLineInfoSubSpanAfterFileAndLine() : string {
		return '</span>' . PHP_EOL;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return string
	 */
	public function giveHRseparator() : string {
		$out = '<HR size=' . $this->HRseparatorSize . ' '
				. 'style="'
				. 'padding: ' . $this->HRseparatorPadding . '; '
				. 'margin: ' . $this->HRseparatorMargin . '; '
				. '">';
		return $out;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $val
	 * @param type $counter
	 * @param type $varCounter
	 * @return type
	 */
	public function giveVarValue( $val, $counter =1, $varCounter =0) {
		$out ='';
		if ( $varCounter %2 ){
			$out .= $this->giveEvenStart($counter);
		} else {
			$out .= $this->giveOddStart($counter);
		}
		$out .= $val;
		$out .= $this->giveEvenOddEnd();

		return $out;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $counter
	 * @return string
	 */
	public function giveEvenStart($counter) : string {
		$out ='';
		$out .= '<PRE id="varValue_' . $counter. '" '
				. 'style="'
				//. 'background-color: ' . $this->PreAreaBackGround . '; '
				. 'background-color: ' . $this->OverallBackgroundColor . '; '
				. 'border-style: ' . $this->preAreaBorderStyle . '; '
				. 'font-weight: ' .  $this->preAreaFontWeight .'; '
			//	. 'color: ' . $this->preAreaTextColor . '; '
				. 'margin: ' . $this->preAreaMargin  . ';'
				.'">' . PHP_EOL;
		return $out;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $counter
	 * @return string
	 */
	public function giveOddStart($counter) : string {
		$out ='';
		//$x = hexdec( substr($this->PreAreaBackGround, 1));
		$x = hexdec( substr($this->OverallBackgroundColor, 1));
		$bgcolor =  $x  - 0x001400;

//				. 'background-color: ' . $this->PreOddAreaBackGround . '; '
		$out .= '<PRE id="varValue_' . $counter. '" '
				. 'style="'
				. 'background-color: ' . dechex( $bgcolor ). '; '
				. 'border-style: ' . $this->preAreaBorderStyle . '; '
				. 'font-weight: ' .  $this->preAreaFontWeight .'; '
				//. 'color: ' . $this->preAreaTextColor . '; '
				. 'color: ' . $this->OverallText_Color . '; '
				. 'margin: ' . $this->preAreaMargin  . ';'
				.'">' . PHP_EOL;
		return $out;

	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return string
	 */
	public function giveEvenOddEnd() : string {
		return '</Pre>';
	}

}
