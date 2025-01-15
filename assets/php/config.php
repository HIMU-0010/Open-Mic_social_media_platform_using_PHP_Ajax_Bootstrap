<?php 
    $host = 'localhost';
    $username = 'himu';
    $password = '1234567890';
    $dbname = 'open_mic';

    session_start();

	//create connection to the database
   $dbconn = mysqli_connect($host, $username, $password, $dbname);

   //check connection
   if(!$dbconn)
      echo 'Connection error' . mysqli_connect_error();


 ?>