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
		'Show_BackTrace_Num_Lines' => 0, // show the backtrace calls (how many lines in the history
		'Only_Return_Output_String' => false, // dont print/echo anything just return a string with it all
		'skipNumLines' => false,
		'Area_Border_Color' => '#950095',
		'Beautify_is_On' => true, // make the output look pretty
		'Beautify_BackgroundColor' => '#FFFDCC', //'#E3FCFD',		// set the background color
		'Beautify_Text_Color' => '#0000FF',
		'Beautify_PreWidth' => '95%',
		'Beautify_Padding_bottom' => '1px',
		'Beautify_Margin_bottom' => '1px',
		'Beautify_Overflow' => 'auto',
		'Beautify_Border_style' => 'dashed',
		'Beautify_Border_width' => '1px',
		'Beautify_Var_Name_Font_size' => 'large',
		'Beautify_Var_Name_BackgroundColor' => '#7DEEA2',
		'Beautify_Var_Text_Color' => '#950095',
		'Beautify_Var_Font_weight' => '100',
		'Beautify_Title_Color' => 'green',
		'Beautify_Title_Font_weight' => '100',
		'Beautify_Var_Data_Font_size' => 'large',
		'Beautify_Var_Data_Font_background_Color' => '', //#ADFF2F', //#7DEEA2',
		'Beautify_Var_Data_Text_Color' => '#950095',
		'Beautify_Var_Data_Font_weight' => 'normal',
		'Beautify_Line_Data_Font_size' => 'small',
		'Beautify_Line_Data_Font_style' => 'normal', //italic
		'Beautify_Line_Data_Text_Color' => '#FF8000',
		'Beautify_Line_Data_Basename_Font_size' => 'medium',
		'Beautify_Line_Data_Basename_Font_style' => 'bold',
		'Beautify_Line_Data_Basename_Text_Color' => '#8266F2', //#FF8000',
		'Beautify_Line_Data_Basename_Font_weight' => 'bolder',
		'Beautify_PrePost_Line_Font_size' => 'small',
		'Beautify_PrePost_Line_Font_style' => 'italic',
		'Beautify_PrePost_Line_Text_Color' => '#417232',
		'Beautify_PrePost_Line_BackgroundColor' => 'LightGray',
		'Beautify_PrePost_Line_Margin' => '25px',
		'Beautify_PrePost_Line_Text_align' => 'left',
	);

	public $tabOverSet = [
		0 => ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000FF',],
		1=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		2=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		3=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		4=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		5=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		6=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		7=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		8=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		9=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		10=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		11=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		12=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		13=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		14=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
		15=>  ['Beautify_BackgroundColor'=> '#FFFDCC',
				'Beautify Text Color' => '#0000DD',],
	];

	public function __construct(string $presetName = null) {
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
		$this->copyChangesToSetting( $tabOverSet[self::$currentIndentLevel ]);
	}
	public function TAB_BACK(){
		self::$currentIndentLevel --;
		$this->copyChangesToSetting( $tabOverSet[self::$currentIndentLevel ]);
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
}
