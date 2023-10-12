<?php
require_once "../templates/admin/header.php";
?>

Add  New.....

<?php 
    if(isset($msg)){
        echo "<br> $msg </p>";
    }
    if(isset($error)){
        echo "<br> $error </p>";
    }
?>


<form action="" method="POST">

    Tiêu đề <input type="text" name="name" >
    <p></p>
    Mô tả <textarea name="description" id="" cols="30" rows="3"></textarea>
    <p></p>
    Nội dung <textarea name="content" id="" cols="30" rows="10"></textarea>
    <p></p>
    
    <input type="submit">

</form>



<?php
    
    
   
?>

<?php
require_once "../templates/admin/footer.php";
?>