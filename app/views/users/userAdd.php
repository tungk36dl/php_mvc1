<?php
require_once "../templates/admin/header.php";
?>

Add  user.....

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

    username <input type="text" name="username" >
    <p></p>
    email <input type="text" name="email" >
    <p></p>
    password <input type="password" name="password" >
    <p></p>
    Is_admin <input type="checkbox" name="is_admin" value="1">
    <p></p>
    <input type="submit">

</form>

<?php
        
   
?>

<?php
require_once "../templates/admin/footer.php";
?>