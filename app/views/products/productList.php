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
$chuoi_con = "/products/bin";

// echo ($chuoi_cha);
// echo ('<br>');
// echo ($chuoi_con);

if (strpos($chuoi_cha, $chuoi_con)) {
    echo ('Chuoi con trong chuoi cha');
} else {
    echo ('<a href="/admin/products/add">Add Product </a>');
}
?>


<form action="" method="get">
    Tìm tên sản phẩm : <input type="text" name="search_value" value="<?php echo $_GET['search_value'] ?? ''; ?>">
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
        echo ("<a href= '/admin/products/bin?$str2&page=$i$str1'> $i </a> | ");
    } else {
        echo ("<a href= '/admin/products?$str2&page=$i$str1'> $i </a> | ");
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
                            echo ('/admin/products/bin');
                        } else {
                            echo ('/admin/products');
                        } ?>?sort_by=name&sort_type=<?php echo $sort_type;
                                                                                                                                                            echo $str1 ?? ''; ?>">Tên sản phẩm </a></th>
        <th> <a href="">
                Mã sản phẩm </a></th>
        <th>Mô tả sản phẩm</th>
        <th> <a href="<?php if (strpos($chuoi_cha, $chuoi_con)) {
                            echo ('/admin/products/bin');
                        } else {
                            echo ('/admin/products');
                        } ?>?sort_by=price&sort_type=<?php echo $sort_type;
                                                                                                                                                            echo $str1 ?? ''; ?>">Giá sản phẩm</th>
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
        $name = $one['name'];
        $code = $one['code'];
        $description = $one['description'];
        $price = number_format($one['price'], 0, '.', ' ');;
        echo ('<tr>');
        echo ("<td> $id </td> ");
        echo ("<td> $name </td> ");
        echo ("<td> $code  </td> ");
        echo ("<td> $description  </td> ");
        echo ("<td> $price  </td> ");

        if (strpos($chuoi_cha, $chuoi_con)) {
            echo ("<td> <a href='/admin/products/bin/restore?id=$id'> Restore </a>|<a href='/admin/products/bin/delete?id=$id'> Delete </a> </td> ");
        } else {
            echo ("<td> <a href='/admin/products/edit?id=$id'> Edit </a>|<a href='/admin/products/delete?id=$id'> Delete </a> </td> ");
        }
        echo ('</tr>');
    }
    ?>

</table>


<p></p>

<?php
if (strpos($chuoi_cha, $chuoi_con)) {
} else {
    echo ('<a href="/admin/products/bin">Thùng rác </a>');
}
?>





<?php
require_once "../templates/admin/footer.php";
?>