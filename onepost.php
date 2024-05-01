<?php
// database connection
require "settings.php";
// session strat 
 session_start();
 
if(!isset($_SESSION["user"])) {
    session_destroy();
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/onepost.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>onepost</title>
 </head>
<body>
 <?php 
 // check if user is logged in or not logged
     if(!isset($_SESSION["user"])) {            
echo "<header><ul class ='left-links'><li><a href='home.php'>Home</a></li>";
echo"<li><a href='aboutus.php'>About</a></li>";
  echo"<li> <a href='contact.php'> contact us </a></li>";
  echo"</ul>";
  echo "<ul class= 'right-links'>";
  echo"  <li ><a href='login.php'>login</a></li>";
    echo"<li><a href='signup.php'>sign up</a></li>";
   echo" <li><a href='welcome.php'>Welocme</a></li></ul></header>";
  }
      else { 
         echo"  <header> <ul class ='left-links' > <li>  <a href='dashboard.php'>  Dashboard</a></li>";
       echo "<li><a href='myposts.php'>myposts</a></li>";
        echo "</ul";
        echo"<ul  class= 'right-links'>";
        echo" <li><a href='createpost.php'>create post </a></li>";
       echo "<li><a href='profile.php'>" . $_SESSION['user']['username'] . "</a></li>";
         echo" <li><a href='logout.php'> log out </a> </li>";
        echo "</ul></header>";
         
                }
    ?>
   
        <?php 
        // Check if the post ID is set and is numeric
if (isset($_GET['post_id']) && is_numeric($_GET['post_id'])) {
    // Retrieve post details from the database
    $post_id = $_GET['post_id'];

    $sql1 = "SELECT * FROM posts WHERE post_id = ?";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch and display the current post details
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $content = $row['content'];
        $date_post = $row['date_post'];
        $post_image = $row['post_image'];

        // Display the form with the current post details
        echo '<div class="post-style">';
        echo "<img src='uploads/" . $row['post_image'] . "' width='700px' height='400px' >";
        echo "<h1>" . $title . "</h1>";
        echo "<p>" . $content . "</p>";
        echo "<p>" . $date_post . "</p>";
        echo '</div>';

 // Fetch and display comments for the current post
        $sql2 = "SELECT comments.comment_content, users.username, users.profile_image
                 FROM comments
                 INNER JOIN users ON comments.user_id = users.user_id
                 INNER JOIN posts ON comments.post_id = posts.post_id
                 WHERE posts.post_id = ?";
        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo '<div class="comments-section">';
            while ($row = $result->fetch_assoc()) {
                 // Display each comment with user details
                echo "<div class='comment'>";
                echo "<img src='imageprofile/" . $row['profile_image'] . "' width='50px' height='50px' >";
                echo "<p><strong>" . $row['username'] . "</strong></p> </br>";
                echo "<p>" . $row['comment_content'] . "</p>";
                echo "</div>";
            }
            echo '</div>';
        }

        // Display comment form for logged-in users
        if (isset($_SESSION["user"])) {
            echo "<div class='comment'>";
            if (isset($_SESSION['user']['profile_image'])) {
                echo "<img src='imageprofile/" . $_SESSION['user']['profile_image'] . "' width='50px' height='50px' >";
            }
            echo "<form method='post' action='onepost.php?post_id=" . $post_id . "'>";
            echo "<label>" . $_SESSION['user']['username'] . "</label>";
            echo "<input type='text' name='comment' >";
            echo "<button type='submit'>Comment</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "Post not found";
    }

    $stmt->close();
} else {
    echo "Invalid post ID";
}

// Insert a new comment into the database
if (isset($_SESSION["user"]) && isset($_GET['post_id']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_GET['post_id'];
    $comment_content = $_POST["comment"];

    $sql3 = "INSERT INTO comments (comment_content, user_id, post_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql3);

    if ($stmt) {
        // Bind the parameters
        $stmt->bind_param("sii", $comment_content, $_SESSION['user']['user_id'], $post_id);

        if ($stmt->execute()) {
            // Redirect to the same page after successful comment insertion
            $referer = $_SERVER['HTTP_REFERER'];
            header("Location: $referer");
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
</body>
</html>