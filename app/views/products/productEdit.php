<?php
require_once "../templates/admin/header.php";
?>
Edit  product.....

<?php 
    if(isset($msg)){
        echo "<br> $msg </p>";
    }
    if(isset($error)){
        echo '<pre>';
        print_r($error);
        echo '</pre>';   
     }
?>

<form action="" method="POST">

    name <input type="text" name="name" value="<?php echo $ret['name']; ?>" >
    <p></p>
    Code <input type="text" name="code" value="<?php echo $ret['code']; ?>" >
    <p></p>
    Description <input type="text" name="description" value="<?php echo $ret['description']; ?>">
    <p></p>
    Price <input type="text" name="price" value="<?php echo $ret['price']; ?>">
    <p></p>
    <input type="submit">

</form>



<?php
    
    
   
?>

<?php
require_once "../templates/admin/footer.php";
?>