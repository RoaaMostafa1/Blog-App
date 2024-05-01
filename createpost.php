<?php 
// strat session
 session_start();
 // checking if user is logged in or in session
if(!isset($_SESSION["user"])) {
    session_destroy();
header("Location: login.php");// redirect to login page
}
?>
<?php
require "settings.php"; // import settings file for connection
?>

            <a<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/createpost.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Create Post</title>
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
 
 <div class="form-style">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <h1>Create Post</h1>
<label>
    Title
</label>
<input type="text" name="title">
<br />


<label>
  Content
</label>
<textarea name="content" id="" cols="30" rows="10"></textarea>
<br />
<?php
// retreive all fields from table category
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);// execute sql query
echo" <label for='categories'>Choose a category:</label>";
echo "<select id='categories' name='categories'>";
// check if category table not empty 
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $category_id=$row['category_id'];
   $name=$row['category_name'];
  echo" <option>".$name."</option>";  
}}
echo "</select>";
?>
<div class="file-input-wrapper">
    <label for="post_image">Choose File</label>
    <input type="file" name="post_image" id="post_image">
    <div class="file-name">No file chosen</div>
</div>
<input type="submit" value="Post">
</form>
 </div>
 <?php

 // check if method is post 
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // Retrieve data from the POST request
    $title  =  $_POST["title"];
    $content = $_POST["content"];
    $categories = $_POST["categories"];
    $post_image = $_FILES["post_image"]["name"];
    $folder = "uploads/" . $filename;
    // Retrieve user information from the session
    $user=$_SESSION["user"];
    $user_id = $user["user_id"];
    echo $_FILES['post_image']['tmp_name'];
// inserting the post date in database 
$sql = "INSERT INTO posts (title, content,user_id,category_name,post_image)
VALUES (?,?,?,?,?)";// ? for sql injection 
$stmt = $conn->prepare($sql);// prepare sql before entering  the data  

if ($stmt) {
   // Bind the parameters
   $stmt->bind_param("ssiss", $title, $content,$user_id,$categories,$post_image);
//check if sql query is executed 
   if ($stmt->execute()) {
    //file superglobal variable ,Check if the post_image file is set in the POST request
    if(isset($_FILES['post_image'])){
        // function moves the post image from temporary location on server to uploads folder
        move_uploaded_file($_FILES['post_image']['tmp_name'], "uploads/". $_FILES['post_image']['name']);
        
      }
      else{
          echo "image not found!";
        
      }
       echo "New record created successfully";
       header("Location: dashboard.php");
   }
    else {
       echo "Error: " . $stmt->error;
   }

   $stmt->close();
 
} 
else {
   echo "Error: " . $conn->error;
}
$conn->close();
}
?> 
</body>
</html>