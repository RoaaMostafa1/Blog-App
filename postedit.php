<?php 
// session strat
 session_start();
 
if(!isset($_SESSION["user"])) {
    session_destroy();
header("Location: login.php");
}


?>
<?php
require "settings.php";// import settings file for connection
?>

            <a<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/postedit.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit post</title>
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
 <div class="container">
 <?php
 // Check if the form is submitted for updating the post
 if (isset($_POST['updatepost'])) {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Use prepared statement to prevent SQL injection
    $sql = "UPDATE posts SET title=?, content=? WHERE post_id=? AND user_id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Assuming $user_id is defined and holds the appropriate value
        $user_id = $_SESSION["user"]["user_id"];
        
        // Bind the parameters
        $stmt->bind_param("ssii", $title, $content, $post_id, $user_id);

        if ($stmt->execute()) {
            echo "Record Updated successfully";
            header("Location: myposts.php");
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}

 // Check if post_id is set in the URL
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
 // Retrieve post details from the database
    $sql1 = "SELECT * FROM posts WHERE post_id = $post_id";
    $result = $conn->query($sql1);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $content = $row['content'];

        // Display the form with the current post details
        echo '<div class="form-style">';
        echo '<form action="postedit.php" method="post">';
        echo '<input type="hidden" name="post_id" value="' . $post_id . '">';
        echo '<label> Title </label>';
        echo '<input type="text" name="title" value="' . $title . '"><br>';
        echo '<label> Content </label>';
        echo '<textarea name="content">' . $content . '</textarea><br>';
        echo '<input type="submit" name="updatepost" value="Update">';
        echo '</form>';
        echo '</div>';

      }  }
?>

 </div>
</body>
</html>