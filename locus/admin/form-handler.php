<?php
require_once("../../../../wp-config.php");
include('SMTPClass.php');
	
	// retrieve from parameters
	$emailfrom = isset($_POST["email"]) ? $_POST["email"] : "";
	$emailto = isset($_POST["emailto"]) ? $_POST["emailto"] : "";
	$nocomment = isset($_POST["nocomment"]) ? $_POST["nocomment"] : "";
	$subject = isset($_POST["emailsubject"]) ? $_POST["emailsubject"] : "";
	$message = '';
	$response = '';
	$res_fail = of_get_option('response_fail');

	$response_fail = $res_fail == '' ? 'There was an error verifying your details.' : $res_fail;
	
		// Honeypot captcha
		if($nocomment == '') {
		
			$params = $_POST;
			foreach ( $params as $key=>$value ){
			
				if(!($key == 'ip' || $key == 'emailsubject' || $key == 'url' || $key == 'emailto' || $key == 'nocomment' || $key == 'v_error' || $key == 'v_email')){
				
					$key = ucwords(str_replace("-", " ", $key));
					
					if ( gettype( $value ) == "array" ){
						$message .= "$key: \n";
						foreach ( $value as $two_dim_value )
						$message .= "...$two_dim_value<br>";
					}else {
						$message .= $value != '' ? "$key: $value\n" : '';
					}
				}
			}
			
		$response = sendEmail($subject, $message, $emailto, $emailfrom);
			
		} else {
		
			$response = $response_fail;
		
		}

	echo $response;

// Run server-side validation
function sendEmail($subject, $content, $emailto, $emailfrom) {
	
	$res_suc = of_get_option('response_sent');
	$res_err = of_get_option('response_sent');
	$include_url = of_get_option('include_url');
	$include_ip = of_get_option('include_ip');
	$email_from = of_get_option('email_form');
	
	$response_sent = $res_suc == '' ? 'Thank you. Your comments have been received.' : $res_suc ;
	$response_error = $res_err == '' ? 'Error. Please try again.' : $res_err ;
	$subject =  filter($subject);
	$url = $include_url ? "Origin Page: ".$_SERVER['HTTP_REFERER'] : "";
	$ip = $include_ip ? "IP Address: ".$_SERVER["REMOTE_ADDR"] : "";
	$from = $emailfrom == '' ? $email_from : $emailfrom;
	$message = $content."\n$ip\r\n$url";
	
	// Validate return email & inform admin
	$emailto = filter($emailto);

	// Setup final message
	$body = wordwrap($message);
	
	if(of_get_option('mail_smtp')){
	
		$SmtpServer = of_get_option('smtp_server');
		$SmtpPort = of_get_option('smtp_port');
		$SmtpUser = of_get_option('smtp_user');
		$SmtpPass = of_get_option('smtp_password');
		
		$to = $emailto;
		$SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $subject, $body);
		$SMTPChat = $SMTPMail->SendMail();
		$response = $SMTPChat ? $response_sent : $response_error;
		
	} else {
		
		// Create header
		$headers = "From: $emailfrom\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/plain; charset=utf-8\r\n";
		$headers .= "Content-Transfer-Encoding: quoted-printable\r\n";
		
		// Send email
		$mail_sent = @mail($emailto, $subject, $body, $headers);
		$response = $mail_sent ? $response_sent : $response_error;
		
	}
	return $response;
}

// Remove any un-safe values to prevent email injection
function filter($value) {
	$pattern = array("/\n/", "/\r/", "/content-type:/i", "/to:/i", "/from:/i", "/cc:/i");
	$value = preg_replace($pattern, "", $value);
	return $value;
}

exit;

?>