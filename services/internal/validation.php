<?php

	function fnValidateUsername($sUsername) {
		// only alphanumeric characters and ._
		// between 3 and 20 characters, minimum one letter or one number
		$regexPattern = '/^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[A-Za-z\d._]+(?![_.])$/';
		return preg_match($regexPattern, $sUsername);
	}

	function fnValidatePassword($sPassword){
		// between 7 and 128 characters, only alphanumeric and specials
		$regexPattern = '/^([A-Za-z0-9!@#$%^&*_ ]){7,128}$/';
		return preg_match($regexPattern, $sPassword);
	}

	function fnValidateEmail($sEmail) {
		// 99.99% perfect regex for email checking
		$regexPattern = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
		return preg_match($regexPattern, $sEmail);
	}

?>