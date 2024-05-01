<?php
require "settings.php"; // import settings file for connection
?>

<html>
 <head>
 <link rel="stylesheet" href="css/login.css">
<title>
Login page
</title>
</head>
 <body>
    <section>
 <div class="form-box">
            
 
 <div class="form-value">
<form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<h2>Login</h2>
<div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text"  name="username" required>
                        <label for="">Username</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                         <input type="password"  name="password" required>
                        <label for="">Password</label>
                    </div>

                    <button type="submit">Log in</button>
                    <div class="register">
                        <p>Don't have a account <a href="signup.php">sign up</a></p>
                    </div>
  
</form>
 </div>
 </div>
    </section>
 <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


    <?php
    session_start(); // Start a new session or resume the existing session
    // check if the requested method is post 
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $username = $_POST['username'];  // Get the entered username from the form

    if (empty($username)) {
      echo "Name is empty<br/>";
    
    }


    
    $password = $_POST['password'];// Get the entered password from the form

    if (empty($password)) {
      echo "password is empty<br/>";
    } 
   
// Prepare and execute a SQL query to fetch user details based on the entered username
    $sql = "SELECT user_id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verify the entered password with the stored hashed password
        if (password_verify($password, $user["password"])) {
            // Password is correct, create a session and redirect to the dashboard
        
           $_SESSION["user"] = $user;
            header("Location: dashboard.php");
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }

    // Close the database connection
    $conn->close();
}

?>

</body>
</html>