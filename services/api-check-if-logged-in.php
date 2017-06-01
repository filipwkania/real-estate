<?php 

	session_start();

	if(isset($_SESSION['loggedIn'])) {
		echo $_SESSION['accessLevel'];
	} else {
		echo '0';
	}

 ?>