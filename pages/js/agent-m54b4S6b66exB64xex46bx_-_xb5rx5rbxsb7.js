$(document).on("click", ".btnRemoveProperty", function(e) {
	fnRemoveProperty($(e.target).parent().parent());
})

$(document).on("click", ".btnEditProperty", function(e) {
	fnEditProperty($(e.target).parent().parent());
})

$(document).on("click", "#btnSaveNewProperty", function() {
	if($("#txtNewPropertyId") != "") {
		fnSaveProperty();
	} else {
		fnSaveNewProperty();
	}
})

$(document).on("click", "#btnAddNewProperty", function() {
	$("#map").css("height", "0");
	$("#lblPropertyDetails").css("display", "flex");
	$("#lblPropertyDetails input").val("");
	$("#lblSmallTitle").text("Add new property");
	$(".images:hidden").show();
})

$(document).on("click", "#btnCloseProperty", function() {
	fnClosePropertyWindow();
})

function fnRemoveProperty(oSource) {
	var sId = $(oSource).siblings(".lblPropertyId").val();

	sUrl = "services/api-delete-property.php";

	ajaxRequest = $.ajax({
		url: sUrl,
		method: "POST",
		dataType: "JSON",
		data: {id:sId}
	});

	ajaxRequest.done(function(jData) {
		if(jData.status === "ok") {
			fnShowPopup("Success!", "Property was removed from database", "success",
				true, 2000, null, null);

			$(".lblPropertyId[value="+sId+"]").parent().parent().hide();
		}
	})
}

function fnEditProperty(oSource){

	$("#map").css("height", "0");
	$("#lblPropertyDetails").css("display", "flex");
	$("#lblPropertyDetails input").val("");
	$(".images:visible").hide();
	$("#lblSmallTitle").text("Edit property");

	var sId = $(oSource).siblings(".lblPropertyId").val();
	var sAddress = $(oSource).siblings(".lblPropertyAddress").data("value");
	var sArea = $(oSource).siblings(".lblPropertyArea").data("value");
	var sRooms = $(oSource).siblings(".lblPropertyRooms").data("value");
	var sType = $(oSource).siblings(".lblPropertyType").data("value");
	var sPrice = $(oSource).siblings(".lblPropertyPrice").data("value");

	$("#txtNewPropertyId").val(sId);
	$("#txtNewPropertyAddress").val(sAddress);
	$("#txtNewPropertyArea").val(sArea);
	$("#txtNewPropertyRooms").val(sRooms);
	$("#selectPropertyType").val(sType);
	$("#txtNewPropertyPrice").val(sPrice);
}

function fnSaveProperty() {

	var sUrl = "services/api-edit-property.php";

	var formData = {};
	formData.id = $("#txtNewPropertyId").val();
	formData.address = $("#txtNewPropertyAddress").val();
	formData.area = $("#txtNewPropertyArea").val();
	formData.rooms = $("#txtNewPropertyRooms").val();
	formData.type = $("#selectPropertyType").val();
	formData.price = $("#txtNewPropertyPrice").val();

	var ajaxRequest = $.ajax({
		url: sUrl,
		data: formData,
		method: "POST",
		dataType: "JSON"
	});

	ajaxRequest.done(function(jData){
		if(jData.status === "ok") {
			fnShowPopup("Success!", "Property is now updated, reload the page to see changes.", "success",
				true, 2000, fnClosePropertyWindow, null);
		}
	});

	ajaxRequest.error(function(xhr, status, error) {
		console.log(xhr.responseText);	
	});

}

function fnClosePropertyWindow() {
	//Reset fields
	$("#lblPropertyDetails select").val("House");
	$("#lblPropertyDetails input").val("");

	//Minify property details
	$("#lblPropertyDetails").css("display", "none");

	//Show map again
	$("#map").css("height", "100%");
	google.maps.event.trigger(map, 'resize');
}

function fnSaveNewProperty() {

	var sUrl = "services/api-create-property.php";
	var formData = new FormData($("#formNewProperty")[0]);

	// for (var pair of formData.entries()) {
 //    console.log(pair[0]+ ', ' + pair[1]); 
	// }

	var ajaxRequest = $.ajax({
		url: sUrl,
		data: formData,
		cache: false,
		contentType: false,
		processData: false,
		type: "POST",
		dataType: "JSON",
		timeout: 0
	});

	ajaxRequest.done(function(jData) {
		if(jData.status == "ok") {
			fnShowPopup("Success!", "New property is now saved in the database.", "success"
				, true, 2500, fnClosePropertyWindow, null);
		} else {
			console.log("error");
		}
	});

	// ajaxRequest.error(function(xhr, status, error) {
	// 	console.log(xhr.responseText);	
	// });
}

function fnManageableBlueprint() {
	// Bluepritnt for agents and admins view
	// contains property controls edit and remove
	var sManageableBlueprint = 
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
						<div class="lblPropertyControls">\
							<div class="lblPropertyEdit"><span class="btnEditProperty">Edit</span><span class ="fa fa-fw fa-edit"></span></div>\
							<div class="lblPropertyRemove"><span class="btnRemoveProperty">Remove</span><span class ="fa fa-fw fa-remove"></span></div>\
						</div>\
					</div>\
				</div>';

	return sManageableBlueprint;
}