
<?php

	require_once '../vendor/autoload.php';

	$dbClient = new MongoDB\Client("mongodb://localhost:27017");

	$usersCollection = $dbClient->real_estate->users;

	$propertiesCollection = $dbClient->real_estate->properties;

?>
