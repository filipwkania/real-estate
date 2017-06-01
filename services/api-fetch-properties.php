<?php 

	require_once "./internal/connect-to-db.php";

	//Time of property creation to get all properties
	// that were created after this date
	if(isset($_GET['time'])) {
		$sTime = (float) $_GET['time'];	
	} else {
		$sTime = 0;
	}

	$acProperties = $propertiesCollection->find(
		['created_on' =>
			[
				'$gt' => ($sTime + 000.1)
			]
		]);
	$aProperties = $acProperties->toArray();
	
	if( count($aProperties) > 0 ) {
		$sProperties = json_encode($aProperties);
		$sMessage = '{"status":"ok", "properties":'.$sProperties.'}';  
	} else {
		$sMessage = '{"status":"error"}';
	}

	echo $sMessage;

 ?>