<?php

namespace MJMphpLibrary;

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


	abstract public function isUserNameRequired(): bool;

	abstract public function isValidPasswordByUserName($userName, $password): bool;

	abstract public function isValidPasswordByUserID($userName, $password): bool;

	abstract public function isAllowedToChangePassword(): bool;

	abstract public function isAllowedToForgetPassword(): bool;

	abstract public function doesUserDetailsContainPassword(): bool;
}
