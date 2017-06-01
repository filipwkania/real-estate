<?php 
	
	require_once "./internal/send-mail.php";
	require_once "./internal/validation.php";
	require_once "./internal/connect-to-db.php";

	$sUsername = $_POST['username'];
	$sPassword = $_POST['password'];
	$sRepeatPassword = $_POST['repeatPassword'];
	$sEmail = $_POST['email'];

	if(isset($_POST['accessLevel'])) {
		$sAccessLevel = $_POST['accessLevel'];
	} else {
		$sAccessLevel = "basic";
	}

	if (fnValidateUsername($sUsername) == 1
		&& fnValidatePassword($sPassword) == 1
		&& fnValidateEmail($sEmail) == 1
		&& $sPassword == $sRepeatPassword) {

		//Try to find user where either username or email matches
		//If found, return both email and username of the matched user
		$checkIfExists = $usersCollection->findOne(
			[ '$or' =>
				[
					['username' => $sUsername],
					['email' => $sEmail]
				]
			],
			['projection' =>
				[
					'username' => 1,
					'email' => 1
				]
			]
		);

		if($checkIfExists != null) {
			if($checkIfExists->username == $sUsername) {
				//If username alredy exists send error with code 0
				echo '{"status":"error", "errorId":0}';
			} else {
				//Else it means email already exists, so send error with code 1
				echo '{"status":"error", "errorId":1}';
			}
			// Else means username and email are unique, so we can create user
		} else {

			$sPassword = password_hash($sPassword, PASSWORD_DEFAULT);

			//Random string to be added to links for password reset
			$sPasswordReset = substr(md5(microtime()),rand(0,26),20);

			$insertUser = $usersCollection->insertOne([
				'username'=>$sUsername, 
				'password'=>$sPassword,
				'email'=>$sEmail,
				'accessLevel'=>$sAccessLevel, 
				'registrationDate'=>time(),
				'passwordReset'=>$sPasswordReset,
				'active'=>true
			]);

			if($insertUser->getInsertedId() != null) {
				echo '{"status":"ok", "message":"User added to db"}';
				// ******************* MAIL FUNCTION ********************
				fnMailAccountCreatedConfirmation($sEmail, $sUsername);
			} else {
				echo '{"status":"error", "message":"Something went wrong"}';
			}
		}
	}

 ?>