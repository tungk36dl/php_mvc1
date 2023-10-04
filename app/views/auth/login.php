<?php
require_once "../templates/home/header.php";
?>

<h3>Login</h3>

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

    Tài khoản<input type="text" name="username" placeholder="Nhập email hoặc tên tài khoản">
    <p></p>
    Mật khẩu: <input type="password" name="password" placeholder="Nhập mật khẩu">
    <p></p>
    <input type="submit" value="Đăng Nhập">
    <a href="/registration"> Đăng kí </a>

</form>

<?php 
}
?>
<?php
require_once "../templates/home/footer.php";
?>