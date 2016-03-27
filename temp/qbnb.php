  <html>
<head><title>Load Company Database</title></head>
<body>

<?php

 $host = "localhost";
 $user = "QBnB";
 $password = "password";
 $database = "QBnB";

 $cxn = mysqli_connect($host,$user,$password, $database);
 // Check connection
 if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  die();
  }

mysqli_query($cxn,"drop table Bookings;");

   mysqli_query($cxn, "create table Bookings
    (booking_id INTEGER,
     consumer varchar(16),
     status varchar(16),
     member_id INTEGER,
     property_id INTEGER,
     booking_start date,
	   primary key (booking_id)
	);");

   echo "Bookings created.<br />";



   ?>
</body></html>