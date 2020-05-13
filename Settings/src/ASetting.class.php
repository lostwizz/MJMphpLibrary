<?php declare(strict_types=1);

namespace MJMphpLibrary\Settings;

class ASetting {

	/**
	 * @var version string
	 */
	private const VERSION = '0.0.1';


	protected $name;
	protected $data; // the messageText message
	protected $timeStamp;  // time stamp for the message (for displaying the time)

	protected $codeDetails;   //  usually something like: filename(line num)function/method name



	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}

	public function __construct(string $name, $value, string $codeDetails=null) {

		$this->data = $value;
		$this->name = $name;
		$this->timeStamp = (new \DateTime('now'))->getTimestamp();
		$this->codeDetails = $codeDetails ?? '-none-';
	}

	public function getValue( ){
//echo '<pre>';
//print_r( $this);
//echo '))))))))))))';
//print_r( $this->data);
//echo '</php>';

		return $this->data;
	}


}