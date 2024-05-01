<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<form action="uploadimage.php" method="POST" enctype="multipart/form-data">
    
<input type="file" name="imageToUpload">
<input type="submit" name="submit" value="Submit">

</form>
<?php

if(isset($_FILES['imageToUpload'])){
    
  move_uploaded_file($_FILES['imageToUpload']['tmp_name'], "uploads/". $_FILES['imageToUpload']['name']);
  echo "<img src='uploads/" . $_FILES['imageToUpload']['name'] . "' width='200px' height='200px'>";  
}
else{
    echo "image not found!";
}


?>

</body>
</html>