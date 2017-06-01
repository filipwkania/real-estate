<div id="lblNewPropertyClose"><span id="btnCloseProperty" class="fa fa-fw fa-remove"></span></div>
<h1 id="lblSmallTitle">Add new property</h1>
<div class="inputRow no-bg">
	<div id="lblNewPropertyMessage"></div>
</div>
<form id="formNewProperty" enctype="multipart/form-data">
	<input id="txtNewPropertyId" type="hidden" name="id">
	<div class="inputRow">
		<span class="fa fa-fw fa-map-marker"></span>
		<input id="txtNewPropertyAddress" class="big-input transparent field" placeholder="address" name="address" required></input>
		<label class="floating-label"> Address:</label>
	</div>
	<div class="inputRow">
		<span class="fa fa-fw fa-money"></span>
		<input id="txtNewPropertyPrice" class="big-input transparent field" placeholder="price" name="price" required></input>
		<label class="floating-label"> Price in DKK:</label>
	</div>
	<div class="inputRow">
		<span class="fa fa-fw fa-area-chart"></span>
		<input id="txtNewPropertyArea" class="big-input transparent field" placeholder="area" name="area" required></input>
		<label class="floating-label"> Area in m2:</label>
	</div>
	<div class="inputRow">
		<span class="fa fa-fw fa-bed"></span>
		<input id="txtNewPropertyRooms" class="big-input transparent field" placeholder="rooms" name="rooms" required></input>
		<label class="floating-label"> Number of rooms:</label>
	</div>
	<div class="inputRow center">
		<select id="selectPropertyType" name="type">
			<option value="house">House</option>
			<option value="apartment">Apartment</option>
			<option value="office">Office</option>
			<option value="land">Land</option>
		</select>
	</div>
	<div class="inputRow no-bg">
		<input class="images" type="file" name="img[]" multiple>
	</div>
</form>
<button id="btnSaveNewProperty" class="big-button hvr-grow hvr-push">Save</button>
