<?php
require_once "../templates/admin/header.php";
?>
Edit  product.....

<?php 
    if(isset($msg)){
        echo "<br> $msg </p>";
    }
    if(isset($error)){
        echo "<br> $error </p>";
    }
?>

<form action="" method="POST">

    Tiêu đề <input type="text" name="newname" value="<?php echo $ret['newname']; ?>" >
    <p></p>
    Mô tả <textarea name="description" id="" cols="30" rows="3"> <?php echo $ret['description']; ?></textarea>
    <p></p>
    Nội dung <textarea name="content" id="" cols="30" rows="10"> <?php echo $ret['content']; ?></textarea>
    <p></p>
  
    <input type="submit">

</form>



<?php
    
    
   
?>

<?php
require_once "../templates/admin/footer.php";
?>