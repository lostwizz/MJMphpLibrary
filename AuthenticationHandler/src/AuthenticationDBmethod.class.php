<?php

namespace MJMphpLibrary;


class AuthenticationDBmethod extends AuthenticationMethodAbstract {
	public function isUserNameRequired(): bool{
		return true;
	}

	protected function isValidPasswordByUserName( $userName, $password) : bool{

	}
	protected function isValidPasswordByUserID( $userName, $password) : bool{

	}
	protected function isAllowedToChangePassword() : bool{
		return true;
	}
	protected function isAllowedToForgetPassword() : bool{
		return true;
	}
	protected function doesUserDetailsContainPassword() : bool{
		return true;
	}

}