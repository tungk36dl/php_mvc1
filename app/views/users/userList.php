<?php
require_once "../templates/admin/header.php";
?>

<?php
if (isset($msg)) {
    echo "<br> $msg </p>";
}
if (isset($error)) {
    echo '<pre>';
    print_r($error);
    echo '</pre>';
}
?>


<?php
// echo '<pre>';
// print_r($_SERVER);
// echo '</pre>';

$chuoi_cha = $_SERVER['REQUEST_URI'];
$chuoi_con = "/users/bin";

// echo ($chuoi_cha);
// echo ('<br>');
// echo ($chuoi_con);

if (strpos($chuoi_cha, $chuoi_con)) {
    echo ('Chuoi con trong chuoi cha');
} else {
    echo ('<a href="/admin/users/add">Add User </a>');
}
?>


<form action="" method="get">
    Tìm user : <input type="text" name="search_value" value="<?php echo $_GET['search_value'] ?? ''; ?>">
    <input type="submit" value="Tim">
</form>
<br>
Trang :
<?php
if (isset($nPage))
    $str1 = null;
if (isset($search_value)) {
    $str1 = "&search_value=$search_value";
}

$str2 = null;
if (isset($sort_type) && isset($sort_by)) {
    $str2 = "sort_by=$sort_by&sort_type=$sort_type";
}

for ($i = 1; $i <= $nPage; $i++) {
    if (strpos($chuoi_cha, $chuoi_con)) {
        echo ("<a href= '/admin/users/bin?$str2&page=$i$str1'> $i </a> | ");
    } else {
        echo ("<a href= '/admin/users?$str2&page=$i$str1'> $i </a> | ");
    }
}

//Refactorying

$sort_type = "asc";
if ($_GET['sort_type'] ?? '') {
    $sort_type = $_GET['sort_type'];
    if ($sort_type == 'asc')
        $sort_type = 'desc';
    else
        $sort_type = 'asc';
}
?>


<table border="1">

    <tr>
        <th>id</th>
        <th> <a href="<?php if (strpos($chuoi_cha, $chuoi_con)) {
                            echo ('/admin/users/bin');
                        } else {
                            echo ('/admin/users');
                        } ?>?sort_by=username&sort_type=<?php echo $sort_type;
                                                                                                                                                            echo $str1 ?? ''; ?>"> Username </a></th>
        <th> <a>
                Email </a></th>
        <th> <a href="<?php if (strpos($chuoi_cha, $chuoi_con)) {
                            echo ('/admin/users/bin');
                        } else {
                            echo ('/admin/users');
                        } ?>?sort_by=is_admin&sort_type=<?php echo $sort_type;
                                                                                                                                                            echo $str1 ?? ''; ?>">Is_admin</th>
        <th>Action</th>
    </tr>
    <?php

    //     echo '<pre>';
    // print_r($_SERVER);
    // echo '</pre>';

    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    // if(isset($data))


    foreach ($data as $one) {
        $id = $one['id'];
        $username = $one['username'];
        $email = $one['email'];
        $is_admin = $one['is_admin'];
        echo ('<tr>');
        echo ("<td> $id </td> ");
        echo ("<td> $username </td> ");
        echo ("<td> $email  </td> ");
        echo ("<td> $is_admin  </td> ");

        if (strpos($chuoi_cha, $chuoi_con)) {
            echo ("<td> <a href='/admin/users/bin/restore?id=$id'> Restore </a>|<a href='/admin/users/bin/delete?id=$id'> Delete </a> </td> ");
        } else {
            echo ("<td> <a href='/admin/users/edit?id=$id'> Edit </a>|<a href='/admin/users/delete?id=$id'> Delete </a> </td> ");
        }
        echo ('</tr>');
    }
    ?>

</table>


<p></p>

<?php
if (strpos($chuoi_cha, $chuoi_con)) {
} else {
    echo ('<a href="/admin/users/bin">Thùng rác </a>');
}
?>





<?php
require_once "../templates/admin/footer.php";
?>