<?php
require_once "../templates/admin/header.php";
?>

<a href="/admin/news/add">Add New </a>

<form action="" method="get">
Tìm tin tuc : <input type="text" name="search_name" value="<?php echo $_GET['search_name'] ?? ''; ?>">
<input type="submit" value="Tim">
</form>
<br>
Trang : 
<?php 
if(isset($nPage))
    $str1 = null;
    if(isset($search_name)){
        $str1= "&search_name=$search_name";
    }

    $str2 = null;
    if(isset($sort_type) && isset($sort_by)){
        $str2 = "sort_by=$sort_by&sort_type=$sort_type";
    }
    
    for($i = 1; $i <= $nPage; $i++) {
        echo("<a href= '/admin/news?$str2&page=$i$str1'> $i </a> | ");
        
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
    <th> <a href="/admin/news?sort_by=name&sort_type=<?php echo $sort_type; echo $str1 ?? '';?>">Tiêu đề </a></th>

    <th> <a href="/admin/news?sort_by=created_at&sort_type=<?php echo $sort_type; echo $str1 ?? '';?>"> Ngày tạo </th>
    <th>Action</th>
</tr>
<?php
    
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    // if(isset($data))
    foreach($data AS $one){
        $id = $one['id'];
        $name = $one['name'];
        $description = $one['description'];
        $content = $one['content'];
        $created_at = $one['created_at'];
        echo('<tr>');
        echo("<td> $id </td> ");
        echo("<td> $name </td> ");
        echo("<td> $created_at  </td> ");

        echo("<td> <a href='/admin/news/edit?id=$id'> Edit </a>|<a href='/admin/news/delete?id=$id'> Delete </a> </td> ");
        echo('</tr>');
        
    }
?>

</table>




<?php
require_once "../templates/admin/footer.php";
?>