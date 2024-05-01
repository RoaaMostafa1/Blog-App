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
    <title>delete user</title>
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
    // Retrieve the user information from the session
$user = $_SESSION["user"];
$user_id = $user['user_id'];
// Prepare a SQL statement to delete the user with the specified user_id
$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
echo "<script>alert('are you sure you want to delete your account ?');</script>";
// Execute the prepared statement to delete the user
$stmt->execute();
header("Location:logout.php");
echo "user deleted";
$stmt->close();// Close the prepared statement
$conn->close();// Close the connection

       ?>
</body>
</html>