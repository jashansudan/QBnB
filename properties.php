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
			        $query = "SELECT member_id, address, district, type FROM rental_properties WHERE member_id=?";
			        $query2 = "SELECT member_id, password, email, Fname FROM Member WHERE member_id=?";
			 
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

	        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                       Welcome  <?php echo $myrow['member_id']; ?>
                    </a>
                </li>
                <li>
                    <a href="dashboard.php">Dashboard</a>
                </li>
                <li>
                    <a href="#">Shortcuts</a>
                </li>
                <li>
                    <a href="#">Overview</a>
                </li>
                <li>
                    <a href="properties.php">My Properties</a>
                </li>
                <li>
                    <a href="#">About</a>
                </li>
                <li>
                    <a href="#">Services</a>
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
					<li > <image src ="images/house.jpg"/> <p>  <?= $row["address"] ?>: <?= $row["district"] ?>:<?= $row["type"] ?>  </p> </li>
						<?php } ?>
            </ul>
            </div>
            <div class="wrapper">
	       	<button class="btn btn-md btn-primary btn-block" type="button" id='add_property'> Add New Property</button> 
	       	<button class="btn btn-md btn-primary btn-block" type="button" id='add_property'> Delete A Property</button> 
	       </div> 
	 <div>
	        <center>
	        <div id = "propertyform">
	            <form method = "post" action = "<?php $_PHP_SELF ?>">
	                <p>Add a New QBnB Property</p>

	                <input type = "image" id = "close_property" src = "images/close.png">
	                <input type = "text" id = "address" placeholder = "Address" name = "address" required>
	                <input type = "text" id = "district" placeholder = "District" name = "district" required>
	                <input type = "text" id = "type" placeholder = "Property Type" name = "type" required>
	                <input type = "text" size="9" id = "rate" placeholder = "Rent" name = "rate" required>
	                <input type = "submit" id = "createProperty" value = "Create Property" name = "createProperty">
	            </form>
	        </div>
	        </center>
	</div>
</body>

</html>