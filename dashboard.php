
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
<link rel="stylesheet" href="css/home.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
</head>
<body>
<header>
    <ul>
    </ul>
    <ul class="right">
        <li>
            <a href="logout.php">
                log out
            </a>
        </li>
    </ul>
</header>


 
 <div class="search">
 <form action="Search.php" method="post" >
    
<input type="text" name="search" placeholder="Search..." class="inputsearch">

<input type ="submit" value="Search" class="searchbutton">
</form>
 </div>
<button id="toggle-btn">&#9776; </button>

<div class="container">
<div class="sidebar">


        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profile.php"><?php echo $_SESSION["user"]["username"]; ?></a></li>
            <li><a href="myposts.php">My Posts</a></li>
            <li><a href="createpost.php">Create Post</a></li>
            <li><a href="all_category.php">Categories</a></li>
        </ul>
    </div>
    

  

 
    
 <div class="content">

    <?php
 
require "settings.php";//import settings file for connection
//Define SQL query to retrieve posts with related information, all posts from the database with the category and username
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
    echo "<div class='post-container'>";
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $post_id=$row['post_id'];
       
        echo "<div class='posts'>";
      
      echo "<img src='uploads/".$row['post_image']."'width='200px' height='200px' >"; 
       echo "<span>".$row["date_post"]."</span>"."   / ". "<span>".$row["username"]."</span>" ."   / ". "<span>".$row["category_name"]."</span>" ."<br>" ;
        echo "<h2>" . $row["title"]. "</h2>";
        echo "<p class='excerpt'>" . substr($row["content"], 0, 150) . "...</p>";// substr is function that shows a certain number of caracters
       
        echo "<a href='onepost.php?post_id=$post_id' class='read-more'>Read more</a>";
        

   
    echo "</div>";
      }
      echo "</div>";
    
    } else {
      echo "0 results";
    }
    $conn->close();
  


    ?>
 </div>
</div>

<script>
    // Toggle sidebar visibility
        document.getElementById('toggle-btn').addEventListener('click', function() {
            var sidebar = document.querySelector('.sidebar');
            var content = document.querySelector('.content');
            var toggleBtn = document.getElementById('toggle-btn');
            if (sidebar.style.marginLeft === '0px') {
        sidebar.style.marginLeft = '-200px';
        content.style.marginLeft = '0';
        toggleBtn.classList.remove('active'); // Remove active class when closing sidebar
    } else {
        sidebar.style.marginLeft = '0';
        content.style.marginLeft = '200px';
        toggleBtn.classList.add('active'); // Add active class when opening sidebar
    }
});
</script>
</body>
</html>

