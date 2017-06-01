<!-- ************************************************** ************************************************** -->
<!-- USERS PAGE -->
<!-- ************************************************** -->
<div id="wdw-users" class="wdw">
	<div id="lblEditUser">
		<div id="lblNewUserClose"><span id="btnCloseNewUser" class="fa fa-fw fa-remove"></span>
		<h1 id="lblUsersTitle" class="small-title">Create user</h1>
		</div>
		<div class="inputRow no-bg">
			<div id="lblNewUserMessage"></div>
		</div>
		<input id="txtUserId" type="hidden">
		<div class="inputRow">
			<span class="fa fa-fw fa-user"></span>
			<input id="txtNewUserUsername" class="big-input transparent field" placeholder="username" name="username" required></input>
			<label class="floating-label"> Username: 3-20 characters, alphanumeric and . _</label>
		</div>
		<div class="inputRow">
			<span class="fa fa-fw fa-envelope-open"></span>
			<input id="txtNewUserEmail" class="big-input transparent field" placeholder="email" required></input>
			<label class="floating-label"> Email: example@mail.com</label>
		</div>
		<div class="inputRow">
			<span class="fa fa-fw fa-key"></span>
			<input id="txtNewUserPassword" class="big-input transparent field" type="password" placeholder="password" required></input>
			<label class="floating-label"> Password: 7-128 characters, alphanumeric and specials</label>
		</div>
		<div class="inputRow">
			<span class="fa fa-fw fa-key"></span>
			<input id="txtNewUserRepeatPassword" class="big-input transparent field" type="password" placeholder="retype password" required></input>
			<label class="floating-label"> Password: retype password</label>
		</div>
		<div class="inputRow center">
			<select id="selectNewUserAccessLevel">
				<option value="basic">basic</option>
				<option value="agent">agent</option>
				<option value="admin">admin</option>
			</select>
		</div>
		<button id="btnSaveNewUser" class="big-button hvr-grow hvr-push">Save</button>
		<div class="inputRow no-bg"></div>
	</div>
	<div id="lblUsersList">	
		<table id="usersTable" class="table-fill">
			<thead>
				<tr>
					<th class="text-left">Username</th>
					<th class="text-left">Email</th>
					<th class="text-left">Access level</th>
					<th class="text-center">Delete</th>
				</tr>
			</thead>
			<tbody class="table-hover">
			<!-- placeholder for data entries -->
			</tbody>
		</table>
	</div>
</div>
<!-- ************************************************** -->
<!-- END OF USERS PAGE -->
<!-- ************************************************** ************************************************** -->