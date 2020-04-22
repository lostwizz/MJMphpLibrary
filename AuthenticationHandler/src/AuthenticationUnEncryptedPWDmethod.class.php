<?php  declare(strict_types=1);

namespace MJMphpLibrary;


class AuthenticationUnEncryptedPWDmethod extends AuthenticationMethodAbstract {

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

	public function isValidPassword( string $passwordSubmitted, ?string $passwordFromDB) : bool{
		return ($passwordSubmitted == $passwordFromDB);
	}
	public function preSaveProcessPassword( string $password ) : ?string {
		return $password;
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