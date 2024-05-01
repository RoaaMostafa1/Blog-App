<?php
require "settings.php"; // import settings file for connection
?>

<html>
<link rel="stylesheet" href="css/signup.css">
 <head>
 
<title>
signup page
</title>
</head>
 <body>
 <section>
 <div class="form-box">
  <div class="form-value">
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<h2>sign up</h2>

<div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" name="username" required>
                        <label>Username</label>
                    </div>


                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="email" name="email" required>
                        <label>Email</label>
                    </div>

                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" required>
                        <label >Password</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="confirm_password" required>
                        <label>comfirm password</label>
                    </div>
                    <button type="submit">sign up</button>
                    <div class="register">
                        <p>Already have a account? <a href="login.php">login</a></p>
                    </div>

</form>
 </div>
 </div>
 </section>
 <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <?php
    // check if requst method is post 
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
     // Collect values of input fields from the submitted form
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
  // Validate email using a regular expression
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
    // check if password is matches confirm password, then hash the password
    if($password!=$confirm_password)
    {
      echo "password do not match <br/>";
    }
    else {
   global $hashed_password;
   $hashed_password= password_hash($password, PASSWORD_BCRYPT);
   echo $hashed_password;
  }
  
 
// Insert user data into the database
  $sql = "INSERT INTO users (username, email, password)
VALUES (?,?,?)";
$stmt = $conn->prepare($sql); // Prepare the SQL statement for execution.
 // Check if the statement preparation was successful.
if ($stmt) {
   // Bind the parameters with their corresponding data types.
   $stmt->bind_param("sss", $username, $email, $hashed_password);

   if ($stmt->execute()) {
    // Execute the prepared statement to insert the user data into the database.
       echo "New record created successfully";
       header("Location: login.php");
   } else {
       echo "Error: " . $stmt->error;   
   }

   $stmt->close(); // Close the prepared statement.
} else {
   echo "Error: " . $conn->error;
}

$conn->close(); // Close the connection database

}
    ?>
</body>
</html>