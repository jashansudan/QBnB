<!DOCTYPE HTML>
<html>
<head>


	<title> My Properties</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="properties.css">
	<link href="css/simple-sidebar.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script type="text/javascript" src="effects.js"></script>


</head>
<body>
	<?php
  //Create a user session or resume an existing one
	session_start();
	?>

	<?php

	include_once 'config/connection.php'; 

			    // SELECT query
	$query = "SELECT member_id, Fname, address, district, type FROM rental_properties NATURAL JOIN member WHERE member_id=?";


			        // prepare query for execution
	$stmt = $con->prepare($query);


			        // bind the parameters. This is the best way to prevent SQL injection hacks.
	$stmt->bind_Param("s", $_SESSION['member_id']);

			        // Execute the query
	$stmt->execute();


			                // results 
	$result = $stmt->get_result();

			        // Row data
	$myrow = $result->fetch_assoc();
	?>


	<?php


//add a property
	if(isset($_POST['createProperty'])){

    // include database connection
		include_once 'config/connection.php'; 

		$member_id = $myrow['member_id'];
		$address = $_POST['address'];
		$district = $_POST['district'];
		$type = $_POST['type'];
		$rate = $_POST['rate'];


        // Insert
		$sql = "INSERT INTO rental_properties (member_id, address, district, type, rate)
		VALUES('$member_id', '$address', '$district', '$type', '$rate')";


        // prepare query for execution
		$retval = $con->query($sql);

		if (!$retval){
			echo "could not create property";
		}
		else {
			echo "Property Created!";
			
		}

	}

	?>



	<?php
	//delete property
	   	if(isset($_POST['delete'])){

    // include database connection
		include_once 'config/connection.php'; 

		$propertyToDelete = $_POST['zambia'];


        // Insert
		$sql = "DELETE FROM rental_properties WHERE address = '$propertyToDelete'";
		echo $propertyToDelete;


        // prepare query for execution
		$retval = $con->query($sql);

		if (!$retval){
			echo "oops";
		}
		else {
			echo "Property Deleted!";
			
		}

	}

	?>


	<div id="sidebar-wrapper">
		<ul class="sidebar-nav">
			<li class="sidebar-brand">
				<a href="#">
					Welcome  <?php echo $myrow['Fname']; ?>
				</a>
			</li>
						<li>
				<a href="dashboard.php">Dashboard</a>
			</li>
			<li>
				<a href="search.php">All Listings</a>
			</li>
			<li>
				<a href="properties.php">My Properties</a>
			</li>
			<li>
				<a href="bookings.php">My Bookings</a>
			</li>
			<li>
				<a href="settings.php">Account Setting</a>
			</li>
		</ul>
	</div>
	<div class="property-list">
		<ul style="list-style-type:none">
			<?php
			foreach ($result as $row) { ?> 
			<li > <image src ="images/house.jpg"/> <p> ADDRESS:  <?= $row["address"] ?> &emsp; DISTRICT: <?= $row["district"] ?> &emsp; TYPE: <?= $row["type"] ?>  </p> </li>
			<?php } ?>
		</ul>
	</div>
	<div class="wrapper">
		<button class="btn btn-md btn-primary btn-block" type="button" id='add_property'> Add New Property</button> 
		<button class="btn btn-md btn-primary btn-block" type="button" id='delete_property'> Delete a Property</button> 
	</div> 
	<div>
		<center>
			<div id = "propertyform">
				<form method = "post" action = "<?php $_PHP_SELF ?>">
					<p>Add a New QBnB Booking</p>

					<input type = "image" id = "close_property" src = "images/close.png">
					<input type = "text" id = "address" placeholder = "Address" name = "address" required>
					<input type = "text" id = "district" placeholder = "District" name = "district" required>
					<input type = "text" id = "type" placeholder = "Property Type" name = "type" required>
					<input type = "text" size="9" id = "rate" placeholder = "Rent" name = "rate" required>
					<input type = "submit" id = "createProperty" value = "Create Property" name = "createProperty" <a href="#"></a>>
				</form>
			</div>
		</center>
	</div>


	<div>
		<center>
			<div id = "deletepropertyform">
			<form method = "post" action = "<?php $_PHP_SELF ?>">
			<input type = "image" id = "close_property_del" src = "images/close.png">
				<ul style="list-style-type:none">
					<?php
					foreach ($result as $row) { ?> 
					 <li>
					 <textarea rows="0" cols="0" name="zambia" maxlength"0" id="zambia"> <?= $row["address"] ?></textarea>
					 <input type="submit" id="delete" name="delete" class="btn btn-md btn-primary btn-block smallMargin" value="Delete"> </button> </li>
					<?php }

					 ?>
				</ul>
				</form>
			</div>
		</center>
	</div>

</body>

</html>