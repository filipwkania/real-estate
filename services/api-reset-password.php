<?php
	
	require_once "./internal/send-mail.php";
	require_once "./internal/validation.php";
	require_once "./internal/connect-to-db.php";

	$sEmail = $_POST['email'];

	$sReturnMessage ='{"status":"error"}';

	//Check if email is correct
	if(fnValidateEmail($sEmail) == 1) {

		//Check if email exists, if yes, return password reset string
		$checkIfEmailExists = $usersCollection->findOne(
			['email'=>$sEmail],
			['projection' => 
				[
					'passwordReset'=> 1
				]
			]);

		if($checkIfEmailExists != null) {	
			fnMailResetPasswordLink($sEmail, $checkIfEmailExists['passwordReset']);
			$sReturnMessage ='{"status":"ok"}';
		}
		
	}

	echo $sReturnMessage;

 ?>