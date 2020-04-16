<?php

namespace MJMphpLibrary;

abstract class AuthenticationMethodAbstract {

	abstract public function isUserNameRequired(): bool;

	abstract protected function isValidPasswordByUserName($userName, $password): bool;

	abstract protected function isValidPasswordByUserID($userName, $password): bool;

	abstract protected function isAllowedToChangePassword(): bool;

	abstract protected function isAllowedToForgetPassword(): bool;

	abstract protected function doesUserDetailsContainPassword(): bool;
}
