<?php
//**********************************************************************************************
//* UserErrorHandler.inc.php
//*
//* Version: 2.001
//*
//* $Id: UserErrorHandler.inc.php 389 2009-02-11 19:07:14Z merrem $
//* $Rev: 389 $
//* $Date: 2009-02-11 11:07:14 -0800 (Wed, 11 Feb 2009) $
//*
//*
//* 30Apr04 M.Merrett -
//*  4jun04 M.Merrett - added getting error messages from database drivers(oci,mysql,odbc)
//*  2dec04 M.Merrett - added summary of back trace for easy viewing
//*					 	 - added IS_DEBUGGING constant  and the config file
//* 15dec04 M.Merrett - changed default_define
//*  4feb05 M.Merrett - added code to try and capture oracle "warnings"
//* 14feb05 M.Merrett - added sending the error codes to the "$log" file
//* 18sep06 M.Merrett - added functions for "watching variables" and detailed process tracing
//* 17jul07 M.Merrett - added support for set_exception_handler
//*  7aug07 M.Merrett - added more backtrace options
//* 13aug07 M.Merrett - fixed minor error if running the script localy
//* 17jan08 mjm - fixed if errno is not in errortype array
// 24jan08 M.Merrett - dump() -added code to make the output it a scroll window if more than 15 lines long
//
//* TODO:
//			When you think you got things working try putting these in the php.ini file
//			php_flag display_errors on
//			php_flag output_buffering on
//			php_value output_handler output_handler
//			php_value auto_prepend_file prepend .php
//*
//***********************************************************************************************

// use a config file to set the debugging on or off
if ( file_exists( "config.inc.php")){
	require_once( "config.inc.php");
}

require_once('myUtils.inc.php');

default_define ( 'IS_DEBUGGING', TRUE);


default_define('USER_ERROR_SHOW_BACKTRACE', true);
default_define('USER_ERROR_SUPPRESS_MSGS', !IS_DEBUGGING );  //FALSE
default_define('USER_ERROR_SEND_EMAIL', !IS_DEBUGGING);   //FALSE
default_define('USER_ERROR_RECORD_EVENT_LOG', false);
default_define('USER_ERROR_SUPPRESS_NON_CRITICAL', !IS_DEBUGGING);  //FALSE
default_define('USER_ERROR_ABORT_ON_NON_CRITICAL', false);
default_define('USER_ERROR_SHOW_REQUESTS', true);
default_define('USER_ERROR_SHOW_SESSION', true);
default_define('USER_ERROR_SHOW_FILES', true);
default_define('USER_ERROR_SHOW_SERVER', true);

default_define('USER_ERROR_SHOW_USERMANAGER_INFO', TRUE);

default_define('USER_ERROR_EMAIL_ADDR', "mike.merrett@city.whitehorse.yk.ca");
default_define('USER_ERROR_EMAIL_SUBJECT', "ERROR: Service_Cards2 -Production - error trapper");


default_define('USER_ERROR_HAS_BEEN_NOTIFIED', "The Web administrator");


// some defines on what shows in the dump
default_define( 'DUMP_CALC_VAR_NAME', true);
default_define( 'DUMP_SHOW_FILE_AND_LINE', true);
default_define( 'DUMP_SHOW_LINES_BEFORE_AND_AFTER', false);
default_define( 'DUMP_SP', ',null,null,null,null,null,true');

//***********************************************************************************************
//   these lines get run as soon as you do the requrie_once thing
//***********************************************************************************************
if ( IS_DEBUGGING) {
	ini_set( "display_startup_errors", true);
	/////error_reporting( E_ALL );
//	error_reporting( E_ALL | E_STRICT );

	$x =error_reporting( 0xFFFFFFF  );
	//dump( dechex($x));
	//dump( dechex(error_reporting()) );
} else {
	//error_reporting( E_ERROR ^ E_NOTICE );
	$x = error_reporting( 0xFFFFFFF ^ E_NOTICE );



}

set_error_handler('UserErrorHandler');

set_error_handler('UserErrorHandler');

//***********************************************************************************************


//***********************************************************************************************
function exception_handler($e) {
//dump( $e, 'at exception_handler');
	UserErrorHandler( $e->getCode(),
							$e->getMessage(),					//
							$e->getFile(),
							$e->getLine(),
							$e->getTrace()
						);
}

set_exception_handler('exception_handler');



//***********************************************************************************************
//***********************************************************************************************
function UserErrorHandler($errno, $errstr, $errfile, $errline, $alternate_bt=null) {
//dump( $errstr);

	if (! IS_DEBUGGING) {
		echo '</span>';
		echo '<script>document.getElementById("please_wait").style.display ="none";</script>';
		echo '<script>document.getElementById("screen").style.display ="inline";</script>';
	}

	// define an assoc array of error string
	// in reality the only entries we should
	// consider are 2,8,256,512 and 1024
	$errortype = array (
	               1   =>  "Error",
	               2   =>  "Warning",
	               4   =>  "Parsing Error",
	               8   =>  "Notice",
	               16  =>  "Core Error",
	               32  =>  "Core Warning",
	               64  =>  "Compile Error",
	               128 =>  "Compile Warning",
	               256 =>  "User Error",
	               512 =>  "User Warning",
	               1024=>  "User Notice",
						6143=>  "ALL",
	               2048=>  "Strict",
	               4096=> "Recoverable error"
	               );

	global $log;
	if ( !empty ($log)) {
		$log->log( '-----------ERROR-----------');
		$s = 'ErrorNo:';
		$s .= empty($errno) ? '' : $errno;
		$s .= ' - ';
		$s .= empty($errortype[$errno]) ? '' : $errortype[$errno];
		$log->log( $s);
		//$log->log( 'ErrorNo:' . empty($errno) ? '':$errno .' - ' . empty($errortype[$errno]) ? '' :$errortype[$errno] );
		$log->log( 'ErrorStr:'. $errstr);
		$log->log( 'ErrorFile:' . $errfile);
		$log->log( 'ErrorLine:' . $errline);
		///$log->log( debug_backtrace());
	}

	// only show those errors which are important
	//        - hey guess what Warnings from oracle are important
	if ( strpos( $errstr, 'ociexecute') ===false) {
		//$non_report_errors = array( E_NOTICE, E_WARNING);
//		$non_report_errors = array( E_NOTICE);
		$non_report_errors = array( );
		$dont_die= false;
	} else {
		$non_report_errors = array( E_NOTICE);
		$dont_die = true;
	}

	if ( !in_array($errno, $non_report_errors) ) {

// 17jan08 mjm - fixed if errno is not in errortype array
// 25feb08 mjm - fixed the fix (moved the trinary test out of the string
		$e =  empty($errortype[$errno]) ? ' _unknown error type_ ' : $errortype[$errno] ;
		$error_text = "<B> -*-*-*- A error has been caught. -*-*-*-\n"
					. "Date: " . date("F j, Y, g:ia") . "\n"
					. "Error #: (" . $errno. ") "  . $e . '  -  ' . $errstr . "\n"
					. "File: " . $errfile . "\n"
					. "Line: " . $errline . "\n</b>";
		$error_text .= " - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - \n\n" ;

	   if ( function_exists('ms_GetErrorObj')) {
		 	$ms_errors_string = userErrors_MapServerError();
//		 	if ( ! empty( trim($ms_errors_string))) {
	   		$error_text .= " [[ Map Server Error String ==>\n";
	   		$error_text .= trim($ms_errors_string);
				$error_text .= "]]\n - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - \n\n" ;
//			}
	   }

		// get any database errors messages (oracle, mysql and odbc)
		$error_text .= trim( userErrors_OCIError());
		$error_text .= trim( userErrors_MYSQLError());
		$error_text .= trim( userErrors_ODBCError());

		IF (USER_ERROR_SHOW_BACKTRACE) {
			$error_text .= "\n\n[[Back Trace==>\n" ;
			$bt = debug_backtrace();
			foreach( $bt as $bt_func) {
				if ( ! empty(  $bt_func['file'] )) {
					$error_text  .=  "<b>" . $bt_func['file'] . "</b>"
										. ":" . $bt_func['line']
										. "&nbsp;&nbsp;&nbsp;("
										;
				}
				$error_text  .= $bt_func['function']
									. ')'

									;
				if ( ! empty(  $bt_func['class'] )) {
					$error_text  .=  "&nbsp;&nbsp;&nbsp; Class :" . $bt_func['class'];/// . "&nbsp;&nbsp;&nbsp;";
				}
//				if ( ! empty(  $bt_func['object'] )) {
//					$error_text  .=  " Object :" . $bt_func['object'] . "&nbsp;&nbsp;&nbsp;";
//				}
//				if ( ! empty(  $bt_func['type'] )) {
//					$error_text  .=  " Type :" . $bt_func['type'] . "&nbsp;&nbsp;&nbsp;";
//				}
//				if ( ! empty(  $bt_func['args'] )) {
//					$error_text  .=  " Args :" . str_replace( ' ',  "&nbsp;",print_r($bt_func['object'], true));
//				}

			$error_text .= "\n";

			}
			$to_be_exported= print_r( $bt, true);
//13nov08 mjm
//			$to_be_exported= var_export( $bt, true);
			$x = str_replace( ' ',  "&nbsp;",$to_be_exported);
			$error_text .= $x . "]]\n";
			$error_text .= " - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - \n\n" ;
		}

		if (USER_ERROR_SHOW_REQUESTS) {
			$x = print_r( $_REQUEST, true);
//13nov08 mjm
//			$x = var_export( $_REQUEST, true);
			$x = str_replace( ' ',  "&nbsp;",$x);
			$error_text .= "\n\n " . '$_REQUEST ==>' . $x ;
			$error_text .= " - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - \n\n" ;
		}
		if (USER_ERROR_SHOW_SESSION and !empty($_SESSION)) {
			$x = print_r( $_SESSION, true);
//13nov08 mjm
//			$x = var_export( $_SESSION, true);
			$x = str_replace( ' ',  "&nbsp;",$x);
			$error_text .= "\n\n " . '$_SESSION ==>' . $x ;
			$error_text .= " - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - \n\n" ;
		}

		if (USER_ERROR_SHOW_FILES) {
			$x = print_r( $_FILES , true);
//13nov08 mjm
//			$x = var_export( $_FILES , true);
			$x = str_replace( ' ',  "&nbsp;",$x);
			$error_text .= "\n\n " . '$_FILES ==>' . $x ;
			$error_text .= " - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - \n\n" ;
		}

		if (USER_ERROR_SHOW_USERMANAGER_INFO) {
			global $usermanager;
			if ( ! empty( $usermanager)) {
				$x = " Logged on As: " . $usermanager->who_is_logged_on();
				$x .= "\n\n";
				$x .= print_r( $usermanager, true);
// 13nov08
//				$x .= var_export( $usermanager, true);
				$x = str_replace( ' ',  "&nbsp;",$x);

				$error_text .= "\n\n " . '$usermanager ==>' . $x ;
				$error_text .= " - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - \n\n" ;
			}
		}

		if (USER_ERROR_SHOW_SERVER) {
			$x = print_r( $_SERVER , true);
//13nov08 mjm
//			$x = var_export( $_SERVER , true);
			$x = str_replace( ' ',  "&nbsp;",$x);
			$error_text .= "\n\n " . '$_SERVER ==>' . $x ;
			$error_text .= " - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - \n\n" ;
		}



		if (USER_ERROR_SEND_EMAIL) {
			// send an email
			//$x = ini_set( "SMTP" , "10.3.1.13");
			$x = ini_set( "sendmail_from" , "eservices@city.whitehorse.yk.ca");
			//@error_log(html_entity_decode($error_text), 1, USER_ERROR_EMAIL_ADDR,  USER_ERROR_EMAIL_SUBJECT);
			$headers = "From: " .USER_ERROR_EMAIL_ADDR . "\r\n";
			$headers .= "Reply-To: ". USER_ERROR_EMAIL_ADDR. "\r\n";
			$headers .= "X-Mailer: PHP/" . phpversion() ."\r\n"
			  				."MIME-Version: 1.0\r\n"
		   				."Content-type: text/html\r\n" ;       // ; charset=iso-8859-l\n";

			$rr = mail ( USER_ERROR_EMAIL_ADDR ,
					USER_ERROR_EMAIL_SUBJECT,
					nl2br(html_entity_decode($error_text)),
					$headers);

		}

		if (USER_ERROR_RECORD_EVENT_LOG) {
			// log it to the event log
			@error_log($error_text, 0);
		}

		if ( USER_ERROR_SUPPRESS_MSGS ) {
			// assuming hiding to user then just say blowup happend but no details
			//echo "The web site is not available at this time.  Please try again soon.";
			echo '<hr><Br>';
			echo "An Error has occured.\n<BR>";
			echo "Error #: (" . $errno. ") "  . $e . '  -  ' . $errstr . "\n" . '<BR>';
			echo "<br>";
			echo USER_ERROR_HAS_BEEN_NOTIFIED, " - has been notified of this error";
			echo "<br>";
			echo "<br>";
			echo "Please use the`Back button` to go back a page";
		} else  {
			echo "<hr color=red size=9><font color=red>";
			echo nl2br($error_text);
	   	echo "</font><hr color=red size=9>";
	   }
	   if ( !$dont_die) {
	   	exit(1);
	   }
	} else {
		// on the non critical errors (such as notices) dont abort
		if ( USER_ERROR_SUPPRESS_NON_CRITICAL) {
		} else {
			echo $errortype[$errno] ." : (" . $errno. ") "  .  "  -  " . $errstr . " in " . "File: " . $errfile . "(" . $errline .")<br>";
			//dump( $errortype, null,null,null,null,null,true);
		}
		if (USER_ERROR_ABORT_ON_NON_CRITICAL) {
			exit (2);
		}
	}
}

//***********************************************************************************************
//***********************************************************************************************
function userErrors_MapServerError() {

	$ms_err_msg ="";
	$ms_error = ms_GetErrorObj();

	while($ms_error && $ms_error->code != MS_NOERR)
	{
	    $ms_err_msg  .= "MapServer Error in :" . $ms_error->routine . " " .  $ms_error->message ."\n";
	    $ms_error = $ms_error->next();
	}
	return $ms_err_msg;
}


//***********************************************************************************************
//***********************************************************************************************
function userErrors_OCIError(){
	if (function_exists( 'oci_error')  ) {
		$x = oci_error();
		if ( !empty($x)) {
			return 'OCI: <b>' . oci_error() . "</b>\n";
		} else {
			return '';
		}
	} else {
		return '';
	}
}

//***********************************************************************************************
//***********************************************************************************************
function userErrors_ODBCError(){
	if (function_exists('odbc_error')) {
		if (odbc_error()) {
			return 'ODBC: '. odbc_error() . ": <b>" . odbc_errormsg() . "</b>\n";
		} else {
			return '';
		}
	} else {
		return '';
	}
}

//***********************************************************************************************
//***********************************************************************************************
function userErrors_MYSQLError(){
	if ( function_exists('mysql_error')) {
		if ( mysql_errno()) {
			return 'MySQL: '. mysql_errno() . ": <b>" . mysql_error() . "</b>\n";
		} else {
			return '';
		}
} else {
		return '';
	}
}



//***********************************************************************************************
// dump ( $var, [$title], [$title2], [$title3])
//		- print out the title and then the print_r of a string - in a block of color to stand out a bit
//		- things should also appear formatted
//		- the title is optional
//usage:
//	dump( $anyvar);
//	dump( $anyvar, "this is a heading");
//	dump( $anyvar, "this is a heading", "this is another heading");
//	dump( $anyvar, "this is a heading", "this is another heading", "this is yet another heading");
//
// 01oct04 M.Merrett
// 22dec04 M.Merrett - added wordwrap and more parameters with color
//							- added file name and line number - added parsing to get variable name (wont work on strings that have a comma)
// 24oct04 M.Merrett - moved the => down to the output of the var
//							- wordwrap on the output of the variable ( to try and keep it on the same screen with shifting)
//							- added $s4 and $s5
//  1dec05 M.Merrett - added option to show the back trace
// 21dec05 M.Merrett - added the parameters to the function whne showing backtrace
//							- changed default to dump the backtrace and  added dumpNB which would not show the backtrace
// 08may06 M.Merrett - added some \n's before and after (to help delinieate the source)
// 24jan08 M.Merrett - added code to make the output it a scroll window if more than 15 lines long
//
// TODO:
//		- makeing the output of print_r into coloumns? (instead of a line foreach value)
//
//***********************************************************************************************

define( 'MODIFIER_TO_HEX', 1);
define( 'MODIFIER_TO_ENCODE', 2);
define( 'DUMP_MAX_LINES_BEFORE_SCROLL', 20);

//***********************************************************************************************
function show_bt(){
	dump( null,null,null,null,null,null,true);
}

//***********************************************************************************************
function dumpNB( $obj, $title ='', $s2='', $s3='', $s4='', $s5='', $show_back_trace=true) {
	dump( $obj, $title, $s2, $s3, $s4, $s5, false);
}

//***********************************************************************************************
function dump($obj, $title ='', $s2='', $s3='', $s4='', $s5='', $show_back_trace=false, $display_modifier=null) {

//	if ( substr_count(  print_r($obj, true), "\n") >DUMP_MAX_LINES_BEFORE_SCROLL) {			//if many lines then wrap it in a scroll box
//13nov08 mjm
	if ( substr_count(  var_export($obj, true), "\n") >DUMP_MAX_LINES_BEFORE_SCROLL) {			//if many lines then wrap it in a scroll box
		echo "\n\n",'<pre style="background-color: #FFFDCC; border: 1px solid #d7d7d7;
 /*margin: 1em 1.75em;*/
 /*padding: .25em;*/
 overflow: auto;
 height: '. DUMP_MAX_LINES_BEFORE_SCROLL .'em;
 width: 100%; ">';
	} else {
		echo "\n\n",'<pre style="background-color: #FFFDCC">';
	}

	// use the back trace to figure out some things ( but grab it early so it is not contaminated
	if ( DUMP_CALC_VAR_NAME or DUMP_SHOW_LINES_BEFORE_AND_AFTER or DUMP_SHOW_FILE_AND_LINE or $show_back_trace) {
		$bt = debug_backtrace();
	}

	// decode the dump( $x) line amd show it
	if ( DUMP_CALC_VAR_NAME) {
		$the_line = get_file_line_at_line_num( $bt[0]['file'], $bt[0]['line']);

		echo  '<font style="fine-size: large; background-color: #7DEEA2; foreground-color: #FFFFFF">';
		echo get_var_from_dump_line( $the_line);
		//echo " ==>";
		echo "</font>";
		echo "<BR>";
	}

	// dump the value - wrapping and converting if requried
	echo "<B><font color=green>";
	if ( is_bool( $title)) {
		echo $obj?"-True-":"-False-";
	} else {
		echo wordwrap( (string)$title, 180, "\n");
	}
	echo "</font></b><br>";
	if ( ! empty( $s2)) {
		echo "<font color=#8000FF>";
		echo wordwrap($s2, 100, "\n");
		echo "</font><BR>";
	}
	if ( ! empty( $s3)) {
		echo "<font color=#75D09C>";
		echo wordwrap($s3, 100, "\n");
		echo "</font><BR>";
	}
	if ( ! empty( $s4)) {
		echo "<font color=#96DC78>";
		echo wordwrap($s4, 100, "\n");
		echo "</font><BR>";
	}
	if ( ! empty( $s5)) {
		echo "<font color=#75D0EC>";
		echo wordwrap($s5, 100, "\n");
		echo "</font><BR>";
	}

	echo '<font style="fine-size: large; background-color: #7DEEA2; foreground-color: #FFFFFF">';
	echo " ==>";
	echo "</font>";
	if ( is_string( $obj)) {
		IF ( !empty( $display_modifier)) {
			switch ($display_modifier) {
				case MODIFIER_TO_HEX:
					echo  '0x';
					echo '<font style="text-color=cyan; background=white">';
					echo bin2hex( $obj);
					echo '</font>';
					break;
				case MODIFIER_TO_ENCODE:
					echo 'HTML_ENCODE>';
					echo '<font style="text-color=cyan; background=yellow">';
					echo rawurlencode( $obj);
					echo '</font>';
					echo '<HTML_ENCODE';
				default:
			}
		} else {
			//print_r(htmlspecialchars( $obj));
			$s =print_r(htmlspecialchars( $obj), true);
//13nov08 mjm
			//$s =var_export(htmlspecialchars( $obj), true);
			//$s =var_export($obj, true);
			$a = chr(0x5C) . chr(0x27) ;
			$b = chr(0x27);
			$s = str_replace($a ,$b, $s);

			echo wordwrap( $s,
								140,
								"\n<BR>");
			if ( strlen( $s) > 200){
				echo "\n<BR>(StrLen=" , strlen( $s),')';
			}
		}
	} elseif ( is_bool( $obj)) {
		echo $obj?"-True-":"-False-";
	} elseif ( is_null( $obj)) {
		echo $obj, '-Null!-';
	} elseif ( is_array($obj)
					and !is_array(current( $obj))
					and count( $obj) < 10
				) {   // if it is an array but not a multi dimention array and not tooo big
		$s = print_r( $obj, true);
//13nov08 mjm
		//$s = var_export( $obj, true);
//		$s ='';
//		foreach( $obj as $i=>$el) {
//			$s .= (empty($s)?'':', ') .  $i ."=>" . (empty($el)?"''":print_r($el, true));
//		}
//		echo 'Array(' . wordwrap($s , 80, "\n<br>",1). ')';
//		echo 'Array(' . $s. ')';
		echo $s;
	} else {
		//print_r ( $obj );
		echo wordwrap( print_r ( $obj, true),
//13nov08 mjm
//		echo wordwrap( var_export ( $obj, true),
					100,
					"\n" );
	}

	// show the text from the source file
	if (DUMP_SHOW_LINES_BEFORE_AND_AFTER) {
		echo '<font color=#FF8000 style="text-align: right; font-style: italic; font-size: x-small"> ';
		echo  get_file_line_at_line_num( $bt[0]['file'], $bt[0]['line'], 6,0 );
		echo "</font>";
	}

	// show the file name and line number (helps tell where the dump came from)
	IF ( DUMP_SHOW_FILE_AND_LINE) {
		echo '<div align=right>';
		echo '<br><font color=#EA5559 style="font-size: xx-small">';   //font-style: italic
		echo strtoupper( empty($_SERVER["SERVER_NAME"]) ?  'local' : $_SERVER["SERVER_NAME"]);
		echo ' ';
		echo $bt[0]['file'], " (line: ", $bt[0]['line'] ,")";
		///////undefined function///echo memory_get_usage();
		///echo getMemUsage();
		echo "</font>";
		echo '</div>';
	}

	if ( $show_back_trace) {
		echo '<font color=#0000FF style="font-size: 79%">';
		$text= '';

		$text .= decode_backtrace( $bt);
		echo wordwrap( $text, 110, "\n<br>", 1);
		echo '</font>';
	}
	echo "</pre>\n\n\n";
}


//***********************************************************************************************
//***********************************************************************************************
function decode_backtrace( $bt) {
	$text ='';
	foreach( $bt as $bt_func) {
		if ( ! empty(  $bt_func['file'] )
		and strtolower($bt_func['function']) !='dump'
		and strtolower($bt_func['function'] !='dumpb')) {
			$text  .=  $bt_func['file']
						. ":<b>" . $bt_func['line'] . '</b>'
						. "&nbsp;&nbsp;"
						//. '['
						. $bt_func['function']
						//. ']'
						;

			/// now try to build an argument list to the function call
			$parms = '';
			foreach( $bt_func['args'] as $an_arg){
				$parms .= (empty( $parms)?'':', ');
				if (is_int($an_arg) || is_double($an_arg)) {
					$parms .= $an_arg;
				} elseif (is_bool($an_arg)) {
					$parms .= ($an_arg ? true : 'false');
				} elseif (is_null($an_arg)) {
					$parms .= '{NULL}';
				} elseif (is_object($an_arg)) {
					$parms .= '{OBJECT=>' . get_class($an_arg) . '}';
				} elseif (is_array($an_arg)) {
					$parms .= '{ARRAY(';
					if ( is_array($an_arg)  and !is_array(current( $an_arg))) {   // if it is an array but not a multi dimention array
						$s ='';
						foreach( $an_arg as $el) {
							$s .= (empty($s)?'':',') . print_r($el, true);
//13nov08 mjm
//							$s .= (empty($s)?'':',') . var_export($el, true);
						}
						$parms .= $s . ')}';
					} else {
						$parms .= '(MULTI-ARRAY}';
					}
				} else {
					$parms .= "'" . $an_arg . "'";
				}
			}
			$text .= '(' . $parms . ')'
					. "\n"
					;
		}
	}
	return $text;
}

//***********************************************************************************************
//  read the file and extract the $line_num
//     - optionally get the preceding lines and the following lines
function get_file_line_at_line_num( $fn, $line_num, $preceding_lines=0, $following_lines=0){
			// remember starts at lines[0]
	$lines = file( $fn);
	$s = '';
	for ( $i =$line_num - $preceding_lines -1; ($i< $line_num-1) ; $i++) {
		$s .= $lines[$i] ;
	}
	$s .= $lines[$line_num-1];
	for ( $i =$line_num; ($i< $following_lines+$line_num); $i++) {
		$s .= $lines[$i] ;
	}
	return $s;
}


//***********************************************************************************************
// try and decode the line that the dump command used ( i.e.   dump( $x, 'fred')
//       from above it will try to extract everything between the ( and the ,
function get_var_from_dump_line( $dump_line) {
	//$s = split( "\(", $dump_line);
	$s = preg_split( '/\(/', $dump_line);
	if ( !empty( $s[1])){           // if the dump line is split accros a couple of lines then dont try to decode it
		//$s2 = split( ",", $s[1]);
		$s2 = preg_split( '/,/', $s[1]);
		if (count ($s2) ==1) {
			//$s2= split( "\)", $s[1]);
			$s2= preg_split( '/\)/', $s[1]);
		}
	} else {
		return '';
	}
	return trim($s2[0]);
}

//***********************************************************************************************
//***********************************************************************************************
function sizer($a) {
	global $sizer_size;
	$sizer_size =0;
	array_walk( $a, 'sizer_walker');
	dump( $sizer_size, 'Size of array=');
}
//***********************************************************************************************
//***********************************************************************************************
function sizer_walker( $item, $key){
	global $sizer_size;
	$sizer_size += strlen( $item);
	$sizer_size += strlen( $key);
}




//***********************************************************************************************
// usage:
//			first put in your code
//						register_tick_function( 'detailed_trace');
//			then around ALL the code you want traced (including function definitions)
//						declare( ticks=1) { ... code .... }
//
//			to end the tracing do a
//						unregister_tick_function('detailed_trace');
//
//			then when done dump the trace with call to
//						detailed_trace(true)
//
//***********************************************************************************************
function detailed_trace($dump_it=false) {
	static $detailed_trace;
	static $prev_microtime;

	$bt = debug_backtrace();
	$t = getmicrotime() *10000;			// just to give some whole numbers (normal stmts are about a 3 or 4

	if (empty( $detailed_trace)) {
		$detailed_trace = array();
	}

	if ( !empty( $dump_it)) {
		echo '<table border=1>';
		echo '<tr>';
		echo '<th>File</th>';
		echo '<th>Line</th>';
											////		echo '<th>Function</th>';
		echo '<th>execution time</th>';
											////		echo '<th>Args</th>';
		foreach( $detailed_trace as $trace) {
			echo '<tr><td>';
			//echo $trace['file'];
			$fn = explode("\\" , $trace['file']);
			echo $fn[count($fn)-1];
			echo '</td><td>';
			echo $trace['line'];
			echo '</td><td>';
											////			echo $trace['function'];
											////			echo '</td><td>';
			echo $trace['micro_since_prev'];
											////			echo '</td><td>';
											////			if ( empty($trace['args']) or empty( $trace['args'][0])) {
											////				echo '&nbsp;';
											////			} else {
											////				echo '<pre>';
											////				print_r ($trace['args']);
											////				echo '</pre>';
											////			}
			echo '</td></tr>';
		}
		echo '</table>';
	} else {
		//$a = $bt[1];
		$a = $bt[0];
		$a['micro_since_prev'] = empty( $prev_microtime) ? 0 : $t - $prev_microtime ;
		$prev_microtime = $t;

		$detailed_trace[] = $a;
		//echo  '@', $bt[0]['line'], '@','<br>';
	}
}



//***********************************************************************************************
// usage:
//			first put in your code
//						register_tick_function( 'watch');
//			then around ALL the code you want traced (including function definitions)
//						declare( ticks=1) { ... code .... }
// 		then  to keep track of a variable use -- there are scope issues so may have declare it global
//						watch( 'a')  // for $a
//			more than one variable can be watched
//						watch('b'); watch('c');
//
//			to end the tracing should also do a
//						unregister_tick_function('watch');
//			then when done dump the trace with call to
//						watch(null,true);			// will dump all the vars and where they got changed
//				or
//						watch( 'a', true);	// will only show the one variable (in this case $a)
//
//***********************************************************************************************
function watch($add_var=null, $dump=false) {
	static $watched_vars;   /// each record is (var_name, prev_value)
	static $results;

	$bt = debug_backtrace();

	if (empty($watched_vars)) {
		$watched_vars = array();
		$results =array();
	}

	if ($dump) {
		echo '<table border=1>';
		echo '<tr>';
		echo '<th>Variable Name</th>';
		echo '<th>Previous Value</th>';
		echo '<th>New Value</th>';
		echo '<th>Line</th>';
		echo '<th>File</th>';
		echo '</tr>';
		foreach( $results as $r) {
			if ( empty( $add_var) or ( !empty( $add_var) and $r['var'] == $add_var)) {
				echo '<tr><td>';
				echo $r['var'];
				echo '</td><td>';
				echo $r['prev_val'];
				echo '</td><td>';
				echo $r['new_val'];
				echo '</td><td>';
				echo $r['line'];
				echo '</td><td>';
				//echo $r['file'];
				$fn = explode("\\" , $r['file']);
				echo $fn[count($fn)-1];
				echo '</td></tr>';
			}
		}
		echo '</table>';
	} else {

		if ( empty($add_var )) {

			foreach( $watched_vars as $key => $a_var) {
				if ( isset( $GLOBALS[ $a_var['var_name']])) {
					$tmp = $GLOBALS[ $a_var['var_name']];

					if ( $watched_vars[$key]['prev_value'] != $tmp ) {
						$results[] = array( 'var' =>$watched_vars[$key]['var_name'],
													'prev_val' => $watched_vars[$key]['prev_value'],
													'new_val' =>  $tmp,
													'file' => $bt[0]['file'],
													'line' => $bt[0]['line']
												);
						$watched_vars[$key]['prev_value'] = $tmp;
					}
				}
			}
		} else {
			$watched_vars[] = array( 'var_name'=>$add_var, 'prev_value' =>empty($GLOBALS[ $add_var])? null :$GLOBALS[ $add_var] );
			$results[] = array( 'var' =>$add_var,
										'prev_val' => '-initial add-',
										'new_val' =>  empty($GLOBALS[ $add_var])? null :$GLOBALS[ $add_var],
										'file' => $bt[0]['file'],
										'line' => $bt[0]['line']
									);
		}
	}
}

////////////////// -- example for watch and detailed_trace
//
//////////////////require_once( 'UserErrorHandler.inc.php');
//////////////////
//////////////////register_tick_function( 'watch');
//////////////////register_tick_function( 'detailed_trace');
//////////////////
//////////////////
//////////////////declare( ticks=1) {
//////////////////function fred( &$ww) {
//////////////////	global $a;
//////////////////	$ww = 'fred was here';
//////////////////	echo '*';
//////////////////	echo __LINE__;
//////////////////	echo '*';
//////////////////	$a = 'fred left the building';
//////////////////}
//////////////////
//////////////////function sammy() {
//////////////////	global $a;
//////////////////	$a = 'one';
//////////////////	$b = 'this is b';
//////////////////	watch('b');
//////////////////	fred($b);
//////////////////	$a = 'where am I?';
//////////////////}
//////////////////
//////////////////watch('a');
//////////////////sammy();
//////////////////
//////////////////fred( $b);
//////////////////$a = 'two';
//////////////////$b= 'more b ness';
//////////////////for ( $i = 1; $i<5;$i++) {
//////////////////	echo $i;
//////////////////	$a = $i;
//////////////////	$b = 5 -$a;
//////////////////}
//////////////////
//////////////////} // end of assert
//////////////////
//////////////////unregister_tick_function('detailed_trace');
//////////////////unregister_tick_function('watch');
//////////////////
//////////////////watch(null,true);
//////////////////watch('a',true);
//////////////////
//////////////////detailed_trace(true);


?>