<?php  declare(strict_types=1);

namespace MJMphpLibrary;

use MJMphpLibrary\HTML;
require_once( 'P:\Projects\_PHP_Code\MJMphpLibrary\HTML\src\HTML.class.php');


class Display_AuthenticationHandler {
	/**
	 * @var version string
	 */
	private const VERSION = '0.0.1';



	private const unSize = 30;
	private const unMaxLen =30;
	private const unMinLen =1;

	private const pwdSize = 30;
	private const pwdMaxLen = 100;
	private const pwdMinLen = 1;


	private string $app = 'Unknown App';
	private bool $showChangePwd =false;
	private bool $showAddAcct = false;
	private bool $showForgotPwd = true;










	/** -----------------------------------------------------------------------------------------------
	 * gives a version number
	 * @static
	 * @return string
	 */
	public static function Version(): string {
		return self::VERSION;
	}


	/** -----------------------------------------------------------------------------------------------
	 *
	 * @param string $appName
	 * @param bool $showChangePassword
	 * @param bool $showAddAcct
	 * @param bool $ShowForgotPassword
	 */
	public function __construct( string $appName,
								bool $showChangePassword = false,
								bool $showAddAcct = false,
								bool $ShowForgotPassword = false) {
		$this->app = $appName;
		$this->showChangePwd = $ShowForgotPassword;
		$this->showAddAcct = $showAddAcct;
		$this->showForgotPwd = $ShowForgotPassword;
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function showLoginPage() {
		echo HTML::FormOpen('index.php',
				'LoginForm',
				'POST',
				null,
				NULL,
				NULL
				);
		echo '<center>';
		echo 'Logon Form for ', $this->app;
		echo '</center>';
		$this->showLoginBox();
		echo HTML::FormClose();
	}

	/** -----------------------------------------------------------------------------------------------
	 *
	 * @return void
	 */
	private function showLoginBox(): void {

		$bottomLineSpan = 3 -($this->showChangePwd ? 1:0) + ($this->showAddAcct ? 1:0) +($this->showForgotPwd ? 1:0 );

		?>
		<table border=1 align=center>
			<tr>
				<td>Username: </td>
				<td colspan=2><?php echo HTML::Text('REQUEST_PAYLOAD' . '[entered_username]',
												null,
						array('maxlength' => self::unMaxLen,
							'minlength'=> self::unMinLen,
							'size' => self::unSize,
							'required',
							'placeholder'=>'User Name'
							)); ?></td>
			</tr><tr>
				<td>Password: </td>
				<td colspan=2><?php echo HTML::Password('REQUEST_PAYLOAD' . '[entered_password]',
										null,
						array('maxlength' => self::pwdMaxLen,
							'minlength' => self::pwdMinLen,
							'size' => self::pwdSize,
							'required',
							'placeholder' =>'Password'
							)); ?>
					</td></tr><tr>
				<td align=center colspan=3><?php echo HTML::Submit('REQUEST_ACTION', 'Submit Logon'); ?></td>
			</tr><tr align=center>
				<?php
					if (  $this->showChangePwd){
						echo HTML::Open('TD');
						echo HTML::Submit('REQUEST_ACTION', 'Change Password');
					} else {
						echo HTML::Open('TD');
						echo HTML::Space( 20);
					}
					echo HTML::Close('TD');

					if ($this->showAddAcct){
						echo HTML::Open('TD');
						echo HTML::Submit('REQUEST_ACTION', 'Add New Account');
					} else {
						echo HTML::Open('TD');
						echo HTML::Space( 20);
					}
					echo HTML::Close('TD');

					if ( $this->showForgotPwd) {
					echo HTML::Open('TD');
						echo HTML::Submit('REQUEST_ACTION', 'Forgot Password');
					} else {
						echo HTML::Open('TD');
						echo HTML::Space( 20);
					}
					echo HTML::Close('TD');
				?>
			</tr>
		</table>
		<?php
	}


	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function showSignup(){
		}
	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function showForgotPassword() {
	}
	/** -----------------------------------------------------------------------------------------------
	 *
	 */
	public function showChangePassword(){
	}


}