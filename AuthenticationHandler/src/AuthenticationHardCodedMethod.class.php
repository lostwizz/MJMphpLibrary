<?php declare(strict_types=1);

namespace MJMphpLibrary\AuthenticationHandler;

class AuthenticationHardCodedMethod extends AuthenticationMethodAbstract {
//	public function isUserNameRequired(): bool{
//		return true;
//	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $passwordSubmitted
	 * @param string|null $passwordHashFromDB
	 * @return bool
	 */
	public function isValidPassword( string $passwordSubmitted, ?string $passwordHashFromDB) : bool{
		return (\password_verify($passwordSubmitted, $passwordHashFromDB)) ;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $password
	 * @return string|null
	 */
	public function preSaveProcessPassword( string $password ) : ?string {
		return password_hash( $password, PASSWORD_DEFAULT);
	}

//	public function isValidPasswordByUserID( $userName, $password) : bool{
//	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return bool
	 */
	public function isAllowedToChangePassword() : bool{
		return false;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return bool
	 */
	public function isAllowedToForgetPassword() : bool{
		return false;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return bool
	 */
	public function doesUserDetailsContainPassword() : bool{
		return false;
	}

}