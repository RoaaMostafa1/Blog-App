<?php   
$hostname ="localhost";
  $sql_user_name ="roaa";
  $sql_password ="roaa01001278614*";
  $db="blog";
 // create  connection 
    
    $conn=new mysqli($hostname,$sql_user_name,$sql_password,$db);
    // Check connection
    if ($conn->connect_error)
    {
      echo "Connection failed: " . $conn->connect_error;
 
    }
   
   
    ?>