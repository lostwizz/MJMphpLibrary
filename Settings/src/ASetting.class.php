<?php

declare(strict_types=1);

namespace MJMphpLibrary\Settings;

class ASetting {

	/**
	 * @var version string
	 */
	private const VERSION = '0.0.2';

	const DefaultExpireTimeout = 360;   // how long a setting is good for - seconds

	protected $name;
	protected $data; // the messageText message
	protected $expiredDateTime;  // time stamp for the message (for displaying the time)
	protected $codeDetails;   //  usually something like: filename(line num)function/method name
	protected $isProtectedAfterCreate = false;  // restrict changes after created
	protected $forceExpiry = false;

	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @param string $name
	 * @param type $value
	 * @param string|null $codeDetails
	 * @param \DateTime|null $timeStamp
	 * @param bool $isProtectedAfterCreate
	 */
	public function __construct(string $name,
			$value,
			?string $codeDetails = null,
			?\DateTime $timeStamp = null,
			bool $isProtectedAfterCreate = false,
			?bool $forceExpiry = false
			) {

		$this->data = $value;
		$this->name = $name;
		$this->codeDetails = $codeDetails;
		//$this->timeStamp = $timeStamp ?? (new \DateTime('now'))->getTimestamp();
		//if (defined("IS_PHPUNIT_TESTING")) {
		//	$this->timeStamp =  new \DateTime('00:02:30');
		//} else {
			$this->expiredDateTime = $timeStamp ?? ((new \DateTime('now'))->add( new \DateInterval('PT'  . self::DefaultExpireTimeout .'S')) );
		//}
		$this->isProtectedAfterCreate = $isProtectedAfterCreate;
		$this->forceExpiry = $forceExpiry;


		//$dtInterval = new \DateInterval('PT' . $seconds . 'S');
		//	($this->timeStamp)->add($dtInterval);
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @param string $name
	 */
	public function setName(string $name) {
		if (!$this->isProtectedAfterCreate) {
			$this->name = $name;
		}
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @return string|null
	 */
	public function getName(): ?string {
		if ($this->forceExpiry && $this->hasExpired()) {
			return null;
		}
		return $this->name;
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @param type $value
	 */
	public function setValue($value) {
		if (!$this->isProtectedAfterCreate) {
			$this->data = $value;
		}
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @return type
	 */
	public function getValue() {
		if ($this->forceExpiry && $this->hasExpired()) {
			return null;
		}
		return $this->data;
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @param string|null $details
	 */
	public function setCodeDetails(?string $details = null) {
		if (!$this->isProtectedAfterCreate) {
			$this->codeDetails = $details;
		}
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @return string|null
	 */
	public function getCodeDetails(): ?string {
		if ($this->forceExpiry && $this->hasExpired()) {
			return null;
		}
		return $this->codeDetails;
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @param bool $isNowProtected
	 */
	public function setProtected(bool $isNowProtected = true) {
		$this->isProtectedAfterCreate = $isNowProtected;
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @param bool $forceExp
	 */
	public function setForceExpiry( bool $forceExp) {
		if (!$this->isProtectedAfterCreate) {
			$this->forceExpiry = $forceExp;
		}
	}

	public function getForceExpiry() :bool {
		return $this->forceExpiry;
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @param int $seconds
	 */
	public function extendLife(int $seconds) {
		if (!$this->isProtectedAfterCreate) {
			$seconds = abs($seconds);
			$dtInterval = new \DateInterval('PT' . $seconds . 'S');
			($this->expiredDateTime)->add($dtInterval);
		}
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @param int $seconds
	 */
	public function setTimeStamp( ?\DateTime $timestamp= null) {
		if (!$this->isProtectedAfterCreate) {
			$this->expiredDateTime = $timestamp ?? ((new \DateTime('now'))->add( new \DateInterval('PT'  . self::DefaultExpireTimeout .'S')) );
		}
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @return \DateTime
	 */
	public function getTimeStamp(): \DateTime {
		if ($this->forceExpiry && $this->hasExpired()) {
			return null;
		}
		return $this->expiredDateTime;
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @return bool
	 */
	public function hasExpired(): bool {
		$now = (new \DateTime('now'));
		return ( $now > ($this->expiredDateTime ) );
	}

	/** ----------------------------------------------------------------------------------------------
	 *
	 * @return string
	 */
	public function __toString(): string {
		$expTime = $this->expiredDateTime;
		$diff = $expTime->diff((new \DateTime('now')));

		//$sign = ($expTime->getTimeStamp()) > ((new \DateTime('now'))->getTimestamp());
		$sign = ($expTime) > (new \DateTime('now'));
		$s = $this->name
				. '==>'
				. $this->data
				. ' ['
				. ($this->isProtectedAfterCreate ? 'P' : 'NP')
				. ($this->forceExpiry ? 'ForceExpiry': '')
				. ($this->codeDetails ?? '')
				. ', '
				. ($sign ? 'Expires in:' : 'Expired: +')
				. $diff->format("%H:%I:%S")		// %Y-%m-%d
				. ']'
		;
		return $s;
	}

}
