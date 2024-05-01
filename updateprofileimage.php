<?php 
 session_start();//session start
 
if(!isset($_SESSION["user"])) {
    session_destroy();
    header("Location: login.php");
}
?>
<?php
 require "settings.php";//import settings file for connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="css/uploadpro.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>image</title>
</head>
<body>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
<label class="custom-file-upload">
            <input type="file" name="profile_image">
            Choose File
        </label>
        
        <input class="custom-upload-button" type="submit" value="Upload">
</form>
 </div>
<?php
 // Process the form submission
$user_id = $_SESSION["user"]["user_id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $profile_image = $_FILES["profile_image"]["name"];
        $folder = "imageprofile/" . $profile_image;
        // SQL query to update the profile image in the database
        $sql = "UPDATE users SET profile_image=? WHERE user_id=? ";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind the parameters
            $stmt->bind_param("si", $profile_image, $user_id);

            if ($stmt->execute()) {
                 // Move the uploaded image to the desired folder
                move_uploaded_file($_FILES['profile_image']['tmp_name'], "imageprofile/" . $_FILES['profile_image']['name']);
                echo "Profile image uploaded successfully";
                header("Location: profile.php");
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Image upload failed!";
    }

    $conn->close();
}
?>

</body>
</html>