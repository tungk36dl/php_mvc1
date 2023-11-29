<?php
require_once "../templates/admin/header.php";
$adminNameUrl = $controllerClass::$nameTable;// Trả về products
$NameVietNam = $modelClass::$nameView; ///+ Trar veef 'Sản phẩm '
?>

<?php 
    if(isset($msg)){
        echo "<br> $msg </p>";
    }
    if(isset($error)){
        echo '<pre>';
        print_r($error);
        echo '</pre>';    }
?>


<form action="" method="POST" enctype="multipart/form-data">

        <?php 
        
        foreach($modelClass::$fillable as $field) {
            $fieldVN = $modelClass::$metaFieldName[$field];
            // $retTmp = $ret["$field"];

            $kiemTraField = $modelClass::$metaFieldType[$field] ?? "";


            if($kiemTraField == 'textarea') {
                echo "<span > $fieldVN </span>:  <textarea name = '$field'>  </textarea> <br> <br>";
            }
            else if($kiemTraField == 'checkbox') {
                echo "<span > $fieldVN </span>:  <input type='checkbox' name='$field' value='1' > <br> <br>";
            }
            else if($kiemTraField == 'image') {
                echo "<span > $fieldVN </span>:  <input type='file' name='$field'  > <br> <br>";
            }
            else if($field == 'password') {
                echo "<span > $fieldVN </span>:  <input type='text' name='$field'  > <br> <br>";
            }

            else {
                echo "<span > $fieldVN </span>:  <input type='text' name='$field' > <br> <br>";
            }
    
         }
         
        
        ?>



    <!-- Name <input type="text" name="name" >
    <p></p>
    Code <input type="text" name="code" >
    <p></p>
    Description <input type="text" name="description" >
    <p></p>
    price <input type="text" name="price" >
    <p></p>     -->
    <input type="submit">

</form>



<?php
    
    
   
?>

<?php
require_once "../templates/admin/footer.php";
?>