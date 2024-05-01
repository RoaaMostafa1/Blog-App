<?php 
 session_start(); //session start
 
if(!isset($_SESSION["user"])) {
    session_destroy();
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/search.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
</head>
<body>
    <?php 
     
 
     if(!isset($_SESSION["user"])) {
        
                
echo "<header><ul><li class='left'><a href='home.php'>Home</a></li>";
echo"<li class='left'><a href='aboutus.php'>About</a></li>";
  echo"<li class='left'> <a href='contact.php'> contact us </a></li>";
  echo"  <li class='right'><a href='login.php'>login</a></li>";
    echo"<li class ='right'><a href='signup.php'>sign up</a></li>";
   
   echo" <li class='right'><a href='welcome.php'>Welocme</a></li></ul></header>";

  }
     
     else { 
        
        echo"  <header> <ul> <li class='left'>  <a href='dashboard.php'>  Dashboard</a></li>";
        echo "<li class='left'><a href='myposts.php'>myposts</a></li>";
           
        echo" <li class='right'><a href='logout.php'> log out </a> </li>";
        echo "<li class='right'><a href='profile.php'>" . $_SESSION['user']['username'] . "</a></li>";
        

              echo" <li class='right'><a href=;createpost.php'>create post </a></li></ul></header>";
                }
        
 
    ?>



<?php
require "settings.php";//import settings file for connection
 // Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $search = '%' . $_POST['search'] . '%';
    // SQL query to search for posts based on title, content, category, and username
    $sql = "SELECT posts.post_id,
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
    WHERE title LIKE ? OR content LIKE ? OR categories.category_name LIKE ? OR users.username LIKE ?";

    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind the search parameter to each placeholder
        $stmt->bind_param("ssss", $search, $search, $search, $search);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                  // Display search results
                $post_id=$row['post_id'];
                echo "<div class='posts'>";
                echo "<img src='uploads/".$row['post_image']."' width='200px' height='200px' >"; 
                echo $row["title"] . "<br> " . $row["category_name"] . "<br>" . " " . $row["username"] . "<br>";
                echo "<p class='excerpt'>" . substr($row["content"], 0, 150) . "...</p>";
                echo "<a href='onepost.php?post_id=$post_id'>Read more</a>";
                echo "</div>";
            }
        } else {
            echo "0 records";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement";
    }
}
$conn->close();
?>
</body>
</html>
