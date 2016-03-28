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
        $sql = "SELECT * FROM Rental_Properties WHERE member_id <> $member_id";
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

                        <div class="dropdown">

                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" name='district'>District
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">

                              <li onclick="$('#district').val('disLow'); $('#searchForm').submit()"><a href="#">Lowest - Highest </a></li>

                              <li><a href="#">Highest - Lowest</a></li>

                            </ul>

                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Features
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                              <li><a href="#">Least - Most</a></li>
                              <li><a href="#">Most - Least</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Price
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                              <li><a href="#">Lowest - Highest</a></li>
                              <li><a href="#">Highest - Lowest</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Type
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                              <li><a href="#">Condo</a></li>
                              <li><a href="#">House</a></li>
                              <li><a href="#">Apartment</a></li>
                              <li><a href="#">Room</a></li>
                            </ul>
                        </div>
                        <br>
                        <br>
                        <br>

                        <?php
                            if(isset($_POST['disLow']) && isset($_SESSION['member_id'])){
                                include_once 'config/connection.php'; 
                                echo "we good";
                                $newQuery = "SELECT * FROM Rental_Properties 
                                WHERE member_id <> $member_id
                                ORDER BY 'district'";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();
                                while($row = $result->fetch_assoc()){
                                    echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                    echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . "<br>";
                                    echo "<br> <br> <br>";
                                }
                            }
                            else {
                            while($row = $result->fetch_assoc()){
                                echo "<img src ='images/house.png' height='200' width='300'> " . "<br>";
                                echo "Address: " . $row['address'] . ", Type: " . $row['type'] . ", Price/week: " . $row['rate'] . "<br>";
                                echo "<br> <br> <br>";

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

</body>

</html>