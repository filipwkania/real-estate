<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Real Estate CMS v2</title>
	<link rel="stylesheet" type="text/css" href="style/app.css">
	<link rel="stylesheet" type="text/css" href="style/hover.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
</head>
<body>

<div id="wrapper">

<!-- ************************************************** ************************************************** -->
<!-- MENU -->
<!-- ************************************************** -->
	<div id="navigation">
		<div id="menuBar">
			<ul id="menuLeft">
				<li id="btnMenuHome"><span class="fa fa-fw fa-home"></span><span class="lblMenuText">Home</span></li>
				<li id="btnMenuProperties"><span class="fa fa-fw fa-building"></span><span class="lblMenuText">Offers</span></li>
				<?php 
				if(isset($_SESSION['loggedIn'])) {
					echo	'<li id="btnMenuAccount"><span class="fa fa-fw fa-gear"></span><span class="lblMenuText">Account</span></li>';
					if($_SESSION['accessLevel'] == "admin") {
						echo '<li id="btnMenuUsers"><span class="fa fa-fw fa-users"></span><span class="lblMenuText">Users</span></li>';
					}
				}	?>
			</ul>
			<ul id="menuRight">
				<?php 
				if (isset($_SESSION['loggedIn'])) {
					echo '<li id="btnMenuLogout"><span class="fa fa-fw fa-sign-out"></span><span class="lblMenuText">Logout</span></li>';
				} else {
					echo '<li id="btnMenuLogin"><span class="fa fa-fw fa-sign-in"></span><span class="lblMenuText">Login</span></li>';
				}	 ?>
			</ul>
		</div>
		<div id="menuIndicator"><span class="arrow-down"></span></div>
	</div>
<!-- ************************************************** -->
<!-- END OF MENU -->
<!-- ************************************************** ************************************************** -->

<!-- ************************************************** ************************************************** -->
<!-- LOGIN PAGE -->
<!-- ************************************************** -->
	<div id="wdw-login" class="wdw">
		<h1 id="lblPageTitle">Log in to Real Estate CMS</h1>
		<div class="inputRow no-bg">
			<div id="lblInfoMessage"></div>
		</div>
		<div class="inputRow">
			<span class="fa fa-fw fa-user"></span>
			<input id="txtLoginUsername" class="big-input transparent field" placeholder="username" required></input>
			<label class="floating-label"> Username</label>
		</div>
		<div class="inputRow">
			<span class="fa fa-fw fa-key"></span>
			<input id="txtLoginPassword" class="big-input transparent field" type="password" placeholder="password" required></input>
			<label class="floating-label"> Password</label>
		</div>
		<button id="btnLogin" class="big-button hvr-grow hvr-push">Login</button>
		<div id="btnLoginSignup" class="big-input hvr-grow hvr-push">Signup</div>
		<div class="inputRow no-bg">
			<div id="btnForgotPassword" class="big-input hvr-grow hvr-push">Forgot password?</div>	
		</div>
	</div>
<!-- ************************************************** -->
<!-- END OF LOGIN PAGE -->
<!-- ************************************************** ************************************************** -->

<!-- ************************************************** ************************************************** -->
<!-- SIGNUP PAGE -->
<!-- ************************************************** -->
	<div id="wdw-signup" class="wdw">
	<h1 id="lblPageTitle">Create account</h1>
		<div class="inputRow no-bg">
			<div id="lblSignupMessage"></div>
		</div>
		<div class="inputRow">
			<span class="fa fa-fw fa-user"></span>
			<input id="txtSignupUsername" class="big-input transparent field" placeholder="username" name="username" required></input>
			<label class="floating-label"> Username: 3-20 characters, alphanumeric and . _</label>
		</div>
		<div class="inputRow">
			<span class="fa fa-fw fa-envelope-open"></span>
			<input id="txtSignupEmail" class="big-input transparent field" placeholder="email" required></input>
			<label class="floating-label"> Email: example@mail.com</label>
		</div>
		<div class="inputRow">
			<span class="fa fa-fw fa-key"></span>
			<input id="txtSignupPassword" class="big-input transparent field" type="password" placeholder="password" required></input>
			<label class="floating-label"> Password: 7-128 characters, alphanumeric and specials</label>
		</div>
		<div class="inputRow">
			<span class="fa fa-fw fa-key"></span>
			<input id="txtSignupRepeatPassword" class="big-input transparent field" type="password" placeholder="retype password" required></input>
			<label class="floating-label"> Password: retype password</label>
		</div>
		<button id="btnSignup" class="big-button hvr-grow hvr-push">Signup</button>
		<div id="btnSignupLogin" class="big-input hvr-grow hvr-push">Login</div>
	</div>
<!-- ************************************************** -->
<!-- END OF SIGNUP PAGE -->
<!-- ************************************************** ************************************************** -->

<!-- ************************************************** ************************************************** -->
<!-- FORGOT PASSWORD PAGE -->
<!-- ************************************************** -->
	<div id="wdw-forgot" class="wdw">
		<h1 id="lblPageTitle">Password recovery</h1>
		<div class="inputRow no-bg">
			<div id="lblRecoveryMessage"></div>
		</div>
		<div class="inputRow">
			<span class="fa fa-fw fa-envelope-open"></span>
			<input id="txtForgotEmail" class="big-input transparent field" placeholder="email"></input>
			<label class="floating-label"> Email: example@mail.com</label>
		</div>
		<button id="btnForgotSubmit" class="big-button hvr-grow hvr-push">Submit</button>
		<div id="btnSignupLogin" class="big-input hvr-grow hvr-push">Back to Login</div>
	</div>
<!-- ************************************************** -->
<!-- END OF FORGOT PASSWORD -->
<!-- ************************************************** ************************************************** -->

<!-- ************************************************** ************************************************** -->
<!-- PROPERTIES PAGE -->
<!-- **************************************************  -->
	<div id="wdw-properties" class="wdw">
		<div id="mapContainer">
			<div id="map"></div>
			<div id="lblPropertyDetails">
				<?php 
				if(isset($_SESSION['loggedIn'])) {
					if($_SESSION['accessLevel'] == 'agent' ||
						$_SESSION['accessLevel'] == 'admin') {
						include "pages/edit-property.php";
					}
				}
			 ?>
			</div>
		</div>
		<div id="propertiesContainer">
			<div id="lblPropertiesListHeader">
				<h1 id="lblPropertiesListTitle">Copenhagen listings - <span id="lblNumberOfProperties">0</span> found</h1>
				<?php 
				if(isset($_SESSION['loggedIn'])) {
					if($_SESSION['accessLevel'] == 'agent' ||
						$_SESSION['accessLevel'] == 'admin') {
						echo '<button id="btnAddNewProperty" class="big-button hvr-grow hvr-push">Add property</button>';
					}
				} ?>
			</div>
			<div id="lblPropertiesCards">

			</div>
		</div>
	</div>
<!-- ************************************************** -->
<!-- END OF PROPERTIES PAGE -->
<!-- ************************************************** ************************************************** -->

<!-- ************************************************** ************************************************** -->
<!-- ACCOUNT PAGE -->
<!-- ************************************************** -->
	<div id="wdw-account" class="wdw">
	<center>extra feature - to be implemented</center>
	</div>
<!-- ************************************************** -->
<!-- END OF ACCOUNT PAGE -->
<!-- ************************************************** ************************************************** -->

<?php 

	if(isset($_SESSION['loggedIn'])) {
		if($_SESSION['accessLevel'] == 'admin') {
			include "pages/users.php";
		}
	}
 ?>

</div> <!-- end of wrapper, don't put anything with height below -->
	<script src="style/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="style/sweetalert.css">
	<script src="https://maps.googleapis.com/maps/api/js?key="> // GOOGLE API KEY </script> 
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="pages/js/main.js"></script>
	<?php if(isset($_SESSION['loggedIn'])) {
					if($_SESSION['accessLevel'] == 'agent' ||
						$_SESSION['accessLevel'] == 'admin') {
						echo '<script src="pages/js/agent-m54b4S6b66exB64xex46bx_-_xb5rx5rbxsb7.js"></script>';
					} 
					if ($_SESSION['accessLevel'] == 'admin') {
						echo '<script src="pages/js/admin-12395c35wCwZw5_-_3cww53cWWd15yh6hbd.js"></script>';
					}
				} ?>
	<script>
		var lastPropertyTime = 0;
		fnHideAllOpenOneWindow("wdw-properties"); 
		fnFetchProperties(lastPropertyTime, false);
	</script>
</body>
</html>