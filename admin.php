<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" type="text/css" href="admin.css">

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
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Welcome to QBnB</h1>
                       


                        <h3> Actions </h3>
                        

                        <form method = "post" action = "<?php $_PHP_SELF ?>">
                            <input type = 'submit' name ='dltAcc' class ='btn btn-danger temp' value = 'Delete an account'>
                            <input type = 'submit' name ='dltAcom' class ='btn btn-danger temp' value='Delete an Accomodation'>
                            <input type = 'submit' name ='sumAcc' class ='btn btn-danger temp' value ='Summarize bookings by accodmation'>
                            <input type = 'submit' name ='sumSupp' class ='btn btn-danger temp' value='Summarize bookings per Supplier'>
                            <input type = 'submit' name ='sumCons' class ='btn btn-danger temp' value='Summarize activity per Consumer'>

                        </form>
                        <br>
                        <div>

                            <?php
                            if(isset($_POST['dltAcc']) && isset($_SESSION['member_id'])){
                                include_once 'config/connection.php'; 
                                $member_id = $_SESSION['member_id'];
                                $newQuery = "SELECT * FROM Member WHERE member_id<>$member_id";
                                $stmt = $con->prepare($newQuery);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                
                                while($row = $result->fetch_assoc()){
                                    $del_id = $row['member_id']; ?>
                                    <form action="<?php $_PHP_SELF ?>" method= 'post'>
                                        <input type = 'hidden' name='accDet' id ='accDet' value='<?= $row["member_id"]?>'>
                                        <input class = 'btn btn-primary temp' type='submit' width='600px' id='$row["member_id"]' value = 'Delete Account' name = 'del_id'>
                                    </form>

                                    
                                    <?php 
                                
                                    echo "Member ID: " . $row['member_id'] . ", Name: " . $row['Fname'] . " " . $row['Lname'] . "<br>";


                                }
                        

                            }

                            ?>
                            
                            
                            <?php
                            
                            if(isset($_POST['del_id']) && isset($_SESSION['member_id'])){
                                include_once 'config/connection.php'; 

                                $memb_id = $_POST['accDet'];
                                $sql1= "DELETE * FROM Rental_Properties WHERE member_id =$memb_id";

                                $retval1=$con->query($sql1);
                                $sql2 = "DELETE FROM Member WHERE member_id = $memb_id";
                                $retval2 = $con->query($sql2);
                                
                            } 
                            
                            ?>

                            <?php
                            if(isset($_POST['dltAcom']) && isset($_SESSION['member_id'])){

                                include_once 'config/connection.php';
                                $query = "SELECT * FROM Rental_Properties";
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while($row = $result->fetch_assoc()){
                                    $del_acom = $row['property_id']; ?>
                                    <form action="<?php $_PHP_SELF ?>" method= 'post'>
                                        <input type = 'hidden' name='propDet' id ='propDet' value='<?= $row["property_id"]?>'>
                                        <input class = 'btn btn-primary temp' type='submit' width='600px' id='$row["property_id"]' value = 'Delete Accomodation' name = 'delAcom'>
                                    </form>
                                    <?php
                                    echo "Property Address: " . $row['address'] . ", District: " . $row['district'];

                                }

                            }
                            ?>

                            <?php
                            if(isset($_POST['delAcom']) && isset($_SESSION['member_id'])){
                                $prop_id = $_POST['propDet'];
                                $sql = "DELETE FROM Rental_Properties WHERE property_id = $prop_id";
                                $retval=$con->query($sql);

                            }

                            ?>

                            



                            <?php
                                if(isset($_POST['sumAcc']) && isset($_SESSION['member_id'])){
                                    include_once 'config/connection.php';

                                    $query = "SELECT Rental_Properties.address, round(AVG(Comments.rating),1) as rate, Comments.comment_text as comment
                                    From Rental_Properties JOIN Comments ON Rental_Properties.property_id = Comments.property_id
                                         GROUP BY Rental_Properties.property_id";
                                        
                                    $stmt = $con->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while($row = $result->fetch_assoc()){
                                        echo"Address: " . $row['address'] . ", Average Rating: " . $row['rate'];
                                        if ($row['comment'] != null){
                                            echo ", Comment: ". $row['comment'];
                                        }
                                        echo "<br>";

                                    }

                                }

                            ?>

                            <?php
                                if(isset($_POST['sumSupp']) && isset($_SESSION['member_id'])){
                                    include_once 'config/connection.php';

                                    $query = "SELECT Member.Fname, Member.Lname, round(AVG(Comments.rating),1) as rate, Comments.comment_text as comment
                                    From (Rental_Properties Natural JOIN Member) JOIN Comments ON Rental_Properties.property_id = Comments.property_id
                                         GROUP BY Rental_Properties.member_id";
                                        
                                    $stmt = $con->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while($row = $result->fetch_assoc()){
                                        echo"Supplier: " . $row['Fname'] . " ", $row['Lname'] . ", Average Rating: " . $row['rate'];
                                        if ($row['comment'] != null){
                                            echo ", Comment: ". $row['comment'];
                                        }
                                        echo "<br>";
                                    }

                                }

                            ?>


                            <?php
                                if(isset($_POST['sumCons']) && isset($_SESSION['member_id'])){
                                    include_once 'config/connection.php';
                                    $query = "SELECT Member.Fname, Member.Lname, GROUP_CONCAT(Rental_Properties.address) as addresses, GROUP_CONCAT(booking_start) as bookings_start, GROUP_CONCAT(status) as statuses 
                                        FROM (Bookings NATURAL JOIN Member) JOIN Rental_Properties ON Rental_Properties.property_id = Bookings.property_id
                                        GROUP BY Member.member_id";
                                        
                                    $stmt = $con->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while($row = $result->fetch_assoc()){
                                        echo"Consumer: " . $row['Fname'] . " " . $row['Lname'] . ", Rental Properties: " . $row['addresses'] . ", Booking Starts: " . $row['bookings_start'] . ", Status: " . $row['statuses'];
                                        echo "<br>";
                                    }

                                }

                            ?>

                        </div>
                        <!-- <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a> -->
                    	
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