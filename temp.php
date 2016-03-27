<!DOCTYPE HTML>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="login.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script type="text/javascript" src="effects.js"></script>


        <title>Welcome to QBnB</title>
  
    </head>
<body>

 <?php
  //Create a user session or resume an existing one
 session_start();
 ?>
 

 <?php
 //check if the user clicked the logout link and set the logout GET parameter
if(isset($_GET['logout'])){
	//Destroy the user's session.
	$_SESSION['member_id']=null;
	session_destroy();
}
 ?>
 
 
 <?php
 //check if the user is already logged in and has an active session
if(isset($_SESSION['member_id'])){
	//Redirect the browser to the profile editing page and kill this page.
	header("Location: profile.php");
	die();
}
 ?>
 
 <?php

 
//check if the login form has been submitted
if(isset($_POST['loginBtn'])){
 
    // include database connection
    include_once 'config/connection.php'; 
	
	// SELECT query
        $query = "SELECT member_id, password, email FROM Member WHERE member_id=? AND password=?";

        // prepare query for execution
        if($stmt = $con->prepare($query)){
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        $stmt->bind_Param("ss", $_POST['member_id'], $_POST['password']);
         
        // Execute the query
		$stmt->execute();
 
		/* resultset */
		$result = $stmt->get_result();

		// Get the number of rows returned
		$num = $result->num_rows;
		
		if($num>0){
			//If the username/password matches a user in our database
			//Read the user details
			$myrow = $result->fetch_assoc();
			//Create a session variable that holds the user's id
			$_SESSION['member_id'] = $myrow['member_id'];
			//Redirect the browser to the profile editing page and kill this page.
			header("Location: profile.php");
			die();
		} else {
			//If the username/password doesn't matche a user in our database
			// Display an error message and the login form
			echo "Failed to login";
		}
		} else {
			echo "failed to prepare the SQL";
		}
 }
 
?>


<?php

 
//check if the login form has been submitted
if(isset($_POST['createAccount'])){
 
    // include database connection
    include_once 'config/connection.php'; 
    

        $member_id = $_POST['new_id'];
        $password = $_POST['newpass'];
        $Fname = $_POST['Fname'];
        $Lname = $_POST['Lname'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $year = $_POST['year'];
        $faculty = $_POST['faculty'];
        $degree = $_POST['degree'];


        // Insert
        $sql = "INSERT INTO Member (member_id, password, Fname, Lname, email, phoneNumber, year, faculty, degree)
        VALUES('$member_id', '$password', '$Fname', '$Lname', '$email', '$phoneNumber', '$year', '$faculty', '$degree')";


        // prepare query for execution
       $retval = $con->query($sql);

       if (!$retval){
        echo "could not create account";
       }
       else {
        echo "Account Created!";
       }

 }
 
?>


<!-- dynamic content will be here -->
 <form name='login' id='login' action='index.php' method='post'>
    <table border='0'>
        <tr>
            <td>Member ID</td>
            <td><input type='text' name='member_id' class='member_id' /></td>
        </tr>
        <tr>
            <td>Password</td>
             <td><input type='password' name='password' id='password' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' id='loginBtn' name='loginBtn' value='Log In' /> 
            </td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type="button" id="show_login" value="New User">
            </td>
        </tr>
    </table>
</form>

<div>
        <center>
        <div id = "loginform">
            <form method = "post" action = "<?php $_PHP_SELF ?>">
                <p>Create a New QBnB Account</p>

                <input type = "image" id = "close_login" src = "images/close.png">
                <input type = "text" size = "8" id = "new_id" placeholder = "Student Number" name = "new_id" required>
                <input type = "password" id = "newpass" name = "newpass" placeholder = "******" required>
                <input type = "text" id = "Fname" placeholder = "First Name" name = "Fname" required>
                <input type = "text" id = "Lname" placeholder = "Last Name" name = "Lname" required>
                <input type = "email" id = "email" placeholder = "E-Mail" name = "email" required>
                <input type = "text" size="9" id = "phoneNumber" placeholder = "Phone Number" name = "phoneNumber" required>
                <input type = "text" id = "year" placeholder = "Year" name = "year" required>
                <input type = "text" id = "faculty" placeholder = "Faculty" name = "faculty" required>
                <input type = "text" id = "degree" placeholder = "Degree" name = "degree" required>
                <input type = "submit" id = "createAccount" value = "Create Account" name = "createAccount">
            </form>
        </div>
        </center>
</div>


</body>
</html>