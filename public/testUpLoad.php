

<?php

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $target_dir = __DIR__;
    $target_file = $target_dir ."/images/". basename($_FILES["fileToUpload"]["name"]);
    
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    
}

// Check if file already exists

?>



<!DOCTYPE html>
<html>
<body>

<form action="testUpLoad.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>



</body>
</html>

