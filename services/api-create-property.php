<?php 
	
	require_once "./internal/connect-to-db.php";
	require_once "./internal/handle-images-upload.php";
	require_once "./internal/handle-google-geocode.php";


	$sAddress = $_POST['address'];
	$iPrice = (int) $_POST['price'];
	$iRooms = (int) $_POST['rooms'];
	$fArea = (float) $_POST['area'];
	$sType = $_POST['type'];

	//Format price
	$iPrice = number_format($iPrice, 2, ',', '.');

	// Handling uploaded images, function returns array with img filenames
	$aImages = fnUploadMultipleImages();

	//Loading google geocode data, function returns array with lat, lng and formatted address
	$aGeocodeInfo = fnLoadInfoFromAddress($sAddress);

	$fLat = $aGeocodeInfo[0];
	$fLng = $aGeocodeInfo[1];
	$sFormattedAddress = $aGeocodeInfo[2];

	$insertProperty = $propertiesCollection->insertOne(
		[
			'address' => $sFormattedAddress,
			'images' => $aImages,
			'price' => $iPrice,
			'rooms' => $iRooms,
			'area' => $fArea,
			'type' => $sType,
			'lat' => $fLat,
			'lng' => $fLng,
			'created_on' => microtime(true)
		]);

	if($insertProperty->getInsertedId() != null) {
		echo '{"status":"ok", "message":"Property added to db"}';
	} else {
		echo '{"status":"error", "message":"Failed to add property"}';
	}
 ?>