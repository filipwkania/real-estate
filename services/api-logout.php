<?php 

	session_start();

	unset($_SESSION['loggedIn']);
	unset($_SESSION['accessLevel']);

	echo '{"status":"ok", "msg":"User logged out"}';

 ?>