/************************************************** **************************************************
 EVENT HANDLERS
************************************************** **************************************************/

$(document).on("click", "#btnLoginSignup", function() {
	fnHideAllOpenOneWindow("wdw-signup");
})

$(document).on("click", "#btnSignupLogin", function() {
	fnHideAllOpenOneWindow("wdw-login");
})

$(document).on("click", "#btnLogin", function() {
	fnLogin();
})

$(document).on("click", "#btnSignup", function() {
	fnSignup();
})

$(document).on("click", "#btnMenuLogout", function() {
	fnLogout();
})

$(document).on("click", "#btnForgotPassword", function() {
	fnHideAllOpenOneWindow("wdw-forgot");
})

$(document).on("click", "#btnForgotSubmit", function() {
	fnForgotSubmit();
})

$(document).on("click", "#btnMenuProperties", function() {
	fnHideAllOpenOneWindow("wdw-properties");
})

$(document).on("click", "#btnMenuAccount", function() {
	fnHideAllOpenOneWindow("wdw-account");
})

$(document).on("click", "#btnMenuLogin", function() {
	fnHideAllOpenOneWindow("wdw-login");
})


/************************************************** **************************************************
 FUNCTIONS - USER RELATED
************************************************** **************************************************/

function fnLogin() {
	var sUsername = $("#txtLoginUsername").val();
	var sPassword = $("#txtLoginPassword").val();

	var bPassCheck = fnValidatePassword(sPassword);
	var bUserCheck = fnValidateUsername(sUsername);

	if(bPassCheck && bUserCheck) {
		sUrl = "services/api-login.php";
		var formData = {password: sPassword, username: sUsername};

		var ajaxRequest = $.ajax({
			method: "POST",
			url: sUrl,
			data: formData,
			dataType: "JSON"
		});

		ajaxRequest.done(function(jData) {
			if(jData.status == "ok") {
				location.reload();
			} else if (jData.message = "error") {
				fnShowCredentialsMessage("Incorrect credentials, try again.", 4000, true);
			} else {
				fnShowCredentialsMessage("Something went wrong, try again in a moment or contact our support.", 10000);
			}
		});

	} else {
		fnShowCredentialsMessage("Incorrect credentials, try again!", 4000, true);
	}
}

function fnLogout() {

	var sUrl = "services/api-logout.php";

	$.getJSON(sUrl, function(jData) {
		if(jData.status == "ok") {
			fnShowPopup("Success!", "You are now logged out", "success",
			 true, 2000, window.location.reload.bind(window.location), null );
		}
	})
}

function fnSignup() {
	var sUsername = $("#txtSignupUsername").val();
	var sEmail = $("#txtSignupEmail").val();
	var sPassword = $("#txtSignupPassword").val();
	var sRepeatPassword = $("#txtSignupRepeatPassword").val();

	var bPassed = true;

	$(".inputRow:visible").removeClass("wrong");	
	$("#lblSignupMessage:visible").text("");

	if (!fnValidateUsername(sUsername)) {
		$("#txtSignupUsername").parent().addClass("wrong");
		bPassed = false;
	}
	if (!fnValidateEmail(sEmail)) {
		$("#txtSignupEmail").parent().addClass("wrong");
		bPassed = false;
	}
	if (!fnValidatePassword(sPassword)) {
		$("#txtSignupPassword").parent().addClass("wrong");
		bPassed = false;
	}
	if (!fnValidatePassword(sPassword) || !(sPassword==sRepeatPassword) ) {
		$("#txtSignupRepeatPassword").parent().addClass("wrong");
		bPassed = false;
	}

	if(bPassed) {

		var sUrl = "services/api-create-user.php";
		var formData = {username: sUsername, email: sEmail, password: sPassword, 
			repeatPassword: sRepeatPassword};

		var ajaxRequest = $.ajax({
			url: sUrl,
			data: formData,
			dataType: "JSON",
			method: "POST"})

		ajaxRequest.done(function(jData) {
			if(jData.status == "ok") {
				//If user creation succeded show confirmation window 
				// that redirects to the login page after clicking "ok"
				fnShowPopup("Success!"," User created\n You can now log in!", 
					"success", true, 0, fnHideAllOpenOneWindow, "wdw-login");
			} else if (jData.status == "error") {
				switch (jData.errorId) {
					case 0: 
						$("#lblSignupMessage").text("This username is already in use. Try different one.");
						break;
					case 1:
						$("#lblSignupMessage").text("This email is already in use. Try different one.");
						break;
					default:
						$("#lblSignupMessage").text("There was a problem registering your data, try again.");
						break;
				}
			} else {
				$("#lblSignupMessage").text("Something went wrong. Try again in a moment or contact our support.");
			}
		});
	} else {
		$("#lblSignupMessage").text("Please correct marked fields:");
	}
}

function fnForgotSubmit() {

	var sEmail = $("#txtForgotEmail").val();

	if(fnValidateEmail(sEmail)) {
		
		var sUrl = "services/api-reset-password.php";	
		var formData = {email:sEmail};

		var ajaxRequest = $.ajax({
			method: "POST",
			url: sUrl,
			data: formData,
			dataType: "JSON"
		});

		ajaxRequest.done(function(jData){
			if(jData.status == "ok") {
				fnShowPopup("Email sent!", "Please check your email for further instructions",
				"success", true, 0, fnHideAllOpenOneWindow, "wdw-login" );
			} else {
				$("#lblRecoveryMessage").text("Please correct your email and try again.");
			}
		});

	} else {
		$("#lblRecoveryMessage").text("Please correct your email and try again.");
	}
}

/************************************************** **************************************************
 FUNCTIONS - PROPERTIES RELATED
************************************************** **************************************************/

//Initialize google map
initMap();

function fnFetchProperties(sTime, bFromTimer) {
	
	var sUrl = "services/api-fetch-properties.php";

	//If time is not null we will be searching for all properties
	//that were created after given timestamp
	if (sTime != null) {
		sUrl += "?time="+sTime;
	}

	$.getJSON(sUrl, function(jData) {
		if(jData.status == "ok") {
			fnAddPropertiesToList(jData.properties, bFromTimer);	
			propertiesList = jData.properties;
		} else {

		}
	})
}

function fnAddPropertiesToList(ajProperties, bFromTimer) {


	var tempTime = lastPropertyTime;
	var sHtmlToAppend = "";

	if(typeof fnManageableBlueprint != "undefined") {
		var sBlueprint = fnManageableBlueprint();
	} else {
		var sBlueprint = 
					'<div class="lblPropertyCard">\
						<div class="lblPropertyImage" style="background-image: url(images/properties/{{imageFileName}}); background-size: 100% 100%;"></div>\
						<div class="lblPropertyInfo">\
							<input class="lblPropertyId" type="hidden" value="{{propertyId}}">\
							<div class="lblPropertyPrice" data-value="{{propertyPrice}}">{{propertyPrice}} DKK</div>\
							<div><span>&#8291;</span></div>\
							<div class="lblPropertyArea" data-value="{{propertyArea}}"><span class="lblInfoLabel">Area: </span>{{propertyArea}} m2</div>\
							<div class="lblPropertyType" data-value="{{propertyType}}"><span class="lblInfoLabel">Type: </span>{{propertyType}}</div>\
							<div class="lblPropertyRooms" data-value="{{propertyRooms}}"><span class="lblInfoLabel">Rooms: </span>{{propertyRooms}}</div>\
							<div><span>&#8291;</span></div>\
							<div class="lblPropertyAddress" data-value="{{propertyAddress}}">{{propertyAddress}}</div>\
						</div>\
					</div>';
					// <div class="btnPropertyShowStreetView">{{propertyStreetViewLink}}</div>\ to implement later on	
	}

	for(var i = 0; i < ajProperties.length; i++) {
		var sNewProperty = sBlueprint;

		sNewProperty = sNewProperty.replace(/{{propertyId}}/g, ajProperties[i]._id.$oid);
		sNewProperty = sNewProperty.replace(/{{propertyPrice}}/g, ajProperties[i].price);
		sNewProperty = sNewProperty.replace(/{{propertyArea}}/g, ajProperties[i].area);
		sNewProperty = sNewProperty.replace(/{{propertyType}}/g, ajProperties[i].type);
		sNewProperty = sNewProperty.replace(/{{propertyRooms}}/g, ajProperties[i].rooms);
		sNewProperty = sNewProperty.replace(/{{propertyAddress}}/g, ajProperties[i].address);

		//Check if property has images
		if(ajProperties[i].images.length > 0) {
			sNewProperty = sNewProperty.replace("{{imageFileName}}", ajProperties[i].images[0]);
			//Else add blank image 
		} else {
			sNewProperty = sNewProperty.replace("{{imageFileName}}", "missingImage.gif");
		}
		sHtmlToAppend += sNewProperty;

		//Add marker to map
		var position = {lat: ajProperties[i].lat, lng: ajProperties[i].lng};
		var mapMarker = new google.maps.Marker({
			position: position,
			customInfo: ajProperties[i]._id.$oid
		});

		//Set marker on map
		mapMarker.setMap(map);

		//Add event listener to marker
		mapMarker.addListener("click", function() {
			fnMarkerClicked(this.customInfo);
		})

		//Check if property is newer and set it if yes
		if(ajProperties[i].created_on > lastPropertyTime) {
			lastPropertyTime = ajProperties[i].created_on;
		}
	}
	//Add cards to list
	$("#lblPropertiesCards").append(sHtmlToAppend);
	$("#lblNumberOfProperties").text($("#lblPropertiesCards").children().length);

	//Display notification if there are new properties
	// and event was called from the timer
	// also: change page title, funny requirement
	if(lastPropertyTime > tempTime && bFromTimer) {
		$("title").text("New properties!" + lastPropertyTime);
		fnShowNotification("Real Estate CMS", "New properties added!",
			"./images/page/info-icon.png", "newProperty");
	}
}

function fnAutoCheckingNewProperties() {
	var timer = setInterval(function() {
		fnFetchProperties(lastPropertyTime, true);
	}, 10000);
}

/************************************************** **************************************************
 VALIDATION FUNCTIONS
************************************************** **************************************************/

function fnValidatePassword(sPassword) {
	// between 7 and 128 characters, only alphanumeric and specials
	var regex = /^([A-Za-z0-9!@#$%^&*_ ]){7,128}$/;
	return (regex.test(sPassword));
}

function fnValidateUsername(sUsername) {
	// only alphanumeric characters and ._
	// between 3 and 20 characters, minimum one letter or one number
	var regex = /^(?=.{3,20}$)(?![_.])(?!.*[_.]{2})[A-Za-z\d._]+(?![_.])$/;
	return (regex.test(sUsername));
}

function fnValidateEmail(sEmail) {
	// 99.99% perfect regex for email checking
	var regex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return (regex.test(sEmail));
}

/************************************************** **************************************************
 FUNCTIONS - GENERAL
************************************************** **************************************************/

function fnHideAllOpenOneWindow(sWindow) {

	fnClearOnWindowSwitch();

	// hide all visible windows
	$(".wdw:visible").hide(); 

	//start fading in desired window
	$("#"+sWindow).fadeIn(650); 

	//make desired window visible
	$("#"+sWindow).css("display", "flex"); 

	if(sWindow == "wdw-properties") {
		fnAutoCheckingNewProperties();		
	}
}

function fnShowCredentialsMessage($sText, $iTime, $bForgot){
	$("#lblInfoMessage:visible").stop(true, true);
	$("#lblInfoMessage:hidden").show();
	$("#lblInfoMessage").text($sText);
	$("#lblInfoMessage").fadeOut($iTime);
	if ($bForgot) {
		$("#btnForgotPassword").fadeIn();
	}
}

function fnClearOnWindowSwitch() {

	//clear all inputs in currently visible windows
	$(".wdw:visible input").val("");

	//clear extra stuff based on currently open window
	switch($(".wdw:visible").attr("id")) {
		case "wdw-login":
			$("#btnForgotPassword:visible").hide();
			break;
		case "wdw-signup":
			$(".inputRow:visible").removeClass("wrong");
			$("#lblSignupMessage:visible").text("");
			break;
		case "wdw-forgot":
			$("#lblRecoveryMessage:visible").text("");	
		default:
			break;
		}
}

function fnShowNotification(sTitle, sText, sIcon, sTag) {
  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  } else if (Notification.permission === "granted") {
    var options = {
      body: sText,
      icon: sIcon
     };

    var notification = new Notification(sTitle, options);
    fnPlaySound("./images/info-calm.mp3");

  } else if (Notification.permission !== 'denied') {
    Notification.requestPermission(function (permission) {
      if (!('permission' in Notification)) {
        Notification.permission = permission;
      }
      if (permission === "granted") {
		    var options = {
		      body: sText,
		      icon: sIcon
		     };

        var notification = new Notification(sTitle, options);
   			fnPlaySound("./images/info-calm.mp3");  
      }
    });
  }
}

function fnMarkerClicked(sId) {
	/*
	*	TODO: Scroll to property position on the list and highlight it
	*/
	console.log(sId);
}

function fnPlaySound(sPath) {
	if(document.getElementById('audio') == null) {
		var audioElement = document.createElement('audio');	
		audioElement.src = sPath;
	}
	audioElement.play();
}

function fnShowPopup(sTitle, sMessage, sType, bButton, iTimer, fFunction, oParameter) {
	var popupData = {		
		title: sTitle,
		text: sMessage,
		type: sType};

	if(bButton) {
		popupData.showConfirmButton = bButton;
	}

	if(iTimer > 0) {
		popupData.timer = iTimer;
	}

	var popup = swal(popupData,
		function() {
			if(fFunction != null) {
				if(oParameter != null) {
					fFunction(oParameter);
				} else {
					fFunction();
				}
			}
		});
}

function initMap() {
  var uluru = {lat: 55.6656734, lng: 12.4429817};
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 11,
    center: uluru,
    mapTypeControlOptions: {
	    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
	    position: google.maps.ControlPosition.LEFT_BOTTOM
		}
  });
}