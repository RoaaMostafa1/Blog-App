<?php 
 session_start();//session start

 
if(!isset($_SESSION["user"])) {
    session_destroy();
header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/profile.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
 
<header>
        
        <ul class="left-links">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="myposts.php">myposts</a></li>
        </ul>
        <ul class="right-links">
            <li><a href="createpost.php">Create Post</a></li>
            <li><a href="profile.php">
            <?php
             $user = $_SESSION["user"];
            echo $user['username'];
            ?>
              </a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </header>
 
 
    <div class="profile-info">
<?php
 require "settings.php";// import settings file for connection
   // Retrieve user information from the session
 $user = $_SESSION["user"];
 $user_id = $user['user_id'];
 // SQL query to fetch user details based on user_id
 $sql = "SELECT * FROM users WHERE user_id = $user_id";
 $result = $conn->query($sql);
 
 if ($result->num_rows > 0) {
   // output data of each row
   while($row = $result->fetch_assoc()) {
    //echo"<div class=profile-style>";
    echo "<img src='imageprofile/".$row['profile_image']."'width='200px' height='200px' >"; 
     echo  "<p><strong> Username :</strong>  " .$row["username"]."</p>" ."<br>"."<p><strong>Email : </strong> " . $row["email"]."<p>"."<br>";
    
     // echo"</div>";
   }
 } else {
   echo "0 results";
 }
 $conn->close();
 
?>
    </div>
    <form>
    <button type="reset" onclick="location.href='updateuser.php?id=<?= $user_id ;?>'">
        Update
      </button>
      <button type="reset" onclick="location.href='deleteuser.php'">
        Delete
      </button>
      <button type="reset" onclick="location.href='updateprofileimage.php?id=<?= $user_id ;?>'">
        uploadimage
      </button>
    </form>

    
</body>
</html>

