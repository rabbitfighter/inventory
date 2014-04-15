<?php

session_start();

include("inc/header.php");

$howmany = 0;

if($_SESSION["loggedin"] == true) {
	// if no report link clicked just show report list
	if(is_null($_GET["report"]) && is_null($_POST["query"])) {
		echo "
		<div class='well'>
		<ul>
			<li><a href='reports.php?report=no_price'>Assets with no price</a></li>
			<li><a href='reports.php?report=no_date'>Assets with no purchase date</a></li>
			<li><a href='reports.php?report=no_serial'>Assets with no serial number</a></li>
			<li><a href='reports.php?report=replace_by_year'>Assets to be replaced by year</a></li>
			<li><a href='reports.php?report=purchased_between'>2013 purchases</a></li>
			<li><a href='reports.php?report=retired'>Retired Assets</a></li>
		</ul>
		</div>
		<div class='well'>
		<form action='reports.php' method='post' class='form form-horizontal'>
			
			<!-- Date Purchased From -->
			<div class='form-group'>
			<label for='date_purchased_from' class='col-sm-2 control-label'>Date Purchased (from):</label>
			<div class='col-sm-4'>
			<input type='date' class='form-control' name='date_purchased_from' id='date_purchased_from'>
			</div>
			</div>
			
			<!-- Date Purchased To -->
			<div class='form-group'>
			<label for='date_purchased_to' class='col-sm-2 control-label'>Date Purchased (to):</label>
			<div class='col-sm-4'>
			<input type='date' class='form-control' name='date_purchased_to' id='date_purchased_to'>
			</div>
			</div>
			
			<!-- Price -->
			<div class='form-group'>
			<label for='price' class='col-sm-2 control-label'>Price:</label>
			<div class='col-sm-1'>
			<select name='symbol' class='form-control'>
			<option value='<'><</option>
			<option value='<='><=</option>
			<option value='='>=</option>
			<option value='>'>></option>
			<option value='>='><=</option>
			</select>
			</div>
			<div class='col-sm-3'>
			<input type='text' class='form-control' name='price' id='price' placeholder='enter whole number (without $)'>
			</div>
			</div>
			
			<div class='form-group'>
			<label for='type' class='col-sm-2 control-label'>Group</label>
			<div class='col-sm-4'>
			<select name='type' class='form-control'>
			<option value=''>n/a</option>";

			$query = "SELECT DISTINCT type FROM items WHERE type <> '' ORDER BY type ASC";
			$result = $mysqli->query($query);
			while ($row = mysqli_fetch_array($result)) {
				echo "<option value='" . $row["type"] . "'>" . $row["type"] . "</option>";
			}

			echo "
			</select>
			</div>
			</div>
			
			<!-- Submit -->
			<div class='form-group'>
			<div class='col-sm-offset-2 col-sm-10'>
			<button type='submit' name='query' class='btn btn-primary'>Run Query</button>
			</div>
			</div>
			
		</form>
		</div>";
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
	// or, run the query
	else if(isset($_POST["query"])) {
	
		/*foreach($_POST as $name => $value) {
			print "$name : $value<br>";
		}*/
	
		$query_parts = array();
		
		$date_purchased_from = $_POST["date_purchased_from"];
		$date_purchased_to = $_POST["date_purchased_to"];
		
		// if date_from is set but date_to is not, set date_to to today
		if ($date_purchased_from != '' && $date_purchased_to == '') {
			$date_purchased_to = date("Y-m-d");
		}
		
		$symbol = $_POST["symbol"];
		$price = $_POST["price"];
		$type = $_POST["type"];
		
		if($date_purchased_from != '') {
			$query_parts[] = "date_purchased >= '$date_purchased_from' AND date_purchased <= '$date_purchased_to'";
		}
		
		if($price != '') {
			$query_parts[] = "price $symbol '$price'";
		}
		
		if($type != '') {
			$query_parts[] = "type = '$type'";
		}
		
		$query_add = implode(' AND ',$query_parts);
		$query = "SELECT * FROM items WHERE $query_add";
		
		//echo $query;
		$result = $mysqli->query($query);
		$howmany = mysqli_num_rows($result);
		
		echo "
		$howmany results returned..<br>
		<table id='sortable' class='table table-striped'>
			<thead>
			<tr>
				<th>Asset ID</th>
				<th>Hostname</th>
				<th>Description</th>
				<th>Date Purchased</th>
				<th>Price</th>
				<th>Group</th>
				<th>Location</th>
				<th></th>
			</tr>
			</thead>
			<tbody>";
		
		while($row = mysqli_fetch_array($result)) {
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
		echo "</tbody></table>";

		
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
