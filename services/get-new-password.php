<?php
	
	require_once "./internal/send-mail.php";
	require_once "./internal/connect-to-db.php";

	$sUrlMainPage = 'http://localhost:8080/real-estate2/index.php';

	$sEmail = $_GET['e'];
	$sPasswordReset = $_GET['pr'];

	$sReturnMessage ='error';

	//Check if password reset is correct
	$checkIfCorrectRequest = $usersCollection->findOne(['email'=>$sEmail, 'passwordReset'=>$sPasswordReset]);

	if($checkIfCorrectRequest != null) {
		$sNewPassword = substr(md5(microtime()),rand(0,20),10);
		$sNewPasswordReset = substr(md5(microtime()),rand(0,26),20);

		$sNewPasswordHashed = password_hash($sNewPassword, PASSWORD_DEFAULT);

		$updateUser = $usersCollection->updateOne(
		['email' => $sEmail],
		['$set' =>
			['password'=>$sNewPasswordHashed, 
			'passwordReset'=>$sNewPasswordReset]
		]);

		if($updateUser->getModifiedCount() > 0) {
			fnMailNewPassword($sEmail, $sNewPassword);
			$sReturnMessage = '<center><div>New password has been sent to your email.</div><div>Click <a href="'.$sUrlMainPage.'">HERE</a> to return to main page if you are not being redirected automatically.</div></center>';
			header('Refresh: 10; URL='.$sUrlMainPage);
		} else {
			$sReturnMessage = '<center><div>Something went wrong. Try again or contact our support.</div><div>Click <a href="'.$sUrlMainPage.'">HERE</a> to return to main page if you are not being redirected automatically.</div></center>';
			header('Refresh: 10; URL='.$sUrlMainPage);

		}
	} else {
		$sReturnMessage = '<center><div>Link expired.</div><div>Click <a href="'.$sUrlMainPage.'">HERE</a> to return to main page if you are not being redirected automatically.</div></center>';
		header('Refresh: 7; URL='.$sUrlMainPage);
	}

	echo $sReturnMessage;
	exit();

 ?>