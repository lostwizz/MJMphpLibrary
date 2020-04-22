<?php declare(strict_types=1);

namespace MJMphpLibrary;

class AuthenticationLDAPmethod extends AuthenticationMethodAbstract {

	private $Domain = 'city.local';
	private $DomainPrefix = 'city\\';

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
	public function isValidPassword( string $username, ?string $password): bool {
		return $this->LDAPfun($username, $password);
	}

	public function preSaveProcessPassword( string $password ) : ?string {
		return null;
	}
//	public function isValidPasswordByUserID($userName, $password): bool {
//		return false;
//	}

	public function isAllowedToChangePassword(): bool {
		return false;
	}

	public function isAllowedToForgetPassword(): bool {
		return false;
	}

	public function doesUserDetailsContainPassword(): bool {
		return false;
	}

	public function LDAPfun( $username, $password) : bool {
		if (!extension_loaded('LDAP')) {
			return false;   ///new Response('LDAP not loaded in PHP - cant login ', -22);
		}
		try {
			$ldap_conn = @\ldap_connect($this->Domain);
			if (!$ldap_conn) {
				return false;
			}

			$user_connect = @\ldap_bind($ldap_conn, $this->DomainPrefix . $username, $password);
			if (!$user_connect) {
				return false; //Response::GenericError();
			}

			if (self::startsWith(strtolower($username), 'admin')) {
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
		return true;
	}


		/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $string
	 * @param type $startString
	 * @return bool
	 */
	public static function startsWith (string $string, string $startString, bool $ignoreCase = false) :bool {
		$len = strlen($startString);
		if ($len <1) {
			return false;
		}
		if ( $ignoreCase){
			return (substr(strtolower($string), 0, $len) == strtolower($startString));
		} else {
			return (substr($string, 0, $len) == $startString);
		}
	}


}
