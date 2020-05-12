<?php
/** * ********************************************************************************************
 * messagelog.class.php
 *
 * Summary: handles a message log queue for messages at the footer of a page
 *
 * @author mike.merrett@whitehorse.ca
 * @version 0.5.0
 * $Id: 35a996341843768f07d83d90ae1fd4897ca6218b $
 *
 * Description
 * handles a message log queue
 *
 *
 * @package utils
 * @subpackage Message Log
 * @since 0.3.0
 *
 * @see settings
 * @see myNullAbsorber
 *
 * @example
 *  Settings::GetRunTimeObject('MessageLog')->addNotice( 'dispatcher starting prequeue' );
 *
 * @todo Description
 *
 */
//**********************************************************************************************

namespace php_base\Utils;

//if ( ! defined( "IS_PHPUNIT_TESTING")){
//	<link rel="stylesheet" href=".\static\css\message_stack_style.css"><?php
//}

use \php_base\Utils\Settings as Settings;
use \php_base\Utils\HTML\HTML as HTML;
use \php_base\Utils\Dump\Dump as Dump;

define('AR_TEXT', 0);
define('AR_TimeStamp', 1);
define('AR_LEVEL', 2);
define('AR_CODEDETAILS', 3);

//
//if (basename(__FILE__) == basename($_SERVER['PHP_SELF'])){
////if ( empty(get_included_files()) ) {
//	echo 'called directly';
//} else {
//	echo 'not called directly';
//	echo '<pre>';
//	//print_r( get_included_files());
//	print_r( __FILE__);
//	print_r($_SERVER) ;
//	echo '</pre>';
//}



//***********************************************************************************************
//***********************************************************************************************
//***********************************************************************************************
//***********************************************************************************************
//***********************************************************************************************
//***********************************************************************************************
/**
 * the message log handler
 */
class MessageLog {

	/** the queue static so there is only one */
	public static $messageQueue;

	const DEFAULT_SUBSYSTEM = 'general';
	public static $DEFAULTLoggingLevel = MessageBase::WARNING;
	public static $LoggingLevels = null; //array( self::DEFAULT_SUBSYSTEM =>  MessageBase::WARNING);

	/**
	 * @var version number
	 */
	private const VERSION = '0.4.0';


	/** -----------------------------------------------------------------------------------------------
	 * construct a message log - i.e. the queue
	 */
	function __construct() {
		if (empty(self::$messageQueue)) {
			self::$messageQueue = new \SplQueue();
		}
		self::$DEFAULTLoggingLevel = Settings::getPublic('IS_DETAILED_DEFAULT_NOTIFICATION_LEVEL');
		self::$LoggingLevels = array(self::DEFAULT_SUBSYSTEM => Settings::getPublic('IS_DETAILED_DEFAULT_NOTIFICATION_LEVEL'));
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
	 *
	 * @return bool
	 */
	public function isNotANullableClass() : bool {
		return true;
	}

	/** -----------------------------------------------------------------------------------------------
	 * handle trying to show message log as a string
	 * @return string
	 */
	public function __toString() : string{
		$s = '';
		self::$messageQueue->rewind();

		while (self::$messageQueue->valid()) {
			$x = self::$messageQueue->current();
			$y = $x->__toString();
			$w = str_replace('&nbsp;', ' ', $y);
			$w2 = str_replace('  ', ' ', $w);
			$v  = strip_tags($w2);
			$result  = preg_replace('/[^a-zA-Z0-9_ :()-]/s','',$v);

			$s .= $result;
			$s .= PHP_EOL;
			self::$messageQueue->next(); //switch to next list item
		}
		$s .=  print_r(self::$LoggingLevels,true);
		return $s;
	}





	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return type
	 */
	public function __debugInfo() {
		//return [MessageLog::messageQueue, MessageLog::DEFAULTLoggingLevel, MessageLog::LoggingLevels];

		//		//Settings::SetPublic('Show MessageLog Adds', false);
		//Settings::SetPublic('Show MessageLog Adds_FileAndLine', false);

		$loglevelsAR = array();
		foreach(self::$LoggingLevels as $key =>$value) {
			$loglevelsAR[$key] = $value . ' (' . MessageBase::$levels[ $value] . ')';
		}

		return [
			'Default_level' => MessageLog::$DEFAULTLoggingLevel . ' (' .MessageBase::$levels[MessageLog::$DEFAULTLoggingLevel] . ')',
			//'Default_level_raw' =>MessageLog::$DEFAULTLoggingLevel,
			'default_subsystem' => self::DEFAULT_SUBSYSTEM,
			'Logging_levels' => $loglevelsAR, //print_r(self::$LoggingLevels, true),
			//'queue' => $this->giveUglyMessageQueue(),
			];
	}

	/** -----------------------------------------------------------------------------------------------
	 * add a new message to the stack ( may include some values passed down to the message class)
	 *
	 * @param type $obj_or_array
	 * @param type $val2
	 * @param type $val3
	 */
	public function addAndShow($obj_or_array = null, $val2 = null, $val3 = null) : void{
		$this->add($obj_or_array, $val2, $val3);
		$this->showAllMessages();
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $level
	 * @param string $subSystem
	 * @return bool
	 */
	public static function isGoodLevelsAndSystem( $level, string $subSystem) : bool {
		if (key_exists($subSystem, self::$LoggingLevels)) {
			$lvl = self::$LoggingLevels[$subSystem];
		} else {
			self::$LoggingLevels[ $subSystem ] = self::$DEFAULTLoggingLevel;
			$lvl = self::$DEFAULTLoggingLevel;
		}
		//$x = ( ($level >= $lvl) ? '--True--':'--false--');
		return ( $level >= $lvl) ;
	}


	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $subSystem
	 * @param type $level
	 */
	public function setSubSystemLoggingLevel( string $subSystem, $level = null) : void{
		if (is_null( $level) ){
			$level = self::$DEFAULTLoggingLevel;
		}
		self::$LoggingLevels[$subSystem] = $level;
	}


	/** -----------------------------------------------------------------------------------------------
	 * figure out where to start showing the back trace
	 *   - if you called the MessageLog system directly then it is one back
	 *   - if you called it thru subSystemMesage than it may be further back - so look for the magic word and return it
	 *
	 * @param type $bt
	 * @param type $magicWord
	 * @return int
	 */
	protected function figureOutWhichBTisRelevant($bt, $magicWord = 'MessageLog.class.php') :int {
		$r = 0;

		for ($i = 0; $i <= count($bt); $i++) {
			if (basename($bt[$i]['file']) != $magicWord) { // look for the magic word in the file name
				$r = $i;
				break;
			}
		}
		if ($r >= count($bt)) {
			return $r - 1;  // not found so return one item before the last item (becuase of the btLvl+1 in generateGoodBT
		} else {
			return $r;
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 * make a back trace look pretty
	 * @param type $bt
	 * @param bool $includeSpan
	 * @return string
	 */
	protected function generateGoodBT($bt) :string{
		$btLvl = $this->figureOutWhichBTisRelevant($bt);
		$mid =  basename($bt[$btLvl]['file'])
				. ':'
				. $bt[$btLvl]['line']
				. ' ('
				. (empty($bt[$btLvl + 1]['class']) ? '' : basename($bt[$btLvl + 1]['class']) )
				. '.'
				. (empty($bt[$btLvl + 1]['function']) ? '' : $bt[$btLvl + 1]['function'] )
				. ')';


		return $mid;
	}

	/** -----------------------------------------------------------------------------------------------
	 * add a new message to the stack ( may include some values passed down to the message class)
	 *
	 * @param type $obj_or_array
	 * @param type $timestamp
	 * @param type $level
	 */
	public function add($obj_or_array = null, $timestamp = null, $level = null, string $subSystem = self::DEFAULT_SUBSYSTEM )  :void{
		if ( ! self::isGoodLevelsAndSystem( $level, $subSystem)) {
			return;  // if msg level is lower than setting then do nothing
		}

		$codeDetails ='';
		$bt = debug_backtrace(false, 5);
		$codeDetails =  $this->generateGoodBT($bt, false);

		if (is_object($obj_or_array) and ( $obj_or_array instanceof AMessage )) {
			$obj_or_array->setCodeDetails =  $codeDetails;
			self::$messageQueue->enqueue($obj_or_array);
			$temp = $obj_or_array;  // needed later for the show adds
		} else {
			if (Settings::GetPublic('Show MessageLog Adds_FileAndLine')) {
				$temp = new AMessage($obj_or_array, $timestamp, $level, $codeDetails);               //create the AMessage
			} else {
				$temp = new AMessage($obj_or_array, $timestamp, $level);
			}
			// add the item to the queue
			self::$messageQueue->enqueue($temp);
		}
		if (Settings::GetPublic('Show MessageLog Adds')) {
			$temp->show();
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 * add a to do message to the log
	 * @param type $obj_or_array
	 * @param type $timestamp
	 */
	public function addToDo($obj_or_array = null, $timestamp = null, string $subSystem=self::DEFAULT_SUBSYSTEM ): void {
		if (is_array($obj_or_array) and ! empty($obj_or_array[2])) {
			$obj_or_array[2] = AMessage::TODO;
		}
		$this->add($obj_or_array, $timestamp, AMessage::TODO, $subSystem);
	}

	/** -----------------------------------------------------------------------------------------------
	 * add a debug message
	 * @param type $obj_or_array
	 * @param type $timestamp
	 */
	public function addDebug($obj_or_array = null, $timestamp = null, string $subSystem=self::DEFAULT_SUBSYSTEM ) : void{
		if (is_array($obj_or_array) and ! empty($obj_or_array[2])) {
			$obj_or_array[2] = AMessage::DEBUG;
		}
		$this->add($obj_or_array, $timestamp, AMessage::DEBUG, $subSystem);
	}

	/** -----------------------------------------------------------------------------------------------
	 * add a info message
	 * @param type $obj_or_array
	 * @param type $timestamp
	 */
	public function addInfo($obj_or_array = null, $timestamp = null, string $subSystem=self::DEFAULT_SUBSYSTEM ) :void {
		if (is_array($obj_or_array) and ! empty($obj_or_array[2])) {
			$obj_or_array[2] = AMessage::INFO;
		}
		$this->add($obj_or_array, $timestamp, AMessage::INFO, $subSystem);
	}

	/** -----------------------------------------------------------------------------------------------
	 * add a notice message
	 * @param type $obj_or_array
	 * @param type $timestamp
	 */
	public function addNotice($obj_or_array = null, $timestamp = null, string $subSystem=self::DEFAULT_SUBSYSTEM ) :void {
		if (is_array($obj_or_array) and ! empty($obj_or_array[2])) {
			$obj_or_array[2] = AMessage::NOTICE;
		}
		$this->add($obj_or_array, $timestamp, AMessage::NOTICE, $subSystem);
	}

	/** -----------------------------------------------------------------------------------------------
	 * add a warning message
	 * @param type $obj_or_array
	 * @param type $timestamp
	 */
	public function addWarning($obj_or_array = null, $timestamp = null, string $subSystem=self::DEFAULT_SUBSYSTEM ):void {
		if (is_array($obj_or_array) and ! empty($obj_or_array[2])) {
			$obj_or_array[2] = AMessage::WARNING;
		}
		$this->add($obj_or_array, $timestamp, AMessage::WARNING, $subSystem);
	}

	/** -----------------------------------------------------------------------------------------------
	 * add an error message
	 * @param type $obj_or_array
	 * @param type $timestamp
	 */
	public function addError($obj_or_array = null, $timestamp = null, string $subSystem=self::DEFAULT_SUBSYSTEM ) :void {
		if (is_array($obj_or_array) and ! empty($obj_or_array[2])) {
			$obj_or_array[2] = AMessage::ERROR;
		}
		$this->add($obj_or_array, $timestamp, AMessage::ERROR, $subSystem);
	}

	/** -----------------------------------------------------------------------------------------------
	 * add a critical message
	 * @param type $obj_or_array
	 * @param type $timestamp
	 */
	public function addCritical($obj_or_array = null, $timestamp = null, string $subSystem=self::DEFAULT_SUBSYSTEM ) {
		if (is_array($obj_or_array) and ! empty($obj_or_array[2])) {
			$obj_or_array[2] = AMessage::CRITICAL;
		}
		$this->add($obj_or_array, $timestamp, AMessage::CRITICAL, $subSystem);
	}

	/** -----------------------------------------------------------------------------------------------
	 * add an alert message
	 * @param type $obj_or_array
	 * @param type $timestamp
	 */
	public function addAlert($obj_or_array = null, $timestamp = null, string $subSystem=self::DEFAULT_SUBSYSTEM ) : void{
		if (is_array($obj_or_array) and ! empty($obj_or_array[2])) {
			$obj_or_array[2] = AMessage::ALERT;
		}
		$this->add($obj_or_array, $timestamp, AMessage::ALERT, $subSystem);
	}

	/** -----------------------------------------------------------------------------------------------
	 * add an emergency message
	 * @param type $obj_or_array
	 * @param type $timestamp
	 */
	public function addEmergency($obj_or_array = null, $timestamp = null, string $subSystem=self::DEFAULT_SUBSYSTEM ) : void{
		if (is_array($obj_or_array) and ! empty($obj_or_array[2])) {
			$obj_or_array[2] = AMessage::EMERGENCY;
		}
		$this->add($obj_or_array, $timestamp, AMessage::EMERGENCY, $subSystem);
	}

	/** -----------------------------------------------------------------------------------------------
	 * are there any messages in the queue
	 * @return type
	 */
	public function hasMessages() : bool {
		return (self::$messageQueue->count() > 0);
	}

	/** -----------------------------------------------------------------------------------------------
	 * how many messages are still in the queue
	 * @return type
	 */
	public function stackSize() : int {
		return self::$messageQueue->count();
	}

	/** -----------------------------------------------------------------------------------------------
	 *  give a string with as little formatting as possible
	 *	   if 'Show MessageLog Adds_FileAndLine' is set then there will be the file and line formatted
	 * @return string
	 */
	public function giveUglyMessageQueue() : string {
		$s ='';
		$i =1;
		self::$messageQueue->rewind();
		while(self::$messageQueue->valid()){
			$s .= ' (' . $i++ . ') '. self::$messageQueue->current()->dump(true);
			self::$messageQueue->next();
		}
		self::$messageQueue->rewind();
		return $s;
	}

	/** -----------------------------------------------------------------------------------------------
	 *  pop a message off the stack and return it
	 * @return boolean
	 */
	public function getNextMessage() {
		if (self::$messageQueue->count() > 0) {
			//$temp = array_shift( $this->message_stack);
			$temp = self::$messageQueue->dequeue();
			return $temp;
		} else {
			return false;
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *  show the next item on the stack (causes a get_next_message which will remove it from the stack)
	 * @return boolean
	 */
	public function showNextMessage() {
		$temp = $this->getNextMessage();
		if (!empty($temp)) {
			$temp->show();
			return true;
		} else {
			return false;
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 * show all the messages on the stack (effectivey emptying the stack
	 * @param type $messageText_after_each_line
	 */
	public function showAllMessages($messageText_after_each_line = '<br>') : void {
		while ($temp = $this->showNextMessage()) {
			if (!empty($messageText_after_each_line)) {
				echo $messageText_after_each_line;
			}
		}
	}


	/** -----------------------------------------------------------------------------------------------
	 * show all the messages on the stack (effctivey emptying the stack)
	 *  and do it in a pretty box :-)
	 * @param type $includeFieldSet
	 */
	public function showAllMessagesInBox($includeFieldSet = true) : void{
		if ($includeFieldSet) {
			?><fieldset class="msg_fieldset"><Legend id="message_box_show_all_in_box" class="msg_legend">Messages</legend><?php
				}
				if ($this->hasMessages()) {
					$this->showAllMessages('');
				} else {
					echo '&nbsp;';
				}
				if ($includeFieldSet) {
					?></fieldset><?php
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	public  function TestAllLevels() : void {

		//Settings::SetPublic('Show MessageLog Adds', false);
		//Settings::SetPublic('Show MessageLog Adds_FileAndLine', false);

		$this->setSubSystemLoggingLevel('TESTER_messages', MessageBase::ROCK_BOTTOM_ALL );

		self::$DEFAULTLoggingLevel = MessageBase::ROCK_BOTTOM_ALL;

		foreach(  MessageBase::$levels as $key => $value){

			//echo 'Key= ' , $key, ' value=' , $value;
			//echo '<BR>';

			$this->add( 'This is a test of: ' . $value . ' (' . $key . ')', null, $key, 'TESTER_messages');
			//echo '<BR>';
		}
		if ( ! Settings::GetPublic('Show MessageLog in Footer')) {
			$this->showAllMessagesInBox();
		}
	}



}

/// some usage examples  - now you should use GetRunTimeObject !!!!!!!!!!! so it returns something callable (even if it does nothing)

////include_once(DIR . 'utils' . DS . 'messagelog.class.php');
////$mLog = new MessageLog();
////Settings::SetRunTime('MessageLog', $mLog);

////Settings::GetRunTime('MessageLog')->add( /*'now');
////Settings::GetRunTime('MessageLog')->add( 'now again');
////
////Settings::GetRunTime('MessageLog')->add( 'one more time');
////
////Settings::GetRunTime('MessageLog')->add( array( ' and and some more text DEBUG',null,  MessageBase::DEBUG));
////
////Settings::GetRunTime('MessageLog')->add( array( 'text',null,  MessageBase::ERROR));
////Settings::GetRunTime('MessageLog')->add( array( 'some more text INFO ',null,  MessageBase::INFO));
////Settings::GetRunTime('MessageLog')->add( array( ' and some more text NOTICE',null,  MessageBase::NOTICE));
////Settings::GetRunTime('MessageLog')->add( array( ' and and some more text WARNING',null,  MessageBase::WARNING));
////Settings::GetRunTime('MessageLog')->add( array( ' and and some more text ERROR',null,  MessageBase::ERROR));
////Settings::GetRunTime('MessageLog')->add( array( ' and and some more text CRITICAL',null,  MessageBase::CRITICAL));
////Settings::GetRunTime('MessageLog')->add( array( ' and and some more text ALERT',null,  MessageBase::ALERT));
////
////Settings::GetRunTime('MessageLog')->add( array( ' and and and some more text',null,  MessageBase::EMERGENCY));
////
////Settings::GetRunTime('MessageLog')->addInfo(array('some more text INFO 2', null, MessageBase::EMERGENCY));
////
////Settings::GetRunTime('MessageLog')->addNotice( 'another NOTICE');
////Settings::GetRunTime('MessageLog')->addWarning( 'another WARNING');
////Settings::GetRunTime('MessageLog')->addError(' another ERRROR');
////Settings::GetRunTime('MessageLog')->addCritical( 'another Critical');
////Settings::GetRunTime('MessageLog')->addAlert('another alert');
////Settings::GetRunTime('MessageLog')->addEmergency( 'another emergency');*/
