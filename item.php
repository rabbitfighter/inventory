<?php

session_start();

include("inc/header.php");

if($_SESSION["loggedin"] == true) {

if(isset($_POST["add"])) {
	
	$return = addItem($mysqli);
	$asset_id = $return[2];
	if($return[1] == "true") {
		$edit = true;
	}
	$message = $return[0];
	
}
elseif(isset($_POST["edit"])) {

	$return = editItem($mysqli);
	$asset_id = $return[2];
	if($return[1] == "true") {
		$edit = true;
	}
	$message = $return[0];
	
}


// FORM FOR ADDING AN ITEM
if($_GET["action"] == 'add') {

	?>
	
	<!-- ROW 1 -->
	<div class='row'>
	<form class='form form-horizontal' name='add_item' method='post' action='item.php'>
	
	<!-- Asset ID -->
	<div class="form-group">
		<label for="asset_id" class="col-sm-2 control-label">Asset ID</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="asset_id" id="asset_id">
		</div>
	</div>
	
	<!-- Name -->
	<div class="form-group">
		<label for="hostname" class="col-sm-2 control-label">Name</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="hostname" id="hostname">
		</div>
	</div>
	
	<!-- Model -->
	<div class="form-group">
		<label for="model" class="col-sm-2 control-label">Model</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name="model" id="model">
		</div>
	</div>
	
	<!-- Description -->
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label">Description</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='description' id="description">
		</div>
	</div>
	
	<!-- Date Purchased -->
	<div class="form-group">
		<label for="date_purchased" class="col-sm-2 control-label">Date Purchased</label>
		<div class="col-sm-10">
		<input type="date" class="form-control" name='date_purchased' id="date_purchased">
		</div>
	</div>
	
	<!-- Price -->
	<div class="form-group">
		<label for="price" class="col-sm-2 control-label">Price</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='price' id="price">
		</div>
	</div>
	
	<!-- Group -->
	<div class="form-group">
		<label for="type" class="col-sm-2 control-label">Group</label>
		<div class="col-sm-10">
		<select name='type' class='form-control'>

		<?php
		$query = "SELECT DISTINCT type FROM items WHERE type <> '' ORDER BY type ASC";
		$result = $mysqli->query($query);
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["type"] . "'>" . $row["type"] . "</option>";
		}
		
		?>

		</select>
		</div>
	</div>
	<div class="form-group">
		<label for="new_group" class="col-sm-2 control-label">New Group</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='new_type' id="new_group" placeholder='leave blank if existing group'>
		</div>
	</div>
	
	<!-- Vendor -->
	<div class="form-group">
		<label for="vendor" class="col-sm-2 control-label">Vendor</label>
		<div class="col-sm-10">
		<select name='vendor' class='form-control'>

		<?php
		$query = "SELECT DISTINCT vendor FROM items WHERE vendor <> '' ORDER BY vendor ASC";
		$result = $mysqli->query($query);
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["vendor"] . "'>" . $row["vendor"] . "</option>";
		}
		
		?>

		</select>
		</div>
	</div>
	<div class="form-group">
		<label for="new_vendor" class="col-sm-2 control-label">New Vendor</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='new_vendor' id="new_vendor" placeholder='leave blank if existing vendor'>
		</div>
	</div>
	
	<!-- location -->
	<div class="form-group">
		<label for="location" class="col-sm-2 control-label">Location</label>
		<div class="col-sm-10">
		<select name='location' class='form-control'>

		<?php
		$query = "SELECT DISTINCT location FROM items WHERE location <> '' ORDER BY location ASC";
		$result = $mysqli->query($query);
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["location"] . "'>" . $row["location"] . "</option>";
		}
		
		?>

		</select>
		</div>
	</div>
	<div class="form-group">
		<label for="new_location" class="col-sm-2 control-label">New Location</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='new_location' id="new_location" placeholder='leave blank if existing location'>
		</div>
	</div>
	
	<!-- user -->
	<div class="form-group">
		<label for="user" class="col-sm-2 control-label">User</label>
		<div class="col-sm-10">
		<select name='user' class='form-control'>

		<?php
		$query = "SELECT DISTINCT user FROM items WHERE user <> '' ORDER BY user ASC";
		$result = $mysqli->query($query);
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["user"] . "'>" . $row["user"] . "</option>";
		}
		
		?>

		</select>
		</div>
	</div>
	<div class="form-group">
		<label for="new_user" class="col-sm-2 control-label">New User</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='new_user' id="new_user" placeholder='leave blank if existing user'>
		</div>
	</div>

	
	<!-- LAN MAC -->
	<div class="form-group">
		<label for="LAN_MAC" class="col-sm-2 control-label">LAN MAC</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='LAN_MAC' id="LAN_MAC">
		</div>
	</div>
	
	<!-- WiFi MAC -->
	<div class="form-group">
		<label for="wifi_MAC" class="col-sm-2 control-label">WiFi MAC</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='wifi_MAC' id="wifi_MAC">
		</div>
	</div>
	
	<!-- Service tag/serial # -->
	<div class="form-group">
		<label for="service_tag_serial" class="col-sm-2 control-label">Service Tag/Serial #</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='service_tag_serial' id="service_tag_serial">
		</div>
	</div>
	
	<!-- LAN MAC -->
	<div class="form-group">
		<label for="processor" class="col-sm-2 control-label">Processor</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='processor' id="processor">
		</div>
	</div>
	
	<!-- LAN MAC -->
	<div class="form-group">
		<label for="RAM" class="col-sm-2 control-label">RAM</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='RAM' id="RAM">
		</div>
	</div>
	
	<!-- LAN MAC -->
	<div class="form-group">
		<label for="support_expires" class="col-sm-2 control-label">Support Expires</label>
		<div class="col-sm-10">
		<input type="date" class="form-control" name='support_expires' id="support_expires">
		</div>
	</div>
	
	<!-- LAN MAC -->
	<div class="form-group">
		<label for="room" class="col-sm-2 control-label">Room</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='room' id="room">
		</div>
	</div>
	
	<!-- LAN MAC -->
	<div class="form-group">
		<label for="static_IP" class="col-sm-2 control-label">Static IP Address</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='static_IP' id="static_IP">
		</div>
	</div>
	
	<!-- Submit -->
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" name='add' class="btn btn-primary">Submit</button>
		</div>
	</div>
	
	</form>
	</div> <!-- END ROW 1 -->
	<br><br>
	<?

}

// FORM FOR EDITING AN ITEM
elseif($_GET["action"] == 'edit' || $edit == true) {

	if(isset($asset_id)) {
		// nothing
	}
	else {
		$asset_id = $_GET["asset_id"];
	}
	$query = "SELECT * FROM items WHERE asset_id='$asset_id'";
	$result = $mysqli->query($query);
	while ($row = mysqli_fetch_array($result)) {
		$hostname = $row["hostname"];
		$model = $row["model"];
		$description = $row["description"];
		$date_purchased = $row["date_purchased"];
		$price = $row["price"];
		$type = $row["type"];
		$vendor = $row["vendor"];
		$location = $row["location"];
		$user = $row["user"];
		$LAN_MAC = $row["LAN_MAC"];
		$wifi_MAC = $row["wifi_MAC"];
		$service_tag_serial = $row["service_tag_serial"];
		$processor = $row["processor"];
		$RAM = $row["RAM"];
		$support_expires = $row["support_expires"];
		$room = $row["room"];
		$static_IP = $row["static_IP"];
	}
	
	
	if(isset($message)) {
		echo "<div class='row'>$message</div> <!-- end row 1 -->";
	}
	
	?>
	
	
	
	<!-- ROW 1 -->
	<div class='row'>
	<form class='form form-horizontal' name='edit_item' method='post' action='item.php'>
	
	<div class='well'>
	<fieldset>
	<legend>Basic Info</legend>
	
	<!-- Asset ID -->
	<input type='hidden' name='asset_id' value='<?php echo $asset_id; ?>'>
	
	<div class="form-group">
		<label for="asset_id" class="col-sm-2 control-label">Asset ID</label>
		<div class="col-sm-10">
		<?php echo $asset_id; ?>
		</div>
	</div>
	
	<!-- Name -->
	<div class="form-group">
		<label for="hostname" class="col-sm-2 control-label">Name</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='hostname' id="hostname" value='<?php echo $hostname; ?>'>
		</div>
	</div>
	
	<!-- Model -->
	<div class="form-group">
		<label for="model" class="col-sm-2 control-label">Model</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='model' id="model" value='<?php echo $model; ?>'>
		</div>
	</div>
	
	<!-- Description -->
	<div class="form-group">
		<label for="description" class="col-sm-2 control-label">Description</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='description' id="description" value='<?php echo $description; ?>'>
		</div>
	</div>
	
	<!-- Date Purchased -->
	<div class="form-group">
		<label for="date_purchased" class="col-sm-2 control-label">Date Purchased</label>
		<div class="col-sm-10">
		<input type="date" class="form-control" name='date_purchased' id="date_purchased" value='<?php echo $date_purchased; ?>'>
		</div>
	</div>
	
	<!-- Price -->
	<div class="form-group">
		<label for="price" class="col-sm-2 control-label">Price</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='price' id="price" value='<?php echo $price; ?>'>
		</div>
	</div>
	</div>
	</fieldset>
	
	
	<!-- Group -->
	<div class='well'>
	<fieldset>
	<legend>Group</legend>
	<div class="form-group">
		<label for="new_group" class="col-sm-2 control-label">Current/New Group</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='current_new_type' id="new_type" value='<?php echo $type; ?>'>
		<p class="help-block">Leave as is or create new Group by entering here.</p>
		</div>
	</div>
	<div class="form-group">
		<label for="type" class="col-sm-2 control-label">Existing Group</label>
		<div class="col-sm-10">
		<select name='existing_type' class='form-control'>
		<option value='na'>n/a</option>

		<?php
		$query = "SELECT DISTINCT type FROM items WHERE type <> '' ORDER BY type ASC";
		$result = $mysqli->query($query);
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["type"] . "'>" . $row["type"] . "</option>";
		}
		
		?>

		</select>
		<p class="help-block">Or, change to other existing Group.</p>
		</div>
	</div>
	</fieldset>
	</div>
	
	<!-- Vendor -->
	<div class='well'>
	<fieldset>
	<legend>Vendor</legend>
	<div class="form-group">
		<label for="new_vendor" class="col-sm-2 control-label">Current/New Vendor</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='current_new_vendor' id="new_vendor" value='<?php echo $vendor; ?>'>
		<p class="help-block">Leave as is or create new Vendor by entering here.</p>
		</div>
	</div>
	<div class="form-group">
		<label for="vendor" class="col-sm-2 control-label">Existing Vendor</label>
		<div class="col-sm-10">
		<select name='existing_vendor' class='form-control'>
		<option value='na'>n/a</option>

		<?php
		$query = "SELECT DISTINCT vendor FROM items WHERE vendor <> '' ORDER BY vendor ASC";
		$result = $mysqli->query($query);
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["vendor"] . "'>" . $row["vendor"] . "</option>";
		}
		
		?>

		</select>
		<p class="help-block">Or, change to other existing Vendor.</p>
		</div>
	</div>
	</fieldset>
	</div>
	
	
	<!-- location -->
	<div class='well'>
	<fieldset>
	<legend>Location</legend>
	<div class="form-group">
		<label for="new_location" class="col-sm-2 control-label">Current/New Location</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='current_new_location' id="new_location" value='<?php echo $location; ?>'>
		<p class="help-block">Leave as is or create new Location by entering here.</p>
		</div>
	</div>
	<div class="form-group">
		<label for="location" class="col-sm-2 control-label">Existing Location</label>
		<div class="col-sm-10">
		<select name='existing_location' class='form-control'>
		<option value='na'>n/a</option>

		<?php
		$query = "SELECT DISTINCT location FROM items WHERE location <> '' ORDER BY location ASC";
		$result = $mysqli->query($query);
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["location"] . "'>" . $row["location"] . "</option>";
		}
		
		?>

		</select>
		<p class="help-block">Or, change to other existing Location.</p>
		</div>
	</div>
	</fieldset>
	</div>
	
	<!-- user -->
	<div class='well'>
	<fieldset>
	<legend>User</legend>
	<div class="form-group">
		<label for="new_user" class="col-sm-2 control-label">Current/New User</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='current_new_user' id="new_user" value='<?php echo $user; ?>'>
		<p class="help-block">Leave as is or create new User by entering here.</p>
		</div>
	</div>
	<div class="form-group">
		<label for="user" class="col-sm-2 control-label">Existing User</label>
		<div class="col-sm-10">
		<select name='existing_user' class='form-control'>
		<option value='na'>n/a</option>

		<?php
		$query = "SELECT DISTINCT user FROM items WHERE user <> '' ORDER BY user ASC";
		$result = $mysqli->query($query);
		while ($row = mysqli_fetch_array($result)) {
			echo "<option value='" . $row["user"] . "'>" . $row["user"] . "</option>";
		}
		
		?>

		</select>
		<p class="help-block">Or, change to other existing User.</p>
		</div>
	</div>
	</fieldset>
	</div>

	<div class='well'>
	<fieldset>
	<legend>Extended Info</legend>

	<!-- LAN MAC -->
	<div class="form-group">
		<label for="LAN_MAC" class="col-sm-2 control-label">LAN MAC</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='LAN_MAC' id="LAN_MAC" value='<?php echo $LAN_MAC; ?>'>
		</div>
	</div>
	
	<!-- WiFi MAC -->
	<div class="form-group">
		<label for="wifi_MAC" class="col-sm-2 control-label">WiFi MAC</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='wifi_MAC' id="wifi_MAC" value='<?php echo $wifi_MAC; ?>'>
		</div>
	</div>
	
	<!-- Service tag/serial # -->
	<div class="form-group">
		<label for="service_tag_serial" class="col-sm-2 control-label">Service Tag/Serial #</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='service_tag_serial' id="service_tag_serial" value='<?php echo $service_tag_serial; ?>'>
		</div>
	</div>
	
	<!-- Processor -->
	<div class="form-group">
		<label for="processor" class="col-sm-2 control-label">Processor</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='processor' id="processor" value='<?php echo $processor; ?>'>
		</div>
	</div>
	
	<!-- RAM -->
	<div class="form-group">
		<label for="RAM" class="col-sm-2 control-label">RAM</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='RAM' id="RAM" value='<?php echo $RAM; ?>'>
		</div>
	</div>
	
	<!-- Support Expires -->
	<div class="form-group">
		<label for="support_expires" class="col-sm-2 control-label">Support Expires</label>
		<div class="col-sm-10">
		<input type="date" class="form-control" name='support_expires' id="support_expires" value='<?php echo $support_expires; ?>'>
		</div>
	</div>
	
	<!-- Room -->
	<div class="form-group">
		<label for="room" class="col-sm-2 control-label">Room</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='room' id="room" value='<?php echo $room; ?>'>
		</div>
	</div>
	
	<!-- Static IP -->
	<div class="form-group">
		<label for="static_IP" class="col-sm-2 control-label">Static IP Address</label>
		<div class="col-sm-10">
		<input type="text" class="form-control" name='static_IP' id="static_IP" value='<?php echo $static_IP; ?>'>
		</div>
	</div>
	</fieldset>
	</div>
	
	<!-- Submit -->
	<div class='well'>
	<div class="form-group">
		<label for="room" class="col-sm-2 control-label">Save Changes</label>
		<div class="col-sm-10">
		<button type="submit" name='edit' class="btn btn-primary">Submit</button>
		</div>
	</div>
	</div>
	
	
	</form>
	<br><br>
	<?


}

// ERROR
else {
	echo "no action specified";
}

}

// not logged in
else {
	echo "
	<div class='well'>
	Please <a href='index.php'>return to the home page and log in</a>
	</div>";
}

include("inc/footer.html");


// --------- //
// FUNCTIONS //
// --------- //

// ADD ITEM //
function addItem($mysqli) {

	// adding an item
	$asset_id = $_POST["asset_id"];
	$hostname = $_POST["hostname"];
	$model = $_POST["model"];
	$description = $_POST["description"];
	$date_purchased = $_POST["date_purchased"];
	$price = $_POST["price"];
	
	$type = $_POST["type"];
	$new_group = $_POST["new_group"];
	if($new_group != "") {
		$type = $new_group;
	}
	
	$vendor = $_POST["vendor"];
	$new_vendor = $_POST["new_vendor"];
	if($new_vendor != "") {
		$vendor = $new_vendor;
	}
	
	$location = $_POST["location"];
	$new_location = $_POST["new_location"];
	if($new_location != "") {
		$location = $new_location;
	}
	
	$user = $_POST["user"];
	$new_user = $_POST["new_user"];
	if($new_user != "") {
		$user = $new_user;
	}
	
	$LAN_MAC = $_POST["LAN_MAC"];
	$wifi_MAC = $_POST["wifi_MAC"];
	$service_tag_serial = $_POST["service_tag_serial"];
	$processor = $_POST["processor"];
	$RAM = $_POST["RAM"];
	$support_expires = $_POST["support_expires"];
	$room = $_POST["room"];
	$static_IP = $_POST["static_IP"];
	
	$query = "INSERT INTO items 
	(asset_id,hostname,model,description,date_purchased,price,type,vendor,location,user,
	LAN_MAC,wifi_MAC,service_tag_serial,processor,RAM,support_expires,room,static_IP)
	VALUES
	('$asset_id','$hostname','$model','$description','$date_purchased','$price','$type','$vendor','$location','$user',
	'$LAN_MAC','$wifi_MAC','$service_tag_serial','$processor','$RAM','$support_expires','$room','$static_IP')";
	
	$result = $mysqli->query($query);
	if($result) {
		$message = "<div class='alert alert-success'>Item added successfully!</div>";
		$return_vals = array($message,"true",$asset_id);
		return $return_vals;
	}
	else {
		echo "<div class='alert alert-error'>Error: " . $mysqli->error . "</div>";
		$itworked = false;
		return $itworked;
	}

}

// EDIT ITEM //
function editItem($mysqli) {

	// editing an item
	//echo "editing..";
	
	$asset_id = $_POST["asset_id"];
	$hostname = $_POST["hostname"];
	$model = $_POST["model"];
	$description = $_POST["description"];
	$date_purchased = $_POST["date_purchased"];
	$price = $_POST["price"];
	$existing_type = $_POST["existing_type"];
	$current_new_type = $_POST["current_new_type"];
	$existing_vendor = $_POST["existing_vendor"];
	$current_new_vendor = $_POST["current_new_vendor"];
	$existing_location = $_POST["existing_location"];
	$current_new_location = $_POST["current_new_location"];
	$existing_user = $_POST["existing_user"];
	$current_new_user = $_POST["current_new_user"];
	$LAN_MAC = $_POST["LAN_MAC"];
	$wifi_MAC = $_POST["wifi_MAC"];
	$service_tag_serial = $_POST["service_tag_serial"];
	$processor = $_POST["processor"];
	$RAM = $_POST["RAM"];
	$support_expires = $_POST["support_expires"];
	$room = $_POST["room"];
	$static_IP = $_POST["static_IP"];
	
	if($existing_type == "na") {
		$type = $current_new_type;
	}
	else {
		$type = $existing_type;
	}
	
	if($existing_vendor == "na") {
		$vendor = $current_new_vendor;
	}
	else {
		$vendor = $existing_vendor;
	}
	
	if($existing_location == "na") {
		$location = $current_new_location;
	}
	else {
		$location = $existing_location;
	}
	
	if($existing_user == "na") {
		$user = $current_new_user;
	}
	else {
		$user = $existing_user;
	}
	
	$query = "UPDATE items SET hostname='$hostname', model='$model',description='$description',
	date_purchased='$date_purchased',price='$price',type='$type',vendor='$vendor',location='$location',
	user='$user',LAN_MAC='$LAN_MAC',wifi_MAC='$wifi_MAC',service_tag_serial='$service_tag_serial',
	processor='$processor',RAM='$RAM',support_expires='$support_expires',room='$room',static_IP='$static_IP' WHERE asset_id='$asset_id'";
	
	//echo "<br><br>$query<br><br>";
	
	$result = $mysqli->query($query);
	if($result) {
		
		$message = "<div class='alert alert-success'>Item edited successfully!</div>";
		$return_vals = array($message,"true",$asset_id);
		return $return_vals;
		
	}
	else {
		echo "<div class='alert alert-error'>Error: " . $mysqli->error . "</div>";
		$itworked = false;
		return $itworked;
	}

}

?>