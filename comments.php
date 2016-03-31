<!DOCTYPE HTML>
<html>
<head>


	<title> My Properties</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="properties.css">
	<link href="css/simple-sidebar.css" rel="stylesheet">
	<link href="comments.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script type="text/javascript" src="effects.js"></script>


</head>
<body>
	<?php
  //Create a user session or resume an existing one
	session_start();
	?>

	<?php

	if(isset($_SESSION['member_id'])){

		include_once 'config/connection.php';
		$property_id = $_GET["propid"];

			    // SELECT query
		$query = "SELECT member_id, Fname, reply, property_id, comment_id, comment_text, rating FROM comments NATURAL JOIN member WHERE property_id=$property_id";


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


	} else {
    //User is not logged in. Redirect the browser to the login index.php page and kill this page.
		header("Location: index.php");
		die();
	}
	?>

	<?php
//add a property
	if(isset($_POST['add_reply'])){

    // include database connection
		include_once 'config/connection.php'; 

		$reply = $_POST['reply_text'];
		$comment_id = $_POST['comment_id'];
        // Insert
        $sql = "UPDATE comments SET reply='$reply' WHERE comment_id=$comment_id";


        // prepare query for execution
		$retval = $con->query($sql);


	}

	?>
	<?php
	if(isset($_SESSION['member_id'])){

	include_once 'config/connection.php';
	$member_id = $_SESSION['member_id'];
	$newquery = "SELECT member_id, Fname FROM Member WHERE member_id=$member_id";

        // prepare query for execution
            $newstmt = $con->prepare($newquery);

        // bind the parameters. This is the best way to prevent SQL injection hacks.


        // Execute the query
            $newstmt->execute();

        // results 
            $newresult = $newstmt->get_result();

        // Row data
            $newrow = $newresult->fetch_assoc();
}
	?>


		<?php
//add a property
	if(isset($_POST['add_comment'])){

    // include database connection
		include_once 'config/connection.php'; 

		$comment = $_POST['theComment'];
		$rating = $_POST['rating'];
		$proper_id = $_GET['propid'];
		$membid = $_SESSION['member_id'];
        // Insert
        $sql = "INSERT INTO comments (member_id, property_id, rating, comment_text, reply)
		VALUES('$membid', '$proper_id', '$rating', '$comment', null)";

        // prepare query for execution
		$retval = $con->query($sql);


	}

	?>


	<div id="sidebar-wrapper">
		<ul class="sidebar-nav">
			<li class="sidebar-brand">
				<a href="#">
                        Welcome  <?php echo $newrow['Fname']; ?>
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
			<li>
                <a href="index.php?logout=1">Log Out</a>
            </li>
		</ul>
	</div>
	<div  class="property-list"  id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <ul style="list-style-type:none">
			<h1>COMMENTS</h1>
			<?php

			foreach ($result as $row) { ?> 
			<li  ><p> USER: <?= $row["Fname"]?> <br> RATING: <?= $row["rating"] ?> <br> COMMENT: <?= $row["comment_text"]?> <br></p>
			<?php
				if($row["reply"] == null){
					?> &emsp;
						<form method="post"> 
						<input type="hidden" value="<?= $row['comment_id'] ?>" id="comment_id" name="comment_id"></input>
						<input type="text" value="Add Reply" id="reply_text" name="reply_text"></input>
					 <input type="submit" id="add_reply" name="add_reply" value="Reply"></input><br><br><br>

					 </form>

					 <?php
				}
				else{
				?>	&emsp; Owner Reply: <?= $row["reply"] ?> <br><br><br>
				<?php
				}	?>

			</li>
			<?php } ?>
		</ul>
                        <!-- <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!--
	<div class="property-list">
		<ul style="list-style-type:none">
			<h1>COMMENTS</h1>
			<?php

			foreach ($result as $row) { ?> 
			<li  ><p> USER: <?= $row["Fname"]?> <br> RATING: <?= $row["rating"] ?> <br> COMMENT: <?= $row["comment_text"]?> <br></p>
			<?php
				if($row["reply"] == null){
					?> &emsp;
						<form method="post"> 
						<input type="hidden" value="<?= $row['comment_id'] ?>" id="comment_id" name="comment_id"></input>
						<input type="text" value="Add Reply" id="reply_text" name="reply_text"></input>
					 <input type="submit" id="add_reply" name="add_reply" value="Reply"></input><br><br><br>

					 </form>

					 <?php
				}
				else{
				?>	&emsp; Owner Reply: <?= $row["reply"] ?> <br><br><br>
				<?php
				}	?>

			</li>
			<?php } ?>
		</ul>
	</div>
-->
	<div class="property-list">
		<center>
	<h2>Add a Comment</h2><br>
</center>
	<center>
		<form method="post"> 
		<input type="hidden" value="<?= $row['property_id'] ?>" id="properid" name="properid"></input>
		<input type="hidden" value="<?= $row['member_id'] ?>" id="membid" name="membid"></input>
					 <input type="text" value="Comment" id="theComment" name="theComment"></input><br>
					 <input type="text" value="Rating (1-5)" id="rating" name="rating"></input><br>
					 <input class = 'btn btn-primary' type="submit" id="add_comment" name="add_comment" value="Submit"></input><br><br>

					 </form>
		</center
	</div>


</body>

</html>