<?php

namespace MJMphpLibrary;


class AuthenticationGuestMethod extends AuthenticationMethodAbstract {

	/**
	 * @var version string
	 */
	private const VERSION = '0.0.1';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}


//	public function isUserNameRequired(): bool{
//		return true;
//	}
	public function isValidPassword( string $userName, ?string $password) : bool{
		return ( strtolower($userName) == 'guest')  && ( empty($password));
	}
	public function preSaveProcessPassword( string $password ) : ?string {
		return null;
	}
//	public function isValidPasswordByUserID( $userName, $password) : bool{
//	}
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