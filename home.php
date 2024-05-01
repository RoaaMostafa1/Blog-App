<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/home1.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>

 
<header>
        
        <ul class="left-links">
            <li><a href="home.php">Home</a></li>
            <li><a href="aboutus.php">About</a></li>
            <li><a href="contact.php">Contact Us</a></li>
        </ul>
        <ul class="right-links">
            <li><a href="login.php">Login</a></li>
            <li><a href="signup.php">Sign Up</a></li>
              
            <li><a href="welcome.php">Welocme</a></li>
        </ul>
    </header>
   
 <div class="search">
 <form action="Search.php" method="post" >
    
<input type="text" name="search" placeholder="Search..." class="inputsearch">

<input type ="submit" value="Search" class="searchbutton">
</form>
 </div>
 <div class="container">
    <?php
    require "settings.php";//import settings file for connection
// define sql query to retrieve posts with related information, all posts from database with the category and username
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
ORDER BY 
    posts.date_post DESC";

// Execute the SQL query and store the result in the $result variable
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $post_id=$row['post_id'];
       
        echo "<div class='posts'>";
       
       echo "<img src='uploads/".$row['post_image']."'width='200px' height='200px' >"; 
        echo "<h2>" . $row["title"]. "</h2>". "<span>".$row["date_post"]."</span>"."<br>". "<span>".$row["username"]."</span>" ."<br>". "<span>".$row["category_name"]."</span>" ."<br>" ;
        echo "<p class='excerpt'>" . substr($row["content"], 0, 150) . "...</p>";   
        echo "<a href='onepost.php?post_id=$post_id'>Read more</a>";

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

