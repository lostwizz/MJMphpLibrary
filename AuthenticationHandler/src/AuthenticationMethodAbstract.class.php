<?php declare(strict_types=1);

namespace MJMphpLibrary\AuthenticationHandler;



abstract class AuthenticationMethodAbstract {


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


	//abstract public function isUserNameRequired(): bool;

	abstract public function isValidPassword(string $string1, ?string $string2 ): bool;

	abstract public function preSaveProcessPassword( string $password ) : ?string;
	//abstract public function isValidPasswordByUserID( int $userID, $password): bool;

	abstract public function isAllowedToChangePassword(): bool;

	abstract public function isAllowedToForgetPassword(): bool;

	abstract public function doesUserDetailsContainPassword(): bool;
}
