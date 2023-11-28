<?php
require_once "../templates/admin/header.php";
$adminNameUrl = $controllerClass::$nameTable;
// $NameVietNam = $modelClass::$nameView;

?>
Edit  $NameVietNam.....

<?php 
    if(isset($msg)){
        echo "<br> $msg </p>";
    }
    if(isset($error)){
        echo '<pre>';
        print_r($error);
        echo '</pre>';   
     }
?>

<form action="" method="POST" enctype="multipart/form-data">

     <?php 
     
     foreach($modelClass::$fillable as $field) {
        $fieldVN = $modelClass::$metaFieldName[$field];
        $retTmp = $ret[$field];
        $kiemTraField = $modelClass::$metaFieldType[$field] ?? "";

        if($kiemTraField == 'textarea') {
            echo "<span > $fieldVN </span>:  <textarea name = '$field'> $retTmp </textarea> <br> <br>";
        }
        else if($kiemTraField == 'checkbox') {
            echo "<span > $fieldVN </span>:  <input type='checkbox' name='$field' value='1' > <br> <br>";
        }
        else if($kiemTraField == 'file') {
            echo "<span > $fieldVN </span>:  <input type='file' name='$field' value='$retTmp' > <br> <br>";
        }
        else if($field == 'password') {
            echo "<span > $fieldVN </span>:  <input type='text' name='$field' value='' > <br> <br>";
        }
        else {
            echo "<span > $fieldVN </span>:  <input type='text' name='$field' value='$retTmp' > <br> <br>";
        }

     }
     
     ?>






<!-- 
    name <input type="text" name="name" value="<?php echo $ret['name']; ?>" >
    <p></p>
    Code <input type="text" name="code" value="<?php echo $ret['code']; ?>" >
    <p></p>
    Description <input type="text" name="description" value="<?php echo $ret['description']; ?>">
    <p></p>
    Price <input type="text" name="price" value="<?php echo $ret['price']; ?>">
    <p></p> -->



    <input type="submit">

</form>



<?php
    
    
   
?>

<?php
require_once "../templates/admin/footer.php";
?>