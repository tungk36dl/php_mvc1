<?php
require_once "../templates/home/header.php";
?>

<h3>registration</h3>

<?php 
    if(isset($msg)){
        echo "<br> $msg </p>";
    }
    if(isset($error)){
        echo "<br> $error </p>";
    }
?>

<?php
if($_SESSION['userinfo'] ?? ''){
    echo("<br/> <a href='/logout'> Đăng xuất </a>");
    
}
else{


?>

<p></p>

<form action="" method="post">

username <input type="text" name="username" >
    <p></p>
    email <input type="text" name="email" >
    <p></p>
    password <input type="password" name="password" >
    <p></p>
    re_password <input type="password" name="re_password" >
    <p></p>
    <input type="submit" value="Đăng Kí">
    <a href="/login">ĐĂng nhập </a>

</form>

<?php 
}
?>
<?php
require_once "../templates/home/footer.php";
?>