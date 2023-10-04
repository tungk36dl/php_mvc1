<?php
require_once "../templates/admin/header.php";
?>

Add  Product.....

<?php 
    if(isset($msg)){
        echo "<br> $msg </p>";
    }
    if(isset($error)){
        echo '<pre>';
        print_r($error);
        echo '</pre>';    }
?>


<form action="" method="POST">

    Name <input type="text" name="name" >
    <p></p>
    Code <input type="text" name="code" >
    <p></p>
    Description <input type="text" name="description" >
    <p></p>
    price <input type="text" name="price" >
    <p></p>    
    <input type="submit">

</form>



<?php
    
    
   
?>

<?php
require_once "../templates/admin/footer.php";
?>