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

	if(isset($_SESSION['property_id'])){

	include_once 'config/connection.php';
	$property_id = $_GET["propid"];

			    // SELECT query
	$query = "SELECT member_id, FName, property_id, comment_text, rating FROM comments NATURAL JOIN member WHERE property_id=$property_id";


			        // prepare query for execution
	$stmt = $con->prepare($query);


			        // bind the parameters. This is the best way to prevent SQL injection hacks.
	//$stmt->bind_Param("s", $_SESSION['member_id']);

			        // Execute the query
	$stmt->execute();


			                // results 
	$result = $stmt->get_result();

			        // Row data
	$myrow = $result->fetch_assoc();
}
	?>



	<div id="sidebar-wrapper">
		<ul class="sidebar-nav">
			<li class="sidebar-brand">
				<a href="#">
					Welcome  <?php echo $myrow['FName']; ?>
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
			<h1>COMMENTS</h1>
			<?php
			foreach ($result as $row) { ?> 
			<li  ><p> USER: <?= $row["FName"]?> <br> RATING: <?= $row["rating"] ?> <br> COMMENT: <?= $row["comment_text"]?> &emsp;   </p> </li>
			<?php } ?>
		</ul>
	</div>

	</body>

	</html>