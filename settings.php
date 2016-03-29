<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>QBnB - Account Settings</title>

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
 
 if(isset($_POST['updateBtn']) && isset($_SESSION['member_id'])){
  // include database connection
    include_once 'config/connection.php'; 
    
    $query = "UPDATE Member SET password=?,email=?,fname=?,Lname=?,phoneNumber=?,year=?,faculty=?,degree=? WHERE member_id=?";
 
    $stmt = $con->prepare($query);  
    $stmt->bind_param('sssssssss', $_POST['password'], $_POST['email'], $_POST['Fname'],$_POST['Lname'],$_POST['phoneNumber'],$_POST['year'],$_POST['faculty'], $_POST['degree'], $_SESSION['member_id']);
    // Execute the query
        if($stmt->execute()){
            echo "Record was updated. <br/>";
        }else{
            echo 'Unable to update record. Please try again. <br/>';
        }
 }
 
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
        
} else {
    //User is not logged in. Redirect the browser to the login index.php page and kill this page.
    header("Location: index.php");
    die();
}
?>

 <?php
if(isset($_POST['deleteAcc']) && isset($_SESSION['member_id'])){
    echo "Hi";
    include_once 'config/connection.php'; 
    echo "stillgoing";
    $member_id = $_SESSION['member_id'];
    $sql = "DELETE FROM Member WHERE member_id = $member_id";
    $retval = $con->query($sql);

    if($retval){
        echo "success";
    }
    else{
        echo "failed";
    }
    session_destroy();
    header("Location: index.php");
    

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
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>Change your Account Settings!</h1>
                        <form name='editProfile' id='editProfile' action='settings.php' method='post'>
                            <table border='0'>
                                <tr>
                                    <td> Member ID</td>
                                    <td><input type='text' name='member_id' id='member_id' disabled  value="<?php echo $myrow['member_id']; ?>"  /></td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                     <td><input type='text' name='password' id='password'  value="<?php echo $myrow['password']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>First Name</td>
                                    <td><input type='text' name='Fname' id='Fname'  value="<?php echo $myrow['Fname']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Last Name</td>
                                    <td><input type='text' name='Lname' id='Lname'  value="<?php echo $myrow['Lname']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><input type='text' name='email' id='email'  value="<?php echo $myrow['email']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Phone Number</td>
                                    <td><input type='text' name='phoneNumber' id='phoneNumber'  value="<?php echo $myrow['phoneNumber']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Graduation Year</td>
                                    <td><input type='text' name='year' id='year'  value="<?php echo $myrow['year']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Faculty</td>
                                    <td><input type='text' name='faculty' id='faculty'  value="<?php echo $myrow['faculty']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td>Degree</td>
                                    <td><input type='text' name='degree' id='degree'  value="<?php echo $myrow['degree']; ?>" /></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type='submit' name='updateBtn' id='updateBtn' value='Update' /> 
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <!-- <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a> -->
                        <a href="index.php?logout=1">Log Out</a><br/>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <form action ="<?php $_PHP_SELF ?>" method = "post">
                            <tr>
                                <td><input type='submit' name='deleteAcc' id='deleteAcc' value='Delete Account'/> </td>
                            </tr>
                        </form>
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
