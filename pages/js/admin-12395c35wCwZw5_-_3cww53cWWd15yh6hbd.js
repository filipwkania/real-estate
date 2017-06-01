$(document).on("click", "#btnMenuUsers", function() {
	fnFetchUsers();
	fnHideAllOpenOneWindow("wdw-users");
})

$(document).on("click", "#btnCloseNewUser", function() {
	fnCloseEditUser();
})

$(document).on("click", "#btnSaveNewUser", function() {
	fnSaveNewUser();
})

$(document).on("click", ".editable", function(e) {
	fnShowUserInEdit(e.target);
})

$(document).on("click", ".delete-user", function(e) {
	fnDeleteUser(this);
})

function fnDeleteUser(oSource) {
	var sUserId = $(oSource).siblings(".userId").val();
	
	sUrl = "services/api-delete-user.php";

	var ajaxRequest = $.ajax({
		url: sUrl,
		data: {id:sUserId},
		dataType: "JSON",
		method: "POST"
	});

	ajaxRequest.done(function(jData) {
		if(jData.status === "ok") {
			fnShowPopup("Success!", "User was successfuly removed from database", "success",
				true, 2000, fnFetchUsers, null); 
		} else {
			console.log("error");
		}
	});

	ajaxRequest.error(function(xhr, status, error) {
		console.log(xhr.responseText);	
	});
}

function fnSaveNewUser() {
	var sUserId = $("#txtUserId").val();
	var sUsername = $("#txtNewUserUsername").val();
	var sEmail = $("#txtNewUserEmail").val();
	var sPassword = $("#txtNewUserPassword").val();
	var sRepeatPassword = $("#txtNewUserRepeatPassword").val();
	var sAccessLevel = $("#selectNewUserAccessLevel").val();

		//If userID exists, edit that user in db
	if(sUserId.length > 0) {
		var sUrl = "services/api-edit-user.php";

		var formData = {};
		formData.id = sUserId;
		formData.username = sUsername;
		formData.email = sEmail;
		formData.password = sPassword;
		formData.repeatPassword = sRepeatPassword;
		formData.accessLevel = sAccessLevel;

		var ajaxRequest = $.ajax({
			url: sUrl,
			method: "POST",
			dataType: "JSON",
			data: formData
		});

		ajaxRequest.done(function(jData) {
			if(jData.status === "ok") {
				fnShowPopup("Success!", "User "+sUsername+" was updated in the database.",
				 "success", true, 2000, fnFetchUsers, null);
			} else {
				console.log("failed");
			}
		});

		ajaxRequest.error(function(xhr, status, error) {
			console.log(xhr.responseText);	
		});

	//If no id given, create new user
	} else {
		var sUrl = "services/api-create-user.php";

		var formData = {};
		formData.username = sUsername;
		formData.email = sEmail;
		formData.password = sPassword;
		formData.repeatPassword = sRepeatPassword;
		formData.accessLevel = sAccessLevel;

		var ajaxRequest = $.ajax({
			url: sUrl,
			method: "POST",
			dataType: "JSON",
			data: formData
		});

		ajaxRequest.done(function(jData) {
			if(jData.status === "ok") {
				fnShowPopup("Success!", "User "+sUsername+" added to database.",
				"success", true, 2000, fnFetchUsers, null);
			} else {
				console.log("failed");
			}
		});

		ajaxRequest.error(function(xhr, status, error) {
			console.log(xhr.responseText);	
		});
	}

	fnCloseEditUser();
}

function fnShowUserInEdit(oSource) {

	$("#lblUsersTitle").text("Edit user");
	$("#btnCloseNewUser").show();

	var sUserId = $(oSource).parent().children(".userId").val();
	var sUserUsername = $(oSource).parent().children(".user-username").text();
	var sUserEmail = $(oSource).parent().children(".user-email").text();
	var sUserAccessLevel = $(oSource).parent().children(".user-accessLevel").text();

	$("#txtUserId").val(sUserId);
	$("#txtNewUserUsername").val(sUserUsername);
	$("#txtNewUserEmail").val(sUserEmail);
	$("#selectNewUserAccessLevel").val(sUserAccessLevel);

}

function fnCloseEditUser() {
	$("#lblEditUser input").val("");
	$("#selectNewUserAccessLevel").val("basic");
	$("#btnCloseNewUser").hide();
	$("#lblUsersTitle").text("Create new user");
}

function fnFetchUsers() {
	var sUrl = "services/api-fetch-users.php";

	ajaxRequest = $.ajax({
		url: sUrl,
		method: "POST",
		dataType: "JSON"
	});

	ajaxRequest.done(function(jData) {
		if(jData.status === "ok") {
			fnAddUsersToTable(jData.users);
		} else {
			console.log("users data corrupted");
		}
	});

	ajaxRequest.error(function(xhr, status, error) {
		console.log(xhr.responseText);
	});
}

function fnAddUsersToTable(aUsers) {

	var sBlueprint = '<tr class="user-row">\
											<input type="hidden" class="userId" value="{{id}}"></input>\
											<td class="text-left user-username editable">{{username}}</td>\
											<td class="text-left user-email editable">{{email}}</td>\
											<td class="text-left user-accessLevel editable">{{accessLevel}}</td>\
											<td class="text-center delete-user"><span class="fa fa-fw fa-remove"></span></td>\
										</tr>';
	var sHtmlToAdd = '';

	for(var i = 0; i < aUsers.length; i++) {
		var temp = sBlueprint;

		temp = temp.replace("{{id}}", aUsers[i]._id.$oid);
		temp = temp.replace("{{username}}", aUsers[i].username);
		temp = temp.replace("{{email}}", aUsers[i].email);
		temp = temp.replace("{{accessLevel}}", aUsers[i].accessLevel);
		
		sHtmlToAdd+= temp;
	}

	$(".table-hover").empty();
	$(".table-hover").append(sHtmlToAdd);
}

