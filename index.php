<?php

session_start();

include("inc/header.php");

// process login if submitted
if(isset($_POST["login"])) {
	$username = $_POST["username"];
	$password = $_POST["password"];
	if($username == $site_admin && $password == $site_admin_password) {
		$_SESSION["loggedin"] = true;
	}
}

// if logged in show inventory
if($_SESSION["loggedin"] == true) {

?>


<!-- ROW 1 -->
<div class='row' style='background-color:#f5f5f5;border:1px solid #dcdcdc;border-radius:5px;margin-bottom:30px;padding:10px;'>
<div class="col-md-3">
<form class='form' name='choose' method='post' action='index.php'>
<select name='type' onchange='this.form.submit()' class='form-control col-md-3'>
<option value='all'>Group</option>

<?php
// GROUP FILTER
$query = "SELECT DISTINCT type FROM items";
$result = $mysqli->query($query);
while ($row = mysqli_fetch_array($result)) {
	echo "<option value='" . $row["type"] . "'>" . $row["type"] . "</option>";
}

?>

</select>
</form>
</div>

<div class="col-md-3">
<form class='form' name='choose' action='index.php' method='post'>
<select name='vendor' onchange='this.form.submit()' class='form-control col-md-3'>
<option value='all'>Vendor</option>

<?php
// VENDOR FILTER
$query = "SELECT DISTINCT vendor FROM items";
$result = $mysqli->query($query);
while ($row = mysqli_fetch_array($result)) {
	echo "<option value='" . $row["vendor"] . "'>" . $row["vendor"] . "</option>";
}

?>

</select>
</form>
</div>


<div class="col-md-3">
<form class='form' name='choose' action='index.php' method='post'>
<select name='user' onchange='this.form.submit()' class='form-control col-md-3'>
<option value='all'>User</option>

<?php
// USER FILTER
$query = "SELECT DISTINCT user FROM items";
$result = $mysqli->query($query);
while ($row = mysqli_fetch_array($result)) {
	echo "<option value='" . $row["user"] . "'>" . $row["user"] . "</option>";
}

?>

</select>
</form>
</div>

<!-- SEARCH -->
<div class="col-md-3" style='text-align:right;'>
<form class='form' name='search' action='index.php' method='post'>
<input type='text' name='search' placeholder='search' class='form-control col-md-3'>
</form>
</div>


</div> <!-- END ROW 1 -->
<div class='row'> <!-- ROW 2 -->

<?php
if(isset($_POST["type"])) {
	$type = $_POST["type"];
	$query = "SELECT * FROM items WHERE retired='0000-00-00' AND type='$type'";
}
elseif(isset($_POST["vendor"])) {
	$vendor = $_POST["vendor"];
	$query = "SELECT * FROM items WHERE vendor='$vendor'";
}
elseif(isset($_POST["user"])) {
	$user = $_POST["user"];
	$query = "SELECT * FROM items WHERE user='$user'";
}
elseif(isset($_POST["search"])) {
	$search = $_POST["search"];
	$query = "SELECT * FROM items WHERE 
	asset_id LIKE '%$search%' 
	OR type LIKE '%$search%' 
	OR hostname LIKE '%$search%' 
	OR description LIKE '%$search%' 
	OR user LIKE '%$search%'";
}
else {
	$query = "SELECT * FROM items WHERE retired='0000-00-00' ORDER BY asset_id DESC";
}
$result = $mysqli->query($query);

echo "<table class='table table-striped'>
	<tr>
		<th>Asset_ID</th>
		<th>Group</th>
		<th>Hostname</th>
		<th>Description</th>
		<th>Date_Purchased</th>
		<th>Price</th>
		<th>Vendor</th>
		<th>Location</th>
		<th>User</th>
		<th></th>
		<th></th>
		<th></th>
	</tr>";

while ($row = mysqli_fetch_array($result)) {
	
	$asset_id = $row["asset_ID"];
	$type = $row["type"];
	$hostname = $row["hostname"];
	//$model = $row["model"];
	$description = $row["description"];
	$date_purchased = $row["date_purchased"];
	$price = $row["price"];
	$vendor = $row["vendor"];
	$location = $row["location"];
	$user = $row["user"];
    
    echo "
    <tr>
        <td>$asset_id</td>
        <td>$type</td>
        <td>$hostname</td>
        <td>$description</td>
        <td>$date_purchased</td>
        <td>$price</td>
        <td>$vendor</td>
        <td>$location</td>
        <td>$user</td>
        <td><a href='item.php?action=view&asset_id=$asset_id'><i class='icon-file-alt'></i></a></td>
        <td><a href='item.php?action=edit&asset_id=$asset_id'><i class='icon-edit'></i></a></td>
        <td><a href='item.php?action=retire&asset_id=$asset_id&hostname=$hostname'><i class='icon-remove-sign'></i></a></td>
    </tr>";

}

echo "</table>";

}

// not logged in
else {
	echo "
	<div class='well'>
	<form class='form form-horizontal' name='login' method='post' action='index.php'>
	<fieldset>
	<legend>Login</legend>
	<input type='text' name='username' placeholder='username'>
	<br><br>
	<input type='password' name='password' placeholder='password'>
	<br><br>
	<button type='submit' name='login' class='btn btn-primary'>Authenticate</button>
	</fieldset>
	</form>
	</div>";

}

include("inc/footer.html");

?>
