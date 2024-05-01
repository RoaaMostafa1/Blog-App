<?php 
require "settings.php";// import settings file for connection
//start session
 session_start();
// checking if user in session(logged in)
 if(!isset($_SESSION["user"])) {
    session_destroy();
header("Location: login.php");// redirect to login page
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/all_cate.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>categories</title>
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
 <div class = "main-container">
  
<?php

// retrieve all fields from category table
$sql = "SELECT * FROM categories";
$result = $conn->query($sql);//execute sql query
// check if sql query is executed or not
if ($result === false) {
    die("Error executing query: " . $conn->error);
}
// check if category table is not empty 
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $category_name = $row['category_name'];
        $category_id = $row['category_id'];

        echo "<div class='categories'>";
        
        // Construct the full image path dynamically based on category name
        $imageFormats = ['jpg', 'png', 'gif']; // Add more formats as needed
        $image = false;

        foreach ($imageFormats as $format) {
            $imagePath = "images/" . strtolower(str_replace(' ', '', $category_name)) . ".$format";

            if (file_exists($imagePath)) {
                $image = $imagePath;
                break; // Stop searching if an image is found
            }
        }

        // Check if an image was found
        if ($image !== false) {
            echo "<img src='$image' alt='$category_name' width='100%' height='auto'>";
        } else {
            echo "Image not found for $category_name";
            // Log the error to the PHP error log
            error_log("Image not found for $category_name");
        }

        echo "<a href='one_category.php?category_name=$category_name'>$category_name</a>";
        echo "</div>";
    }
} else {
    echo "0 results";
}

$conn->close();
?>


 </div>
   
</body>
</html>