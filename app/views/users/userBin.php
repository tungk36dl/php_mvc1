<?php
require_once "../templates/admin/header.php";
?>

<H3>Đây là thùng rác</H3>

<?php 
    if(isset($msg)){
        echo "<br> $msg </p>";
    }
    if(isset($error)){
        echo '<pre>';
        print_r($error);
        echo '</pre>';    }
?>

<!-- <a href="/admin/users/add">Add User </a> -->

<form action="" method="get">
Tìm Email : <input type="text" name="search_email" value="<?php echo $_GET['search_email'] ?? ''; ?>">
<input type="submit" value="Tim">
</form>
<br>
Trang : 
<?php 

// if(isset($msg)){
//     echo "<br> $msg </p>";
// }
// if(isset($error)){

//     echo '<pre>';
//     print_r($error);
//     echo '</pre>';
// }

if(isset($nPage))
    $str1 = null;
    if(isset($search_email)){
        $str1= "&search_email=$search_email";
    }

    $str2 = null;
    if(isset($sort_type) && isset($sort_by)){
        $str2 = "sort_by=$sort_by&sort_type=$sort_type";
    }

    for($i = 1; $i <= $nPage; $i++) {
        echo("<a href= '/admin/users/bin?$str2&page=$i$str1'> $i </a> | ");        
    }
    $sort_type = "asc";
    if($_GET['sort_type'] ?? ''){
        $sort_type = $_GET['sort_type'];
        if($sort_type == 'asc')
            $sort_type = 'desc';
        else
            $sort_type = 'asc';
    }
?>


<table border="1">

<tr>
    <th>ID</th>
    <th> <a href="/admin/users/bin?sort_by=username&sort_type=<?php echo $sort_type; echo $str1 ?? '';?>">Username </a></th>
    <th> <a href="/admin/users/bin?sort_by=email&sort_type=<?php echo $sort_type; echo $str1 ?? ''?>"> 
    Email </a></th>
    <th>Admin</th>

    <th>Action</th>
</tr>
<?php
    
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    // if(isset($data))
    foreach($data AS $one){
        $id = $one['id'];
        $username = $one['username'];
        $email = $one['email'];
        $first_name = $one['first_name'];
        $last_name = $one['last_name'];
        $is_admin = $one['is_admin'];

        echo('<tr>');
        echo("<td> $id </td> ");
        echo("<td> $username </td> ");
        echo("<td> $email </td> ");
        echo("<td> $is_admin </td> ");

        echo("<td> <a href='/admin/users/bin/delete?id=$id'> Delete </a> | <a href='/admin/users/bin/restore?id=$id'> Restore </a> </td> ");
        echo('</tr>');
        
    }
?>



</table>
<p></p>
<!-- <a href="/admin/users/bin">Thùng rác </a> -->




<?php
require_once "../templates/admin/footer.php";
?>