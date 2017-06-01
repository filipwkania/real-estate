<?php 

	session_start();

	require_once "./internal/connect-to-db.php";
	require_once "./internal/validation.php";

	$sUsername = $_POST['username'];
	$sPassword = $_POST['password'];

	$sReturnMessage ='{"status":"error"}';

	if (fnValidateUsername($sUsername) == 1
		&& fnValidatePassword($sPassword) == 1 ) {

		$fetchUser = $usersCollection->findOne(
			['username'=>$sUsername],
			['projection'=>
				['accessLevel' => 1,
				'password' => 1]
			]);

		if($fetchUser != null) {
			if(password_verify($sPassword, $fetchUser['password'])) {
				$_SESSION['loggedIn'] = true;
				$_SESSION['accessLevel'] = $fetchUser['accessLevel'];
				$sReturnMessage = '{"status":"ok"}';
			}
		} 
		
	}

	echo $sReturnMessage;

 ?>