<?php 

	function fnLoadInfoFromAddress($address) {

		$sUrlAdd = urlencode($address);
		$sApiKey = ''; //GOOGLE API KEY
		$sUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=".$sUrlAdd."&key=".$sApiKey;

		//Fetching json with google location info
		$sajGoogleResponse = file_get_contents($sUrl);
		$ojGoogleResponse = json_decode($sajGoogleResponse, true);
		
		//Getting longitude, latitude and full address nicely formatted
		$fLat = (float) $ojGoogleResponse['results'][0]['geometry']['location']['lat'];
		$fLng = (float) $ojGoogleResponse['results'][0]['geometry']['location']['lng'];
		$sFormattedAddress = $ojGoogleResponse['results'][0]['formatted_address'];

		$result = array($fLat, $fLng, $sFormattedAddress);

		return $result;
	}

 ?>