<?php 

	require_once "./internal/connect-to-db.php";

	//Load all users from collection
	$acUsers = $usersCollection->find(); //c = mongo cursor

	$saUsers = $acUsers->toArray();

	if(count($saUsers) > 0) {
		$sUsers = json_encode($saUsers);
		$sMessage = '{"status":"ok", "users":'.$sUsers.'}';
	} else {
		$sMessage = '{"status":"error"}';
	}

	echo $sMessage;

 ?>