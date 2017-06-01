<?php 
	session_start();

	require_once "./internal/connect-to-db.php";

	//If user is logged in then db is most probably not empty
	if ( isset($_SESSION['loggedIn']) ) {
		echo '{"status":"ok", "message":"logged in"}';
	} else {
		
		$users = $usersCollection->find();
		
		if($users != null) {
			echo '{"status":"error","message":"User db empty"}';
		}
	}


 ?>