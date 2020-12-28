<?php

declare(strict_types=1);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MJMphpLibrary\Debug\DebugSystem;

Class DebugItem {

	public $itemId;
	public $code;
	public $description;
	public $owner;
	public $level;   //1=low, 5= medium, 9= high
	public $foregroundColor;
	public $backgroundColor;
	public $categoryId;
	public $textSize;



	/** --------------------------------------------------------------------------
	 *
	 * @param type $num
	 * @return self
	 */
	function fakeFillItem($num): self {

		$this->item_id = $num;
		$this->code = 'menu_System';
		$this->description = 'Menu System' . $num;
		$this->owner = 'Mike';
		$this->level = 5;
		$this->foregroundColor = '#228B22';
		$this->backgroundColor = '#FFFFFF';
		$this->textSize = '9pt';
		$this->$categoryId = 1;
	}

	/** --------------------------------------------------------------------------
	 */
}
