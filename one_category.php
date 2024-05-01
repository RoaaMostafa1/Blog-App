<?php
require "settings.php"; // import settings file for connection
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
<link rel="stylesheet" href="css/one_cate.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>onecategory</title>
     
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
 
</head>
<body>
<div class="post-container">
    <?php
// Check if 'category_name' is set in the GET parameters
if (isset($_GET['category_name'])) {
     // Retrieve the category_name from the GET parameters
    $category_name = $_GET['category_name'];
 // SQL query to retrieve posts for the specified category, ordered by date in descending order
    $sql = "SELECT 
            posts.post_id,
            posts.title AS title,
            posts.content AS content,
            posts.date_post,
            posts.post_image,
            users.username,
            categories.category_name AS category_name
        FROM 
            posts 
        INNER JOIN 
            users ON posts.user_id = users.user_id 
        INNER JOIN 
            categories ON posts.category_name = categories.category_name 
            WHERE categories.category_name = ?
            ORDER BY 
            posts.date_post DESC";


     // Prepare the SQL statement
     $stmt = $conn->prepare($sql);
     // Bind the category_name parameter
     $stmt->bind_param("s", $category_name);
      // Execute the prepared statement
     $stmt->execute();
      // Get the result set
     $result = $stmt->get_result();
       // Loop through each row in the result set
     foreach ($result as $row) {
        echo '<div class="post">';
        echo '<p class="category-name">' . $row['category_name'] . '</p>';
        echo "<img src='uploads/".$row['post_image']."'width='200px' height='200px' >"; 
        echo "<h1>".$row['title']."</h1>";
            echo "<p>".$row['content']."</p>";
            echo "<p>".$row['username']."</p>";
            echo "<p>".$row['date_post']."</p>";
            echo '</div>';

           
     }
     // Close the prepared statement
     $stmt->close();
    }

$conn->close();// Close the database connection

       ?>
</div>
   
</body>
</html>