<?php

session_start();

include("inc/header.php");

$howmany = 0;

if($_SESSION["loggedin"] == true) {
	// if no report link clicked just show report list
	if(is_null($_GET["report"]) && is_null($_POST["query"])) {
		echo "
		<div class='col-md-6'>
		<div class='well'>
		<b>Custom Query</b><br><br>
		<form action='reports.php' method='post' class='form form-horizontal'>
			
			<!-- Date Purchased From -->
			<div class='form-group'>
			<label for='date_purchased_from' class='col-sm-4 control-label'>Date Purchased (from):</label>
			<div class='col-sm-8'>
			<input type='date' class='form-control' name='date_purchased_from' id='date_purchased_from'>
			</div>
			</div>
			
			<!-- Date Purchased To -->
			<div class='form-group'>
			<label for='date_purchased_to' class='col-sm-4 control-label'>Date Purchased (to):</label>
			<div class='col-sm-8'>
			<input type='date' class='form-control' name='date_purchased_to' id='date_purchased_to'>
			</div>
			</div>
			
			<!-- Support expires -->
			<div class='form-group'>
			<label for='support_expires' class='col-sm-4 control-label'>Support Expiration Date</label>
			<div class='col-sm-2'>
			<select name='symbol_expiration' class='form-control'>
			<option value='<'><</option>
			<option value='<='><=</option>
			<option value='='>=</option>
			<option value='>'>></option>
			<option value='>='><=</option>
			</select>
			</div>
			<div class='col-sm-6'>
			<input type='date' class='form-control' name='support_expires' id='support_expires'>
			</div>
			</div>

			
			<!-- Price -->
			<div class='form-group'>
			<label for='price' class='col-sm-4 control-label'>Price:</label>
			<div class='col-sm-2'>
			<select name='symbol_price' class='form-control'>
			<option value='<'><</option>
			<option value='<='><=</option>
			<option value='='>=</option>
			<option value='>'>></option>
			<option value='>='><=</option>
			</select>
			</div>
			<div class='col-sm-6'>
			<input type='text' class='form-control' name='price' id='price' placeholder='enter whole number (without $)'>
			</div>
			</div>
			
			<!-- Group -->
			<div class='form-group'>
			<label for='type' class='col-sm-4 control-label'>Group</label>
			<div class='col-sm-8'>
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
			
			<!-- Vendor -->
			<div class='form-group'>
			<label for='vendor' class='col-sm-4 control-label'>Vendor</label>
			<div class='col-sm-8'>
			<select name='vendor' class='form-control'>
			<option value=''>n/a</option>";

			$query = "SELECT DISTINCT vendor FROM items WHERE vendor <> '' ORDER BY vendor ASC";
			$result = $mysqli->query($query);
			while ($row = mysqli_fetch_array($result)) {
				echo "<option value='" . $row["vendor"] . "'>" . $row["vendor"] . "</option>";
			}

			echo "
			</select>
			</div>
			</div>
			
			<!-- Location -->
			<div class='form-group'>
			<label for='location' class='col-sm-4 control-label'>Location</label>
			<div class='col-sm-8'>
			<select name='location' class='form-control'>
			<option value=''>n/a</option>";

			$query = "SELECT DISTINCT location FROM items WHERE location <> '' ORDER BY location ASC";
			$result = $mysqli->query($query);
			while ($row = mysqli_fetch_array($result)) {
				echo "<option value='" . $row["location"] . "'>" . $row["location"] . "</option>";
			}

			echo "
			</select>
			</div>
			</div>
			
			<!-- Submit -->
			<div class='form-group'>
			<div class='col-sm-offset-4 col-sm-8'>
			<button type='submit' name='query' class='btn btn-primary'>Run Query</button>
			</div>
			</div>
			
		</form>
		</div>
		</div>
		<div class='row'>
  		<div class='col-md-6'>
		<div class='well'>
		<b>Pre-configured Reports</b><br><br>
		<ul>
			<li><a href='reports.php?report=no_date'>Assets with no purchase date</a></li>
			<li><a href='reports.php?report=no_serial'>Assets with no serial number</a></li>
			<li><a href='reports.php?report=retired'>Retired Assets</a></li>
		</ul>
		</div>
		</div>";
	}
	// otherwise, show requested report
	else if(isset($_GET["report"])) {
		$data = getReport($_GET["report"],$mysqli);
		echo "
		<div class='alert alert-info'>
		$howmany results returned..
		</div>
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
		echo "
			</tbody>
		</table>";
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
		
		$symbol_expiration = $_POST["symbol_expiration"];
		$support_expires = $_POST["support_expires"];
		$symbol_price = $_POST["symbol_price"];
		$price = $_POST["price"];
		$type = $_POST["type"];
		$vendor = $_POST["vendor"];
		$location = $_POST["location"];
		
		
		if($date_purchased_from != '') {
			$query_parts[] = "date_purchased >= '$date_purchased_from' AND date_purchased <= '$date_purchased_to'";
		}
		
		if($support_expires != '') {
			$query_parts[] = "support_expires $symbol_expiration '$support_expires'";
		}
		
		if($price != '') {
			$query_parts[] = "price $symbol_price '$price'";
		}
		
		if($type != '') {
			$query_parts[] = "type = '$type'";
		}
		
		if($vendor != '') {
			$query_parts[] = "vendor = '$vendor'";
		}
		
		if($location != '') {
			$query_parts[] = "location = '$location'";
		}
		
		$query_add = implode(' AND ',$query_parts);
		$query = "SELECT * FROM items WHERE $query_add";
		
		echo "<!-- $query -->";
		$result = $mysqli->query($query);
		$howmany = mysqli_num_rows($result);
		
		echo "
		<div class='alert alert-info'>
		$howmany results returned for query:<br>
		$query
		</div>
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
		echo "
			</tbody>
		</table>";

		
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
