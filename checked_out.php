<?php

session_start();

include("inc/header.php");

if($_SESSION["loggedin"] == true) {
	
	echo "
	<div class='well'>
	<table class='table table-striped'>";
	
	echo "
    <tr>
        <th>Asset ID</th>
        <th>Group</th>
        <th>Hostname</th>
        <th>Location</th>
        <th>Checkout User</th>
        <th>Checkout Date</th>
        <th></th>
    </tr>";

	
	$query = "SELECT * FROM items WHERE checkout_user != '' ORDER BY checkout_date ASC";
	$result = $mysqli->query($query);
	while ($row = mysqli_fetch_array($result)) {
	
		$asset_id = $row["asset_ID"];
		$type = $row["type"];
		$hostname = $row["hostname"];
		$location = $row["location"];
		$checkout_user = $row["checkout_user"];
		$checkout_date = $row["checkout_date"];
	    
	    echo "
	    <tr>
	        <td>$asset_id</td>
	        <td>$type</td>
	        <td>$hostname</td>
	        <td>$location</td>
	        <td>$checkout_user</td>
	        <td>$checkout_date</td>
	        <td><a href='item.php?action=checkin&asset_id=$asset_id&hostname=$hostname'><i class='icon-check'></i></a></td>
	    </tr>";

	}

	echo "
	</table>
	</div>";

}

// not logged in
else {
	echo "
	<div class='well'>
	Please <a href='index.php'>return to the home page and log in</a>
	</div>";
}

include("inc/footer.html");

?>