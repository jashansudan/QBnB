<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="search.css">

    <title>QBnB Admin page 🔥</title>

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
        $query = "SELECT * FROM Member WHERE member_id=?";
 
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
        if($myrow['admin'] != 1){
            header("Location: index.php");
        }
        
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
                        <h1>Welcome to QBnB</h1>
                        <br> <br> <br>
                        <H3>  WE <strong> DON'T </strong> KNOW WHY YOU ARE <strong> HERE </strong> <h3>
                        <H6> Why are you using QBnB instead of AirBnB?</H6>
                        <H6> Anyways, take a look around, this site is pretty 🔥 !!! </H6>

                        <h4> Do dat admin thhang </h4>


                        delete a member and all their accomodations
                        delete an accomdation
                        smmarize bookings and ratings per accomdaion
                        sumamrize bookings and ratings per supplier
                        summarize booking activity per consumer


                        <h3> Actions </h3>
                        <div>
                        <form action ="<?php $_PHP_SELF ?>" method = "post">

                        <div class="dropdown">

                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" name='district'>Delete 
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

                              <li><input type='submit' class='form-control btn btn-link' name = 'priceLow' value='Lowest - Highest'></li>
                              <li><input type='submit' class='form-control btn btn-link' name = 'priceHigh' value='Highest - Lowest'></li>

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
                        <!-- <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a> -->
                    	<a href="index.php?logout=1">Log Out</a><br/>
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