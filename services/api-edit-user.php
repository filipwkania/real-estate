<?php 
	
	require_once "./internal/connect-to-db.php";

	$soId = $_POST['id'];
	$sUsername = $_POST['username'];
	$sAccessLevel = $_POST['accessLevel'];
	$sEmail = $_POST['email'];

	//All MongoIDs are 24 chars long
	if(strlen($soId) != 24) {
		echo '{"status":"error", "msg":"Operation failed"}';
		exit;
	}

	$oId = new MongoDB\BSON\ObjectID($soId);

	$updateUser = $usersCollection->updateOne(
		['_id' => $oId],
		['$set' =>
			['username'=>$sUsername, 
			'accessLevel'=>$sAccessLevel,
			'email'=>$sEmail]
		]);


	if($updateUser->getModifiedCount() > 0) {
		echo '{"status":"ok", "msg":"User info updated"}';
	} else {
		echo '{"status":"error", "msg":"Update operation failed"}';
	}
 ?>