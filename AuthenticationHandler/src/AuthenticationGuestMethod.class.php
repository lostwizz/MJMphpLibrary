<?php

namespace MJMphpLibrary;


class AuthenticationGuestMethod extends AuthenticationMethodAbstract {

	/**
	 * @var version string
	 */
	private const VERSION = '0.0.3';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}


	public function isUserNameRequired(): bool{
		return true;
	}
	public function isValidPasswordByUserName( $userName, $password) : bool{

	}
	public function isValidPasswordByUserID( $userName, $password) : bool{

	}
	public function isAllowedToChangePassword() : bool{
		return false;
	}
	public function isAllowedToForgetPassword() : bool{
		return false;
	}
	public function doesUserDetailsContainPassword() : bool{
		return false;
	}

}