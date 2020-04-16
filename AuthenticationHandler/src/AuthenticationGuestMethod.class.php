<?php

namespace MJMphpLibrary;


class AuthenticationGuestMethod extends AuthenticationMethodAbstract {
	public function isUserNameRequired(): bool{
		return true;
	}
	protected function isValidPasswordByUserName( $userName, $password) : bool{

	}
	protected function isValidPasswordByUserID( $userName, $password) : bool{

	}
	protected function isAllowedToChangePassword() : bool{
		return false;
	}
	protected function isAllowedToForgetPassword() : bool{
		return false;
	}
	protected function doesUserDetailsContainPassword() : bool{
		return false;
	}

}