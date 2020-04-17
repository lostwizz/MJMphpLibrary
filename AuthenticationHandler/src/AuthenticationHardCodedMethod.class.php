<?php

namespace MJMphpLibrary;


class AuthenticationHardCodedMethod extends AuthenticationMethodAbstract {
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