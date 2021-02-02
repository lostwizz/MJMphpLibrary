<?php

declare(strict_types=1);

/** * ********************************************************************************************
 * Encryption.class.php
 *
 * Summary  utiity functions related to encryption of strings
 *
 * @author mike.merrett@whitehorse.ca
 * @version 0.5.0
 * $Id: c457bfad0f4529402fdaa4a1427add0525fb362f $
 *
 * Description
 * database utilty functions
 *
 *
 *
 * @package Utils
 * @subpackage DBUtils
 * @since 0.3.0
 *
 * @example
 *
 *
 * @todo Description
 *
 *
 * @note:
 *		use \password_hash( $password,
 * 		use \password_verify( $passwordSubmitted, "passwordHash
 */


namespace MJMphpLibrary\Encryption;

define('PHP_MAJOR_MINOR_VERSION', PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION);

/** -----------------------------------------------------------------------------------------------
 *
 */
class Encryption {

	////protected $useBase64 = true;

	protected $encryptionClass;
	protected $encryptionKey;

	/**
	 * @var version number
	 */
	private const VERSION = '0.5.0';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return type
	 */
	public static function Version() {
		return self::VERSION;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $encryptionKey
	 */
	function __construct($encryptionKey) {

		///$this->encryptionKey = $this->pad_key($encryptionKey);
		$this->encryptionKey = openssl_digest($encryptionKey, 'SHA256', TRUE);
		switch (PHP_MAJOR_VERSION) {
			case 5:
				$this->encryptionClass = new v5Encryption($encryptionKey);
				break;
			case 7:
				if (extension_loaded('openssl')) {
					$this->encryptionClass = new v7Encryption($encryptionKey);
				} else {
					throw new Exception('ERROR: Extension SSL is not loaded v7');
				}
				break;
			case 4:
			case 8:
			default:
				throw new Exception('ERROR: unknow php version for encryption');
		}
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $data
	 * @param type $useBase64
	 * @return string
	 */
	public function encrypt($data, $useBase64 = true): string {

		$result = ($this->encryptionClass)->encrypt($data);
		if ($useBase64) {
			return base64_encode($result);
		}
		return $result;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $encyptedData
	 * @return string
	 */
	public function decrypt($encyptedData, $useBase64 = true): string {
		if ($useBase64) {
			$encyptedData = base64_decode($encyptedData);
		}
		$result = (string)($this->encryptionClass)->decrypt($encyptedData);
		return $result;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $key
	 * @return boolean|string
	 */
	protected function pad_key($key) {
		// key is too large
		if (strlen($key) > 32)
			return false;

		// set sizes
		//$sizes = array(16,24,32);
		$sizes = array(24, 32);

		// loop through sizes and pad key
		foreach ($sizes as $s) {
			while (strlen($key) < $s)
				$key = $key . "\0";
			if (strlen($key) == $s)
				break; // finish if the key matches a size
		}
		return $key;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $newCipher
	 * @param type $newMode
	 */
	public function v5_setCipherAndMode($newCipher = MCRYPT_3DES, $newMode = MCRYPT_MODE_ECB) {
		$this->v5_cipher = $newCipher;
		$this->v5_mode	 = $newMode;
		$this->v5_initialize();
	}

}

/** -----------------------------------------------------------------------------------------------
  /** -----------------------------------------------------------------------------------------------
  /** -----------------------------------------------------------------------------------------------
  /** -----------------------------------------------------------------------------------------------
  /** -----------------------------------------------------------------------------------------------
  /** -----------------------------------------------------------------------------------------------
 *
 */
class v5Encryption {

	protected $iv_size;
	protected $iv;
	protected $cipher;
	protected $mode;
	protected $encryptionKey;

	/**
	 * @var version number
	 */
	private const VERSION = '0.5.0';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return type
	 */
	public static function Version() {
		return self::VERSION;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @throws Exception
	 */
	public function __construct() {
		$this->cipher	 = MCRYPT_3DES;
		$this->mode		 = MCRYPT_MODE_ECB;

		if (empty($this->encryptionKey)) {
			throw new Exception('ERROR: Encryption Key Not set');
		}

		$this->iv_size = mcrypt_get_iv_size($this->cipher, $this->mode);
		if (empty($this->iv_size)) {
			throw new Exception('ERROR: v5_iv_size is empty');
		}

		$this->iv = mcrypt_create_iv($this->iv_size, MCRYPT_RAND);
		if (empty($this->iv)) {
			throw new Exception('ERROR: v5_iv is empty');
		}
		$this->encryptionKey = $encryptionKey;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $data
	 * @return string
	 */
	public function encrypt($data): string {
		$result = mcrypt_encrypt(
				$this->cipher,
				$this->encryptionKey,
				$data,
				$this->mode,
				$this->iv
		);
		return $result;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $encyptedData
	 * @return string
	 */
	public function decrypt($encyptedData): string {
		$data = mcrypt_decrypt(
				$this->cipher,
				$this->encryptionKey,
				$encyptedData,
				$this->mode,
				$this->iv_size
		);
		return $data;
	}

}

/** -----------------------------------------------------------------------------------------------
  /** -----------------------------------------------------------------------------------------------
  /** -----------------------------------------------------------------------------------------------
  /** -----------------------------------------------------------------------------------------------
  /** -----------------------------------------------------------------------------------------------
  /** -----------------------------------------------------------------------------------------------
 * openssl_get_cipher_methods()
 *
 */
class v7Encryption {

	protected $cipher;
	protected $options;
	protected $iv_size;
	protected $iv;
	protected $encryptionKey;

	/**
	 * @var version number
	 */
	private const VERSION = '0.5.0';

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return type
	 */
	public static function Version() {
		return self::VERSION;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $encryptionKey
	 */
	public function __construct($encryptionKey) {
		//$this->cipher = 'aes-256-ctr';   //'aes-128-gcm';
		$this->options = 1; //OPENSSL_RAW_DATA ==1 ;

		$this->cipher	 = 'aes-256-ctr';   //'aes-128-gcm';  'aes-256-cbc';

		$this->iv_size	 = openssl_cipher_iv_length($this->cipher);
		$this->iv		 = openssl_random_pseudo_bytes($this->iv_size);

		$this->encryptionKey = $encryptionKey;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $data
	 * @return string
	 */
	public function encrypt($data): string {
		$cipherText = openssl_encrypt($data, $this->cipher, $this->encryptionKey, $this->options, $this->iv);

		// append the iv so that it can be used to decrypt
		$newCipherText = $cipherText . '::' . $this->iv;
		return $newCipherText;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param type $encyptedData
	 * @return string
	 */
	public function decrypt($data): string {

		// get the iv from the encrypted sting (it was appended in the encrypt process
		list($encyptedData, $iv) = explode('::', $data, 2);

		$unEncrypted = openssl_decrypt($encyptedData, $this->cipher, $this->encryptionKey, $this->options, $iv);

		return (string)$unEncrypted;
	}

}
