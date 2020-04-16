<?php

namespace MJMphpLibrary;

class AuthenticationLDAPmethod extends AuthenticationMethodAbstract {

	private $Domain = 'city.local';
	private $DomainPrefix = 'city\\';

	public function isUserNameRequired(): bool{
		return true;
	}
	protected function isValidPasswordByUserName($userName, $password): bool {
		return $this->LDAPfun($username, $password);
	}

	protected function isValidPasswordByUserID($userName, $password): bool {
		return false;
	}

	protected function isAllowedToChangePassword(): bool {
		return false;
	}

	protected function isAllowedToForgetPassword(): bool {
		return false;
	}

	protected function doesUserDetailsContainPassword(): bool {
		return false;
	}

	protected function LDAPfun( $username, $password) {
		if (!extension_loaded('LDAP')) {
			return false;   ///new Response('LDAP not loaded in PHP - cant login ', -22);
		}
		try {
			$ldap_conn = @\ldap_connect($this->Domain);
			if (!$ldap_conn) {
				return Response::GenericError();
			}

			$user_connect = @\ldap_bind($ldap_conn, $this->DomainPrefix . $username, $password);
			if (!$user_connect) {
				return false; //Response::GenericError();
			}

			if (Utils::startsWith(strtolower($username), 'admin')) {
				$dn = "OU=Admins,DC=CITY,DC=local";
			} else {
				$dn = "OU=City Users,DC=CITY,DC=local";
			}
			$attributes = array("sn", "givenname", "mail", "telephonenumber", "cn", "title", "department", "mobile");
			///////, "memberOf");

			$result = @\ldap_search($ldap_conn, $dn, "sAMAccountname=" . $username, $attributes);
			if (!$result) {
				return false;
			}

			$entries = @\ldap_get_entries($ldap_conn, $result);
			if (!$entries or empty($entries['count']) or $entries['count'] !== 1) {
				return false;
			}
			@\ldap_close($ldap_conn);
		} catch (\Exception $ex) {
			return false;
		}
	}

}
