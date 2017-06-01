<?php 
	
	require_once "./internal/connect-to-db.php";

	$soId = $_POST['id'];

	//All MongoIDs are 24 chars long
	if(strlen($soId) != 24) {
		echo '{"status":"error", "msg":"Operation failed"}';
		exit;
	}

	$oId = new MongoDB\BSON\ObjectID($soId);

	$deleteProperty = $propertiesCollection->deleteOne(
		['_id' => $oId]);

	if($deleteProperty->getDeletedCount() > 0) {
		echo '{"status":"ok", "msg":"Property deleted"}';
	} else {
		echo '{"status":"error", "msg":"'.var_dump($dbClient->lastError()).'"}';
	}

 ?>