<?php 
	
	require_once "./internal/connect-to-db.php";

	$soId = $_GET['sId'];
	$sOldPassword = $_GET['oldPassword'];
	$sNewPassword = $_GET['newPassword'];

	//All MongoIDs are 24 chars long
	if(strlen($soId) != 24) {
		echo '{"status":"error", "msg":"Operation failed"}';
		exit;
	}

	$oId = new MongoDB\BSON\ObjectID($soId);

	//Hash old password 
	$sOldPassword = password_hash($sOldPassword, PASSWORD_DEFAULT);

	//Check if it's correct
	$checkIfPasswordCorrect = $usersCollection->findOne(['_id'=>$oId, 'password' =>$sOldPassword]).size();

	//If correct, hash new password and update user
	if($checkIfPasswordCorrect > 0) {

		$sNewPassword = password_hash($sNewPassword, PASSWORD_DEFAULT);
		$updateUser = $usersCollection->updateOne(
		['_id' => $oId],
		['$set' =>
			['password'=>$sNewPassword]
		]);
	}

	if($updateUser->getModifiedCount() > 0) {
		echo '{"status":"ok", "msg":"User password updated"}';
		$updateUser = null;
	} else {
		echo '{"status":"error", "msg":"Update operation failed"}';
	}
 ?>