<?php

session_start();

include("inc/header.php");

$howmany = 0;

if($_SESSION["loggedin"] == true) {
	// if no report link clicked just show report list
	if(is_null($_GET["report"])) {
		echo "
		<div class='well'>
		<ul>
			<li><a href='reports.php?report=no_price'>Assets with no price</a></li>
			<li><a href='reports.php?report=no_date'>Assets with no purchase date</a></li>
			<li><a href='reports.php?report=no_serial'>Assets with no serial number</a></li>
			<li><a href='reports.php?report=replace_by_year'>Assets to be replaced by year</a></li>
			<li><a href='reports.php?report=purchased_between'>2013 purchases</a></li>
			<li><a href='reports.php?report=retired'>Retired Assets</a></li>
		</ul>";
	}
	// otherwise, show requested report
	else if(isset($_GET["report"])) {
		$data = getReport($_GET["report"],$mysqli);
		echo "
		<table class='table table-striped'>
			<tr>
				<td colspan='8'>$howmany results returned..</td>
			</tr>
			<tr>
				<th>Asset ID</th>
				<th>Hostname</th>
				<th>Description</th>
				<th>Date Purchased</th>
				<th>Price</th>
				<th>Group</th>
				<th>Location</th>
				<th></th>
			</tr>";
		while ($row = mysqli_fetch_array($data)) {
			echo "<tr>
			<td>" . $row["asset_ID"] . "</td>
			<td>" . $row["hostname"] . "</td>
			<td>" . $row["description"] . "</td>
			<td>" . $row["date_purchased"] . "</td>
			<td>" . $row["price"] . "</td>
			<td>" . $row["type"] . "</td>
			<td>" . $row["location"] . "</td>
			<td><a href='item.php?action=edit&asset_id=" . $row["asset_ID"] . "'><i class='icon-edit'></i></a></td></tr>";
		}
		echo "</table>";
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


// FUNCTIONS

function getReport($report,$mysqli) {

	global $howmany;

	if($report == "no_price") {
		$query = "SELECT * FROM items WHERE price='0'";
	}
	else if ($report == "no_date") {
		$query = "SELECT * FROM items WHERE date_purchased=''";
	}
	else if ($report == "no_serial") {
		$query = "SELECT * FROM items WHERE service_tag_serial=''";
	}
	else if ($report == "purchased_between") {
		$query = "SELECT * FROM items WHERE date_purchased > '2012-12-31' AND date_purchased < '2014-01-01' ORDER BY date_purchased ASC";
	}
	else if ($report == "retired") {
		$query = "SELECT * FROM items WHERE retired != '0000-00-00' ORDER BY retired ASC";
	}
	//echo $query . "<br>";
	$result = $mysqli->query($query);
	$howmany = mysqli_num_rows($result);
	return $result;
}

?>
