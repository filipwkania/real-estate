<?php 

	function fnMailAccountCreatedConfirmation($sEmail, $sUsername) {
		$sRecipientEmail = $sEmail;
		$sSubject = "Account created - CMS";
		$sMessage = '<div>Hello '.$sUsername.'!</div><div>Your account has been successfuly created!</div><div>Have a good day!</div>';
		$sMessage = wordwrap($sMessage);

		fnMailSend($sEmail, $sSubject, $sMessage);
	}

	function fnMailResetPasswordLink($sEmail, $sPasswordReset) {
		$sRecipientEmail = $sEmail;
		$sDomainName = "http://localhost:8080/real-estate2";
		$sResetLink = $sDomainName.'/services/get-new-password.php?pr='.$sPasswordReset.'&e='.$sEmail;
		$sSubject = "CMS Password Reset";
		$sMessage = '<div>Hi there!</div><div>Someone requested password change for this CMS account.</div><div>Visit following page to reset password for your account: <a href="'.$sResetLink.'">reset my password</a></div><div>New password will arrive in next email after entering page.</div><div>Have a nice day!</div><div></div><div>If you did not request password change please disregard this message</div>';

		fnMailSend($sEmail, $sSubject, $sMessage);
	}

	function fnMailNewPassword($sEmail, $sNewPassword) {
		$sRecipientEmail = $sEmail;
		$sSubject = "CMS New Password";
		$sMessage = '<div>Hello there!</div><div>Your new password is: <b>'.$sNewPassword.'</b></div><div>Please change it as soon as possible!</div><div>Have a nice day!</div>';

		fnMailSend($sEmail, $sSubject, $sMessage);
	}

	function fnMailSend($sEmail, $sSubject, $sMessage) {
		$mail = new PHPMailer(true);

		//Setup mail settings using gmail
	  $mail->IsSMTP(); // telling the class to use SMTP
	  $mail->SMTPAuth = true; // enable SMTP authentication
	  $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
	  $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
	  $mail->Port = 465; // set the SMTP port for the GMAIL server
	  $mail->Username = ""; // GMAIL username
	  $mail->Password = ""; // GMAIL password
	  $mail->IsHTML(true);  //Treat email as html page

	  //Set email
		$mail->AddAddress($sEmail, "User");
		$mail->SetFrom("", "CMS Mailer");
		$mail->Subject = $sSubject;
		$mail->Body = $sMessage;

		try{
	    	$mail->Send();
	    // echo "Email sent";
		} catch(Exception $e){
		    //Something went bad
		    // echo "Email not sent: ".$e;
		}
	}
 ?>