<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Take a look at these Listings</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/simple-sidebar.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link href="search.css" rel="stylesheet">
    <script type="text/javascript" src="getpropertyid.js"></script>

</head>

<body>

<?php
  //Create a user session or resume an existing one
 session_start();
 ?>
  <?php
if(isset($_SESSION['member_id'])){
   // include database connection
    include_once 'config/connection.php'; 
    
    // SELECT query
        $query = "SELECT member_id, Fname FROM Member WHERE member_id=?";
 
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



        $member_id = $_SESSION['member_id'];
        $sql = "SELECT Rental_Properties.*, GROUP_CONCAT(Features.features SEPARATOR ', ') as features FROM Rental_Properties NATURAL JOIN Features WHERE member_id <> $member_id GROUP BY property_id";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
     
} else {
    //User is not logged in. Redirect the browser to the login index.php page and kill this page.
    header("Location: index.php");
    die();
}
?> 



    <div id="wrapper">

        <!-- Sidebar -->
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
                    <a href="#">Overview</a>
                </li>
                <li>
                    <a href="properties.php">My Properties</a>
                </li>
                <li>
                    <a href="bookings.php">My Bookings</a>
                </li>
                <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="settings.php">Account Setting</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Search Listings</h1>
                        <h3> Sort By</h3>
                        <div>
                        <form action ="<?php $_PHP_SELF ?>" method = "post">

                        <div class="dropdown">

                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" name='district'>District
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">

                              <li> <input type='submit' class='form-control btn btn-link' name = 'disLow' value='Lowest - Highest'> </li>

                              <li> <input type='submit' class= 'form-control btn btn-link' name = 'disHigh' value = 'Highest - Lowest'> </li>

                            </ul>

                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Features
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">

                              <li><input type='submit' class='form-control btn btn-link' name = 'featLow' value='Least - Most'></li>
                              <li><input type='submit' class='form-control btn btn-link' name = 'featHigh' value='Most - Least'></li>

                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Price
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">

                              <li><input type='submit' class='form-control btn btn-link' name = 'priceHigh' value='Highest - Lowest'></li>
                              <li><input type='submit' class='form-control btn btn-link' name = 'priceHigh' value='Lowest - Highest'></li>

                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Type
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">

                              <li><input type='submit' class='form-control btn btn-link' name = 'condo' value='Condo'></li>
                              <li><input type='submit' class='form-control btn btn-link' name = 'house' value='House'></li>
                              <li><input type='submit' class='form-control btn btn-link' name = 'apartment' value='Apartment'></li>
                              <li><input type='submit' class='form-control btn btn-link' name = 'room' value='Room'></li>

                            </ul>
                        </div>

                        <br>
                        <br>
                        <br>
                        </form>
                        </div>
                        <?php
                            if(isset($_POST['disLow']) && isset($_SESSION['member_id'])){
                                include_once 'config/connection.php'; 
                                $newQuery = "SELECT Rental_Properties.*, GROUP_CONCAT(Features.features SEPARATOR ', ') as features FROM Rental_Properties NATURAL JOIN Features WHERE member_id <> $member_id GROUP BY property_id
                                ORDER BY district";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()){
                                    echo "<a href='comments.php'> <img src ='images/house.png' height='200' width='300'>  </a>" . "<br>";
                                    echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . " District: " . $row['district'] . ", Features: " . $row['features'] . "<br>"; ?>
                                    <form  action="comments.php" method = 'get'>
                                    <input type="hidden" name="propid" id="propid" value="<?= $row['property_id'] ?>">
                                    <input type = 'submit' width='600px' height='800px' id = 'viewcomment' value = 'View Comments' name ='viewcomment'>
                                    </form>
                                    <br> <br> <br>
                                    <?php
                                }
                            }
                            elseif(isset($_POST['disHigh']) && isset($_SESSION['member_id'])){
                                include_once 'config/connection.php'; 
                                $newQuery = "SELECT Rental_Properties.*, GROUP_CONCAT(Features.features SEPARATOR ', ') as features FROM Rental_Properties NATURAL JOIN Features WHERE member_id <> $member_id GROUP BY property_id
                                ORDER BY district DESC";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()){
                                    echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                    echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . " District: " . $row['district'] . ", Features: " . $row['features'] . "<br>"; ?>
                                    <form  action="comments.php" method = 'get'>
                                    <input type="hidden" name="propid" id="propid" value="<?= $row['property_id'] ?>">
                                    <input type = 'submit' width='600px' height='800px' id = 'viewcomment' value = 'View Comments' name ='viewcomment'>
                                    </form>
                                    <br> <br> <br>
                                    <?php
                                }
                            }
                            elseif(isset($_POST['featLow']) && isset($_SESSION['member_id'])){

                                 include_once 'config/connection.php'; 
                                $newQuery = "SELECT Rental_Properties.*, GROUP_CONCAT(Features.features SEPARATOR ', ') as features FROM Rental_Properties NATURAL JOIN Features WHERE member_id <> $member_id GROUP BY property_id
                                ORDER BY COUNT(features)";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()){
                                    echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                    echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . " District: " . $row['district'] . ", Features: " . $row['features'] . "<br>"; ?>
                                    <form  action="comments.php" method = 'get'>
                                    <input type="hidden" name="propid" id="propid" value="<?= $row['property_id'] ?>">
                                    <input type = 'submit' width='600px' height='800px' id = 'viewcomment' value = 'View Comments' name ='viewcomment'>
                                    </form>
                                    <br> <br> <br>
                                    <?php
                                }   

                                }

                            elseif(isset($_POST['featHigh']) && isset($_SESSION['member_id'])){

                                include_once 'config/connection.php'; 
                                $newQuery = "SELECT Rental_Properties.*, GROUP_CONCAT(Features.features SEPARATOR ', ') as features FROM Rental_Properties NATURAL JOIN Features WHERE member_id <> $member_id GROUP BY property_id
                                ORDER BY COUNT(features) DESC";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()){
                                    echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                    echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . " District: " . $row['district'] . ", Features: " . $row['features'] . "<br>"; ?>
                                    <form  action="comments.php" method = 'get'> 
                                    <input type="hidden" name="propid" id="propid" value="<?= $row['property_id'] ?>">
                                    <input type = 'submit' width='600px' height='800px' id = 'viewcomment' value = 'View Comments' name ='viewcomment'>
                                    </form>
                                    <br> <br> <br>
                                    <?php
                                }   

                                 }

                            elseif(isset($_POST['priceLow']) && isset($_SESSION['member_id'])){

                                include_once 'config/connection.php'; 
                                $newQuery = "SELECT Rental_Properties.*, GROUP_CONCAT(Features.features SEPARATOR ', ') as features FROM Rental_Properties NATURAL JOIN Features WHERE member_id <> $member_id GROUP BY property_id
                                ORDER BY rate";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()){
                                    echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                    echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . " District: " . $row['district'] . ", Features: " . $row['features'] . "<br>"; ?>
                                    <form  action="comments.php" method = 'get'>
                                    <input type="hidden" name="propid" id="propid" value="<?= $row['property_id'] ?>">
                                    <input type = 'submit' width='600px' height='800px' id = 'viewcomment' value = 'View Comments' name ='viewcomment'>
                                    </form>
                                    <br> <br> <br>
                                    <?php
                                }

                                 }

                            elseif(isset($_POST['priceHigh']) && isset($_SESSION['member_id'])){

                                include_once 'config/connection.php'; 
                                $newQuery = "SELECT Rental_Properties.*, GROUP_CONCAT(Features.features SEPARATOR ', ') as features FROM Rental_Properties NATURAL JOIN Features WHERE member_id <> $member_id GROUP BY property_id
                                ORDER BY rate DESC";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()){
                                    echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                    echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . " District: " . $row['district'] . ", Features: " . $row['features'] . "<br>"; ?>
                                                                        <form  action="comments.php" method = 'get'>
                                    <input type="hidden" name="propid" id="propid" value="<?= $row['property_id'] ?>">
                                    <input type = 'submit' width='600px' height='800px' id = 'viewcomment' value = 'View Comments' name ='viewcomment'>
                                    </form>
                                    <br> <br> <br>
                                    <?php
                                }

                                 }

                            elseif(isset($_POST['condo']) && isset($_SESSION['member_id'])){

                                include_once 'config/connection.php'; 
                                $newQuery = "SELECT Rental_Properties.*, GROUP_CONCAT(Features.features SEPARATOR ', ') as features FROM Rental_Properties NATURAL JOIN Features WHERE member_id <> $member_id and type LIKE '%condo%' GROUP BY property_id";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()){
                                    echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                    echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . " District: " . $row['district'] . ", Features: " . $row['features'] . "<br>"; ?>
                                                                        <form  action="comments.php" method = 'get'>
                                    <input type="hidden" name="propid" id="propid" value="<?= $row['property_id'] ?>">
                                    <input type = 'submit' width='600px' height='800px' id = 'viewcomment' value = 'View Comments' name ='viewcomment'>
                                    </form>
                                    <br> <br> <br>
                                    <?php
                                }

                                 }

                            elseif(isset($_POST['house']) && isset($_SESSION['member_id'])){

                                include_once 'config/connection.php'; 
                                $newQuery = "SELECT Rental_Properties.*, GROUP_CONCAT(Features.features SEPARATOR ', ') as features FROM Rental_Properties NATURAL JOIN Features WHERE member_id <> $member_id and type LIKE '%house%' GROUP BY property_id";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()){
                                    echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                    echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . " District: " . $row['district'] . ", Features: " . $row['features'] . "<br>"; ?>
                                    e                                    <form  action="comments.php" method = 'get'>
                                    <input type="hidden" name="propid" id="propid" value="<?= $row['property_id'] ?>">
                                    <input type = 'submit' width='600px' height='800px' id = 'viewcomment' value = 'View Comments' name ='viewcomment'>
                                    </form>
                                    <br> <br> <br>
                                    <?php
                                }

                                 }

                            elseif(isset($_POST['apartment']) && isset($_SESSION['member_id'])){

                                include_once 'config/connection.php'; 
                                $newQuery = "SELECT Rental_Properties.*, GROUP_CONCAT(Features.features SEPARATOR ', ') as features FROM Rental_Properties NATURAL JOIN Features WHERE member_id <> $member_id and type LIKE '%apartment%' GROUP BY property_id";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()){
                                    echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                    echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . " District: " . $row['district'] . ", Features: " . $row['features'] . "<br>"; ?>
                                                                        <form  action="comments.php" method = 'get'>
                                    <input type="hidden" name="propid" id="propid" value="<?= $row['property_id'] ?>">
                                    <input type = 'submit' width='600px' height='800px' id = 'viewcomment' value = 'View Comments' name ='viewcomment'>
                                    </form>
                                    <br> <br> <br>
                                    <?php
                                }

                                 }
                            
                            elseif(isset($_POST['room']) && isset($_SESSION['member_id'])){

                                include_once 'config/connection.php'; 
                                $newQuery = "SELECT Rental_Properties.*, GROUP_CONCAT(Features.features SEPARATOR ', ') as features FROM Rental_Properties NATURAL JOIN Features WHERE member_id <> $member_id and type LIKE 'room%' GROUP BY property_id";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()){
                                    echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                    echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . " District: " . $row['district'] . ", Features: " . $row['features'] . "<br>"; ?>
                                                                        <form  action="comments.php" method = 'get'>
                                    <input type="hidden" name="propid" id="propid" value="<?= $row['property_id'] ?>">
                                    <input type = 'submit' width='600px' height='800px' id = 'viewcomment' value = 'View Comments' name ='viewcomment'>
                                    </form>
                                    <br> <br> <br>
                                    <?php
                                }

                                }

                            else {
                            while($row = $result->fetch_assoc()){
                                echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . " District: " . $row['district'] . ", Features: " . $row['features'] .  "<br>"; ?>
                                                                    <form  action="comments.php" method = 'get'>
                                    <input type="hidden" name="propid" id="propid" value="<?= $row['property_id'] ?>">
                                    <input type = 'submit' width='600px' height='800px' id = 'viewcomment' value = 'View Comments' name ='viewcomment'>
                                    </form>
                                    <br> <br> <br>
                                    <?php

                            }
                        }
                        
                            
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>

    <?php


//add a property
    if(isset($_POST['viewcomment'])){

    // include database connection
        include_once 'config/connection.php'; 
        $property_id = $_POST['propid'];
        echo $property_id;


        // Insert
         $_SESSION['property_id'] = $property_id;


    }

    ?>


</body>

</html>