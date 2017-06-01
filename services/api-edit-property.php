<?php 
	
	require_once "./internal/connect-to-db.php";
	require_once "./internal/handle-google-geocode.php";


	$soId = $_POST['id'];
	$sAddress = $_POST['address'];
	$iPrice = (int) $_POST['price'];
	$iRooms = (int) $_POST['rooms'];
	$fArea = (float) $_POST['area'];
	$sType = $_POST['type'];

	$oId = new MongoDB\BSON\ObjectID($soId);

	//Loading google geocode data, function returns array with lat, lng and formatted address
	$aGeocodeInfo = fnLoadInfoFromAddress($sAddress);

	$fLat = $aGeocodeInfo[0];
	$fLng = $aGeocodeInfo[1];
	$sFormattedAddress = $aGeocodeInfo[2];

	$updateProperty = $propertiesCollection->updateOne(
		['_id' => $oId],
		['$set' => 
			[
				'address' => $sFormattedAddress,
				'price' => $iPrice,
				'rooms' => $iRooms,
				'area' => $fArea,
				'type' => $sType,
				'lat' => $fLat,
				'lng' => $fLng
			]
		]);

	if($updateProperty->getModifiedCount() > 0) {
		echo '{"status":"ok", "msg":"Property edit successful"}';
	} else {
		echo '{"status":"error", "msg":"Update operation failed"}';
	}
 ?>