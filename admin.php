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
                                echo "<form method = 'post' action ='http://localhost/admin.php?dltAcc=Delete+an+account' >";
                                while($row = $result->fetch_assoc()){
                                    $del_id = $row['member_id'];
                                    echo " <input type = 'submit' name ='$del_id' class ='btn btn-primary temp' value='Delete Account'>";

                                    echo "Member ID: " . $row['member_id'] . ", Name: " . $row['Fname'] . " " . $row['Lname'] . "<br>";
                                }
                                echo "</form> ";

                            }


                            /*
                            if(isset($_POST['$del_id'] && isset($_SESSION['member_id'])){
                                include_once 'config/connection.php'; 
                                $sql = "DELETE FROM Member WHERE member_id = $member_id";
                                $retval = $con->query($sql);
                                if($retval){
                                    echo "success";
                                }
                                else{
                                    echo "failed";
                                    }
                            
                            } */
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

                                    $query = "SELECT Rental_Properties.member_id, round(AVG(Comments.rating),1) as rate, Comments.comment_text as comment
                                    From Rental_Properties JOIN Comments ON Rental_Properties.property_id = Comments.property_id
                                         GROUP BY Rental_Properties.member_id";
                                        
                                    $stmt = $con->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while($row = $result->fetch_assoc()){
                                        echo"Supplier: " . $row['member_id'] . ", Average Rating: " . $row['rate'];
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
                                    $query = "SELECT Member.Fname, Member.Lname, Round(AVG(rating),1) as rate, Comments.comment_text FROM Member NATURAL JOIN Comments GROUP BY member_id";
                                        
                                    $stmt = $con->prepare($query);
                                    $stmt->execute();
                                    $result = $stmt->get_result();
                                    while($row = $result->fetch_assoc()){
                                        echo"Consumer: " . $row['Fname'] . " " . $row['Lname'] . ", Average Rating: " . $row['rate'];
                                        if ($row['comment_text'] != null){
                                            echo ", Comment: ". $row['comment_text'];
                                        }
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