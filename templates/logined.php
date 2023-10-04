<span style="float: right;">
<?php 

    if($_SESSION['userinfo'] ?? ''){
        echo $_SESSION['userinfo']['username'];
        echo " | <a href='/logout'>Logout </a>";

    }
    else{
        echo "<a href='/login'>Login </a>";
    }

?>

</span>