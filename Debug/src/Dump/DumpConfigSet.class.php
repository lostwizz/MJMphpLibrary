<?php
declare(strict_types=1);

namespace MJMphpLibrary\Debug\Dump;


Class DumpConfigSet {
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

	const LISTOFPRESETS = [
		'NORMAL',
		'LONG',
		'PRE3POST3',
		'LONGPRE3POST3',
		'MULTI_ARRAY',
		'SHORT',
		'TAB_OVER',
		'TAB_BACK',
	];

	public static int $currentIndentLevel =0;

	public $currentSet = array(
		'FLAT_WINDOWS_LINES' => 7, //  big a output block can be before adding scrollbars
		'PRE_CodeLines' => 0, // show the number of lines before the call
		'POST_CodeLines' => 0, // show the number of lines after the call
		'Show_BackTrace_Num_Lines' => 1, // show the backtrace calls (how many lines in the history
		'Only_Return_Output_String' => false, // dont print/echo anything just return a string with it all
		'skipNumLines' => false,
		'Area_Border_Color' => '#950095',
		'is_On' => true, // make the output look pretty
		'OverallText_Color' => '#0000FF',

		'OverallBackgroundColor' => '#FFFDCC', //'#E3FCFD',		// set the background color
		'OverallHeight' => '7em',
		'OverallWidth' => '95%',
		'OverallPadding_bottom' => '1px',
		'OverallMargin_bottom' => '1px',
		'OverallOverflow' => 'auto',
		'OverallBorder_style' => 'dashed',
		'OverallBorder_width' => '1px',
		'OverallArea_Border_Color' => '#950095',

		'TitleColor' => 'green',
//		'TitleBackgroundColor' => '#7DEEA2',
		'TitleFontweight' => '100',

		'PreAreaBackGround' => '#ADFF2F', //#7DEEA2',
		'preAreaBorderColor' => '#950095',
		'preAreaFontWeight' => 'normal',


		'Var_Name_Font_size' => 'large',
		'Var_Text_Color' => '#950095',
		'Var_Font_weight' => '100',
		'Var_Data_Font_size' => 'large',

		'LineInfoTextAlign' => 'right',

		'Line_Data_Font_size' => 'x-small',
		'Line_Data_Font_style' => 'normal', //italic
		'Line_Data_Text_Color' => '#FF8000',
		'Line_Data_Text_Align' => 'right',

		'Line_Data_Basename_Font_size' => 'medium',
		'Line_Data_Basename_Font_style' => 'bold',
		'Line_Data_Basename_Text_Color' => '#8266F2', //#FF8000',
		'Line_Data_Basename_Text_Align' => 'right',
		'Line_Data_Basename_Font_weight' => 'bolder',

//		'PrePost_Line_Font_size' => 'small',
//		'PrePost_Line_Font_style' => 'italic',
//		'PrePost_Line_Text_Color' => '#417232',
//		'PrePost_Line_BackgroundColor' => 'LightGray',
//		'PrePost_Line_Margin' => '25px',
	);

	public $tabOverSet = [
		0 => ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000FF',],
		1=>  ['OverallBackgroundColor'=> '#FFa0CC',
				'OverallText_Color' => '#0000DD',],
		2=>  ['OverallBackgroundColor'=> '#FFaDCC',
				'OverallText_Color' => '#0000DD',],
		3=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000CC',],
		4=>  ['OverallBackgroundColor'=> '#E3C8EA',
				'OverallText_Color' => '#0000EE',],
		5=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000FF',],
		6=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000DD',],
		7=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000DD',],
		8=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000DD',],
		9=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000DD',],
		10=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000DD',],
		11=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000DD',],
		12=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000DD',],
		13=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000DD',],
		14=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000DD',],
		15=>  ['OverallBackgroundColor'=> '#FFFDCC',
				'OverallText_Color' => '#0000DD',],
	];

	public function __construct(string $presetName = 'none') {
		if (method_exists($this, $presetName)  and in_array($presetName, self::LISTOFPRESETS)) {
			$this->$presetName();
		}
	}

	public function NORMAL() {
		$this->currentSet['Beautify_BackgroundColor'] = '#E3FCFD';
	}
	public function LONG(){
	}
	public function PRE3POST3(){
	}
	public function LONGPRE3POST3(){
	}
	public function	MULTI_ARRAY(){
	}
	public function SHORT(){
	}

	public function TAB_OVER(){
		self::$currentIndentLevel ++;
		//$x = self::$currentIndentLevel;
		$this->copyChangesToSetting( $this->tabOverSet[self::$currentIndentLevel ]);
		//$this->copyChangesToSetting( $this->tabOverSet[$x]);
	}

	public function TAB_BACK(){
		self::$currentIndentLevel --;
		$this->copyChangesToSetting( $this->tabOverSet[self::$currentIndentLevel ]);
	}

	public function copyChangesToSetting(array $diffSettings) {
		foreach ($diffSettings as $key => $value) {
			$this->currentSet[$key] = $value;
		}
		return false;
	}


	public function __isset($name) :bool {
		RETURN isset( $this->currentSet[$name]);
	}

	public function __set($name, $value) {
		$this->currentSet[$name] = $value;
	}
	public function __get($name) {
		if ( isset($this->currentSet[$name])) {
			RETURN $this->currentSet[$name];
		} else {
			return null;
		}
	}

//	public function giveStyleElement( string $type, string $settingName) : string {
//		return $type . ': ' . $this->currentSet[ $settingName] . '; ';
//	}

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


	public function giveOverallDiv( $counter): string {
		$out = '<div'
			. ' id=DumpArea_'				. $counter
			. ' style="'
				. 'color: '					. $this->OverallText_Color		. '; '
				. 'background-color: '		. $this->OverallBackgroundColor		. '; '
				. 'border-style: '			. $this->OverallBorder_style		. '; '
				. 'border-width: '			. $this->OverallBorder_width		. '; '
				. 'border-color: '			. $this->OverallArea_Border_Color	. '; '
				. 'overflow: '				. $this->OverallOverflow			. '; '
				. 'padding-bottom: '		. $this->OverallMargin_bottom		. '; '
				. 'margin-bottom: '			. $this->OverallPadding_bottom		. '; '
				. 'width: '					. $this->OverallWidth				. '; '
				// . 'height: ' . $this->OverallHeight . ';'
			. '">'. PHP_EOL;
		return $out;
	}

	public function giveOverallAfterDiv(): string {
		return '</div>'. PHP_EOL;
	}
	/**
	 *
	 * @return string
	 * 		<span id="varName" style="font-size: large; "
			. "background-color: #7DEEA2; "
			. "color: #950095; "
			. "font-weight: 100;">

	 */

	public function giveTitleSpan($counter) : string {
		$out = '<span id="varName_' . $counter. '"'
				. ' style="'
					. 'background-color: ' . $this->TitleBackgroundColor . '; '
					. 'color: ' . $this->TitleColor . '; '
					. 'font-weight: ' . $this->TitleFontWeight . '; '
					. '">'. PHP_EOL;
		return $out;
	}

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
	public function giveVarPre($counter){
		$out = '<PRE style="'
				. 'background-color: ' . $this->PreAreaBackGround . ': '
				. 'border-style: ' . $this->preAreaBorderStyle . '; '
				. 'fontWeight: ' .  $this->preAreaFontWeight .'; '
				. 'color: ' . $this->preAreaBorderColor . '; '
				.'">' . PHP_EOL;
		return $out;
	}

	public function giveVarAfterPre() {
		return '</pre>' . PHP_EOL;
	}

	/**
		<div style="text-align: right;">
			<span id="LineData_A" style="font-size: small; font-style: normal; color:#FF8000; text-align: right;">
				server=localhost P:\Projects\NB_projects\php_code_base\src\
			</span>
			<span id="LineData_B" style="font-size: medium; font-style: bold; color:#8266F2; font-weight:bolder; text-align: right;">
				resolver.class.php (line: 140)
			</span>
		</div>
	*/
	public function giveLineInfoDiv($counter) {
		$out = '<div id="lineinfo_' . $counter .'" '
				. 'style="'
					. 'text-align: ' . $this->LineInfoTextAlign . '; '
					.'">' . PHP_EOL;
		return $out;
	}

	public function giveLineInfoAfterDiv() :string {
		return '</div>' . PHP_EOL;
	}

	/**
			<span id="LineData_A" style="font-size: small; font-style: normal; color:#FF8000; text-align: right;">
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

	public function giveLineInfoSubSpanAfterServerAndPathLines() : string{
		return '</span>' . PHP_EOL;
	}

	/**
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
				. '">' .PHP_EOL;
		return $out;
	}

	public function giveLineInfoSubSpanAfterFileAndLine() : string {
		return '</span>' . PHP_EOL;
	}





}
