<?php
require "settings.php";// import settings file for connection
?>
<?php 

session_start();// session start


if(!isset($_SESSION["user"])) {
   session_destroy();
header("Location: login.php");
}


?>

<html>
 <head>
 <link rel="stylesheet" href="css/updateuser.css">
<title>
Update User
</title>
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
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<h2> Update Profile</h2>

<label for="username">name</label>
<input type="text" id="name" name="username" required>

<label for="email">Email</label>
<input type="email" id="email" name="email" required>

<label for="password">Password</label>
<input type="password" id="password" name="password" required>

<label for="confirm_password"> confirm Password</label>
<input type="password" id="password" name="confirm_password" required>

<button type="submit">update user</button>

</form>
 </div>

    <?php
    // Get user details from the session
     $user = $_SESSION["user"];
     $user_id = $user['user_id'];
     // Check if the form is submitted using POST method
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $username = $_POST['username'];
    if (empty($username)) {
      echo "Name is empty<br/>";
    
    }
    if (strlen ($username) >20) {
      echo "username is too long<br/>";
    }
    $email= $_POST['email'];
    if (empty($email)) {
      echo "email is empty<br/>";
    } 
 
    $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^";  
    if (!preg_match ($pattern, $email) ){  
        $ErrMsg = "Email is not valid.";  
                echo $ErrMsg;  
    } else {  
        echo "Your valid email address is: " .$email;  
    }  

    
    $password = $_POST['password'];
    if (empty($password)) {
      echo "password is empty<br/>";
    } 
    $confirm_password = $_POST['confirm_password'];
    if (empty($confirm_password)) {
    echo "confirm_password is empty<br/>";
    }
    if($password!=$confirm_password)
    {
      echo "password donot match <br/>";
    }
    else {
   global $hashed_password;
   $hashed_password= password_hash($password, PASSWORD_BCRYPT);
   echo $hashed_password;
  }
 

  $sql = "UPDATE users set username=?,email=?,password=? WHERE user_id=? ";
$stmt = $conn->prepare($sql);

if ($stmt) {
   // Bind the parameters
   $stmt->bind_param("sssi", $username, $email, $hashed_password,$user_id);

   if ($stmt->execute()) {
       echo "Record Updated successfully";
       header("Location: profile.php");
       exit();
   } else {
       echo "Error: " . $stmt->error;
   }

   $stmt->close();
} else {
   echo "Error: " . $conn->error;
}

$conn->close();


}
  
 

    ?>
</body>
</html>