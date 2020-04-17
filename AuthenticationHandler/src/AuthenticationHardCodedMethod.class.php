<?php

namespace MJMphpLibrary;


class AuthenticationHardCodedMethod extends AuthenticationMethodAbstract {
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
		return false;
	}
	public function isAllowedToForgetPassword() : bool{
		return false;
	}
	public function doesUserDetailsContainPassword() : bool{
		return false;
	}

}