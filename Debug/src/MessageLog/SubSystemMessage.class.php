<?php
declare(strict_types=1);


namespace MJMphpLibrary\Debug\MessageLog;

//***********************************************************************************************
//***********************************************************************************************

//***********************************************************************************************
//***********************************************************************************************
//
//***********************************************************************************************
//***********************************************************************************************
class SubSystemMessage {
	PUBLIC $subSystem;

	public static $isSuspended = false;
	public static $suspended_SubSystem ='';

	/**
	 * @var version number
	 */
	private const VERSION = '0.0.1';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return type
	 */
	public static function Version() : string{
		return self::VERSION;
	}

	/** -----------------------------------------------------------------------------------------------**/
	function __construct(string $passedSubSystem = MessageLog::DEFAULT_SUBSYSTEM , int $lvl = -9999 ) {  // AMessage::NOTICE){

		if ( $lvl == -9999  or $lvl ==0) {
			$lvl = Settings::getPublic('IS_DETAILED_DEFAULT_NOTIFICATION_LEVEL');       ///MessageLog::$DEFAULTLoggingLevel;
		}
		$this->subSystem = $passedSubSystem;
		Settings::GetRunTimeObject('MessageLog') -> setSubSystemLoggingLevel( $passedSubSystem, $lvl );
	}

	/** -----------------------------------------------------------------------------------------------**/
	public function isNotANullableClass() : bool {
		return true;
	}

	/** -----------------------------------------------------------------------------------------------**/
	public function isGoodLevelsAndSystem( $level = AMessage::NOTICE){
		return MessageLog::isGoodLevelsAndSystem( $level, $this->subSystem);
	}

	/** -----------------------------------------------------------------------------------------------
	 * if the name is something like      addNotice_2 - note the _2 (_33 would break this
	 *          and between the two is the level
	 * @param type $name
	 * @param type $args
	 * @return void
	 */
	public function __call($name, $args) : void{
		if ( substr( $name,-2,1 ) == '_'  and substr($name, 0,3) == 'add') {   //ends in _x and starts with add
			$new_lvl_name = strtoupper(substr($name, 3));
			$lvl_num = array_search($new_lvl_name, MessageBase::$levels);

			if ( ! self::$isSuspended) {
				Settings::GetRunTimeObject('MessageLog') -> add( $args[0], null, $lvl_num, $this->subSystem);
			}
		} else if ( $name == 'Suspend'){
			self::$isSuspended = true;
			Settings::GetRunTimeObject('MessageLog') -> add( 'Suspended MSG Log', null, LVL_DEBUG, $this->subSystem);
		} else if ( $name == 'Resume'){
			Settings::GetRunTimeObject('MessageLog') -> add( 'Resumed MSG Log', null, LVL_DEBUG, $this->subSystem);
			self::$isSuspended = false;
		} else {
			if ( ! self::$isSuspended) {
				Settings::GetRunTimeObject('MessageLog') -> $name(  $args[0], null, $this->subSystem );
			}
		}
	}

}
