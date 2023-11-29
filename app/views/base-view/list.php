<?php
require_once "../templates/admin/header.php";
// ProductController::$nameTable;
$adminNameUrl = $controllerClass::$nameTable;
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
$chuoi_con = "/".$adminNameUrl."/bin";

// echo ($chuoi_cha);
// echo ('<br>');
// echo ($chuoi_con);

if (strpos($chuoi_cha, $chuoi_con)) {
    echo ('Chuoi con trong chuoi cha');
} else {
    $addUrl = "/admin/".$adminNameUrl."/add";
    echo ('<a href='.$addUrl.'>Add '.$adminNameUrl.' </a>');
}
?>


<form action="" method="get">
    Tìm tên <?php echo $modelClass::$nameView ?> : <input type="text" name="search_value" value="<?php echo $_GET['search_value'] ?? ''; ?>">
    <input type="submit" value="Tim">
</form>
<br>
Trang :
<?php
$str1 = $str2 ='';
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
        echo ("<a href= '/admin/$adminNameUrl/bin?$str2&page=$i$str1'> $i </a> | ");
    } else {
        echo ("<a href= '/admin/$adminNameUrl?$str2&page=$i$str1'> $i </a> | ");
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

    <?php 
    
    foreach($modelClass::$indexListField AS $field) {
        $fieldName = $modelClass::$metaFieldName[$field];

        if(in_array($field, $modelClass::$sort_field)) {
            if (strpos($chuoi_cha, $chuoi_con)) {
                $url = "/admin/$adminNameUrl/bin?sort_by=$field&sort_type=$sort_type$str1";
              } else {
                  $url = "/admin/$adminNameUrl?sort_by=$field&sort_type=$sort_type$str1";
              }
            echo "<td> <a href='$url' > $fieldName </td>";
        }
        else
            echo("<td> $fieldName </td>");
    }
    echo("<td> Action </td>");

    
    ?>

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
        echo("<tr>");

        foreach($modelClass::$indexListField AS $field) {
            $val = $one[$field];
            if($field == 'price') {
                $val = number_format($one[$field], 0, '.', ' ');

            }
            if($field == 'thumb') {
                echo "<td> <img width='10%' src= '$val'> </td>";
            }else
                echo ("<td>" . $val. "</td>");
        }

        $id = $one['id'];

        if (strpos($chuoi_cha, $chuoi_con)) {
            echo ("<td> <a href='/admin/$adminNameUrl/bin/restore?id=$id'> Restore </a>|<a href='/admin/$adminNameUrl/bin/delete?id=$id'> Delete </a> </td> ");
        } else {
            echo ("<td> <a href='/admin/$adminNameUrl/edit?id=$id'> Edit </a>|<a href='/admin/$adminNameUrl/delete?id=$id'> Delete </a> </td> ");
        }


        echo("</tr>");


    }
    ?>

</table>


<p></p>

<?php
if (strpos($chuoi_cha, $chuoi_con)) {
} else {
    echo ("<a href='/admin/$adminNameUrl/bin'>Thùng rác </a>");
}
?>





<?php
require_once "../templates/admin/footer.php";
?>