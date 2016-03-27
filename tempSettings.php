<!DOCTYPE HTML>
<html>
    <head>

    	<link rel="stylesheet" type="text/css" href="login.css">
        <title>QBnB - Account Settings</title>
  
    </head>
<body>

<?php
  //Create a user session or resume an existing one
 session_start();
 ?>

 <?php
if(isset($_POST['deleteAcc']) && isset($_SESSION['member_id'])){
	include_once 'config/connection.php'; 


	$query = "DELETE FROM Member WHERE member_id=?";

	$stmt = $con->prepare($query);
	$stmt->bind_param('s',$_SESSION['member_id']);
	if($stmt->execute()){
		echo "success";
	}
	else{
		echo "failed";
	}
	echo "Account Successfully Deleted";
	header("Location: index.php");
	die();

}
?>

<?php
if(isset($_SESSION['member_id'])){
   // include database connection
    include_once 'config/connection.php'; 
	
	// SELECT query
        $query = "SELECT member_id, password, email, Fname FROM Member WHERE member_id=?";
 
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


Welcome  <?php echo $myrow['Fname']; ?> , <a href="index.php?logout=1">Log Out</a><br/>

<div>
	<input type='submit' name='deleteAcc' id='deleteAcc' value='Delete Account' action ="<?php $_PHP_SELF ?>" method = "post"/> 
</div>



</body>
</html>


