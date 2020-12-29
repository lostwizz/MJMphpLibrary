<?php

declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

Class DebugAnItem {

	public $item_id = -1;
	public $codex = ''; //_REQUEST';
	public $description = 'default';
//	public $owner;
//	public $level =5;   //1=low, 5= medium, 9= high
	public $foregroundColor = '#ffffff'; //#0000FF';
	public $backgroundColor = '#C0C0C0';
//	public $categoryId = -1;
	public $textSize = '8pt';
	public $flags = 0b0000_0000_0000_0000_0000_0000_0010_0000;

	/*
	 * the flags:
	 *  0b0000_0000_0000_0000_0000_0000_0000_0001 - show the class in the debug stmt
	 *  0b0000_0000_0000_0000_0000_0000_0000_0010 - show the func in the debug stmt
	 *  0b0000_0000_0000_0000_0000_0000_0000_0100 - show the type in the debug stmt
	 *  0b0000_0000_0000_0000_0000_0000_0000_1000 - show the args to func in the debug stmt
	 *
	 *  0b0000_0000_0000_0000_0000_0000_0001_0000 - bold the line number
	 *  0b0000_0000_0000_0000_0000_0000_0010_0000 - italics the filename
	 *  0b0000_0000_0000_0000_0000_0000_0100_0000 -
	 *  0b0000_0000_0000_0000_0000_0000_1000_0000 -
	 *
	 */


//	/** --------------------------------------------------------------------------
//	 */
//	public static function initialize() :void {
//
//	}
}
