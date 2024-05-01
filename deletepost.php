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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>delete post</title>
</head>
<body>
    <div>
        <h2>
title
        </h2>
        <p>
content
        </p>
        <span>
            author
        </span>
        <span>
            date posted
        </span>
    </div>
    <?php

// gets the post id from the url 
$post_id = $_GET['post_id'];
// Prepare a SQL statement to delete the post with the specified post_id
$stmt = $conn->prepare("DELETE FROM posts WHERE post_id = ?");
$stmt->bind_param("i", $post_id);
// Execute the prepared statement
if ($stmt->execute()) {
    // Successful deletion
    echo "<script>alert('Post deleted');</script>";
    header("Location: dashboard.php");
    exit;
} else {
    // Error in execution
    echo "Error deleting post: " . $stmt->error;
}

$stmt->close();// Close the prepared statement
 

$conn->close();// close the connection 


       ?>
       
</body>
</html>