<?php

function send_message($fields) {
	
	if (!isset($fields['mailserver']) || $fields['mailserver'] == '') {
		$mailserver = 'localhost';
	} else {
		$mailserver = $fields['mailserver'];
	}
	
	require_once("mailing/class.phpmailer.php");
	if (count($fields['email_recips']) > 0) {
		
		$success = 0;
		$errors = 0;
		
		foreach ($fields['email_recips'] as $email_addr) {
			
			$mail = new PHPMailer(true);
			$mail->IsSMTP();                                      // set mailer to use SMTP
			$mail->SMTPAuth   = false;                  // enable SMTP authentication
			$mail->IsSendmail();  // tell the class to use Sendmail
			$mail->From = $fields['from_email'];
			$mail->FromName = $fields['from_name'];
			$mail->Host = $mailserver;       		      // specify main and backup server
			$mail->AddAddress($email_addr);
			$mail->WordWrap = 80;                                 // set word wrap to 50 characters
			$mail->IsHTML(true);                                  // set email format to HTML
			$mail->Subject = $fields['subject'];
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer"; // optional, comment out and test
			if (isset($fields['template']) && $fields['template'] != '') {
				$content1 = $fields['template'];
			} else {
				$content1 = '%%content%%';
			}
			$content = str_replace("%%content%%",$fields['body'],$content1);
			
			$find = array("%%host%%");
			$replace = array($_SERVER['HTTP_HOST']);
			$content = str_replace($find,$replace,$content);
			
			if (isset($fields['attachments'])) {
				foreach ($fields['attachments'] as $file) {
					$mail->AddAttachment($file);
				}
			}
			$mail->MsgHTML($content);
			if ($mail->send()) {
				$success++;
			} else {
				$errors++;
			}
			
		}
		
		if ($success == count($fields['email_recips'])) {
			return true;
		} else {
			return false;
		}
		
	}
		

} 
	
?>