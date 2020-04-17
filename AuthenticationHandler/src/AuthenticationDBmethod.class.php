<?php

namespace MJMphpLibrary;


class AuthenticationDBmethod extends AuthenticationMethodAbstract {

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
//
//	public function isUserNameRequired(): bool{
//		return true;
//	}

	public function isValidPassword( string $passwordSubmitted, ?string $passwordHashFromDB) : bool{
		return (\password_verify($passwordSubmitted, $passwordHashFromDB)) ;
	}

	public function preSaveProcessPassword( string $password ) : ?string {
		return password_hash( $password, PASSWORD_DEFAULT);
	}

//	public function isValidPasswordByUserID( $userName, $password) : bool{
//	}

	public function isAllowedToChangePassword() : bool{
		return true;
	}
	public function isAllowedToForgetPassword() : bool{
		return true;
	}
	public function doesUserDetailsContainPassword() : bool{
		return true;
	}

}