<!DOCTYPE HTML>
<html>
<head>


	<title> My Bookings</title>
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
	$query = "SELECT member_id, booking_id, Fname, status, booking_start FROM bookings NATURAL JOIN member WHERE member_id=?";


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
	//delete booking
	   	if(isset($_POST['delete'])){

    // include database connection
		include_once 'config/connection.php'; 

		$propertyToDelete = $_POST['zambia'];


        // Insert
		$sql = "DELETE FROM bookings WHERE booking_id = $propertyToDelete";
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
			<li > <image src ="images/house.jpg"/> <p>  STATUS: <?= $row["status"] ?> &emsp; Start DATE: <?= $row["booking_start"] ?>  </p> </li>
			<?php } ?>
		</ul>
	</div>
	<div class="wrapper">
		<button class="btn btn-md btn-primary btn-block" type="button" id='delete_property'> Delete a Booking</button> 
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
					 <textarea name="zambia" maxlength"0" id="zambia" > <?= $row["booking_id"] ?></textarea>
					 <input type="submit" id="delete" name="delete" class="btn btn-md btn-primary btn-block smallMargin" value="Delete"> </button> </li>
					<?php }

					$propertyToDelete = $row["booking_id"];
					 ?>
				</ul>
				</form>
			</div>
		</center>
	</div>

</body>

</html>