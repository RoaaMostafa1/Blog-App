
<?php 
// session strat 
 session_start();
 // checking if user is logged in
if(!isset($_SESSION["user"])) {
    session_destroy();
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/myposts.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My posts </title>
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
 
 <div class="posts-container">
 <?php
require "settings.php";// import settings file forr connection
 // Retrieve user information from the session
$user = $_SESSION["user"];
$user_id = $user['user_id'];
// SQL query to retrieve posts for the specific user, ordered by date in descending order
$sql = "SELECT * FROM posts WHERE user_id=$user_id order by date_post desc";
// Execute the SQL query and store the result in the $result variable
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
 
  while($row = $result->fetch_assoc()) {
    echo "<div class='posts'>";
    echo "<img src='uploads/".$row['post_image']."'width='200px' height='200px' >"; 
    echo  " <h2> " . $row["title"]. "</h2>";
    echo "<p>" . $row["content"]. "</p>";
   echo  "<span>".$row["date_post"]."</span>";
    ?>
     <form>
     <div class="button-container">
    <button class="update-button" type="reset" onclick="location.href='postedit.php?post_id=<?= $row['post_id']?>'">
        Update
      </button>
      <button class="delete-button" type="reset" onclick="location.href='deletepost.php?post_id=<?= $row['post_id']?>'">
        Delete
      </button>
     </div>
     </form>
    <?php 
    echo "</div>";
  }
    
  ?>
   
    <?php
  
} else {
  echo "0 results";
}

$conn->close();

?>
 </div>

</body>
</html>

