<?php


class BaseController
{
    static public $model;

    static public $viewFileName;
    static public $nameTable;


    
    public static function get_api()
    {
        $error = '';
        if (($id = ($_GET['id'] ?? "")) && is_numeric(($_GET['id'] ?? "")))  {

            try{

                if(!$ret = static::$model::get($id)) {
                    http_response_code(404);
                    echo json_encode(['error'=>1, 'message'=>"Không tồn tại id: $id"], JSON_PRETTY_PRINT);
                    return;
                }
                echo json_encode(['error'=>0, 'data'=>$ret], JSON_PRETTY_PRINT);
                return;

            } catch (Exception $e) {
                $error = "<br> Có lỗi" . $e->getMessage() . "<br>". $e->getTraceAsString();
                // return null;
            }


        }
        else {
            http_response_code(400);
            echo json_encode(['error'=>1, 'message'=>"Not valid request!!"], JSON_PRETTY_PRINT);
            return;

        }
        http_response_code(500);

        echo json_encode(['error'=>1, 'message'=>$error], JSON_PRETTY_PRINT);
    }

    
    public static function edit_api()
    {
        $ret = static::edit(1);
        echo json_encode($ret, JSON_PRETTY_PRINT);
        return;
    }


    public static function delete_api()
    {
        $ret = static::delete(1);
        echo json_encode($ret, JSON_PRETTY_PRINT);

    }


    public static function add_api()
    {
        $ret = static::add(1);
        echo json_encode($ret, JSON_PRETTY_PRINT);
        return;
    }


    public static function list_api()
    {
       $ret = static::list(1);
        echo json_encode($ret, JSON_PRETTY_PRINT);
        return;
    }

    public static function edit($isApi = 0)
    {
        // echo("<br/> Đây là trang ADMIN");
        $ret = null;
        $error = '';


        $modelClass = static::$model;

        $controllerClass = static::class;

        if (($id = ($_GET['id'] ?? "")) && is_numeric(($_GET['id'] ?? ""))) {

            try{

                $ret = static::$model::get($id);

                if(!$ret) {
                    http_response_code(404);

                    if($isApi) {
                        echo json_encode(['error'=>1, 'message'=>"Không tồn tại id: $id"], JSON_PRETTY_PRINT);
                    }
                    throw new Exception('Can not get id: '. $id);
                }

                if(($_POST['username'] ?? "") || ($_POST['name'] ?? "")){ // có thể sửa thành ($_POST[static::$model::$fillable[0]] ?? ""))

                    if($_FILES ?? ''){
                        $field = array_keys($_FILES)[0];
                        if(static::$model::$metaFieldType[$field] == 'image'){
                            $filepath = $_FILES[$field]['tmp_name'];
                            $name = $_FILES[$field]['name'];
                            $imgDir = __DIR__ . "/../../public/images";
                            if(!file_exists($imgDir))
                                mkdir($imgDir, 0755,1);                        
                            $imgFullPath = $imgDir . "/". $name;
                            move_uploaded_file($filepath, $imgDir . "/". $name);
                            if(!file_exists($imgFullPath))
                                throw new Exception("Co loi upload!");
                            $_POST[$field] = "/images/$name";                        
                        }
                    }       


                    if($_POST['username'] ?? ""){
                        $_POST['is_admin']=$_POST['is_admin'] ?? "0"; // ddeer fomat code ddepj


                            if(!static::$model::save($id, $_POST)) {
                                $error = 'Error Update!';
                            }
                            else{
                                if($isApi) {
                                    return ['error'=>0, 'message'=>'update done!'];
                                }
                                $ret = static::$model::get($id);
                                $msg = "Update thành công!";
                            }
                            
                    }
                    else{
                        if(!static::$model::save($id, $_POST)) {
                            $error = 'Error Update!';
                        }
                        else{
                            if($isApi) {
                                return ['error'=>0, 'message'=>'update done!'];
                            }
                            $ret = static::$model::get($id);
                            $msg = "Update thành công!";
                        }
                    }                                   
                    // Header("Location: /admin/users");
                }

                

            } catch (Exception $e) {
                http_response_code(500);
                $error = "<br> Có lỗi" . $e->getMessage() .$e->getTraceAsString();
                if($isApi) {
                    return ['error'=>1, 'message'=>$error];
                }
            }

        }

        if($isApi) {
            return ['error'=>1, 'message'=>$error];
        }
        // require_once "../app/views/users/userEdit.php";
                // require_once "../app/views/" . static::$nameTable . "/" . static::$viewFileName ."Edit.php";
        require_once "../app/views/base-view/edit.php";

    }
    public static function list($isApi = 0)
    {
    
        try{
            //sort_by & sort_type
            $sort_by = $_GET['sort_by'] ?? 0;
            $sort_type = $_GET['sort_type'] ?? 0;

            $search_value = $_GET['search_value'] ?? '';


            //Limit/Offset
            $page = $_GET['page'] ?? 1;
            $limit = 5;
            $param = ['page'=>$page, 
            'limit'=>$limit, 
            'sort_by'=>$sort_by, 
            'sort_type'=>$sort_type,
            'search_value'=>$search_value];

            $data = static::$model::list($param);

            $total = static::$model::count($param);


            if($isApi) {
                return ['error'=>0, 'total'=>$total, 'data'=>$data];
            }
            

            $nPage = ceil($total / $limit);

            $modelClass = static::$model;

            $controllerClass = static::class;


            
        } catch (PDOException $e) {
            http_response_code(500);
            $error = "<br> Có lỗi" . $e->getMessage() .$e->getTraceAsString();
            if($isApi) {
                return ['error'=>1, 'message'=>$error];
            }
        }
        // require_once "../app/views/" . static::$nameTable . "/" . static::$viewFileName ."List.php";
        require_once "../app/views/base-view/list.php";
    }

    public static function bin()
    {
    
        try{
            //sort_by & sort_type
            $sort_by = $_GET['sort_by'] ?? 0;
            $sort_type = $_GET['sort_type'] ?? 0;

            $search_value = $_GET['search_value'] ?? '';


            //Limit/Offset
            $page = $_GET['page'] ?? 1;
            $limit = 5;
            $param = ['page'=>$page, 
            'limit'=>$limit, 
            'sort_by'=>$sort_by, 
            'sort_type'=>$sort_type,
            'search_value'=>$search_value];

            $data = static::$model::listBin($param);

            $total = static::$model::countBin($param);

            // echo("<br/> nPage = $total ");
            
            $nPage = ceil($total / $limit);

            $modelClass = static::$model;

            $controllerClass = static::class;


            
        } catch (Exception $e) {
            $error = "<br> Có lỗi" . $e->getMessage() .$e->getTraceAsString();
            // return null;
        }
        // require_once "../app/views/" . static::$nameTable . "/" . static::$viewFileName ."List.php";

        require_once "../app/views/base-view/list.php";
    }

    public static function add($isApi = 0)
    {

        $error = '';
        
        $modelClass = static::$model;

        $controllerClass = static::class;

        if (($_POST[static::$model::$fillable[0]] ?? "")) {
      

            try{

                    
                if($_FILES ?? ''){
                    $field = array_keys($_FILES)[0];
                    if(static::$model::$metaFieldType[$field] == 'image'){
                        $filepath = $_FILES[$field]['tmp_name'];
                        $name = $_FILES[$field]['name'];
                        $imgDir = __DIR__ . "/../../public/images";
                        if(!file_exists($imgDir))
                            mkdir($imgDir, 0755,1);                        
                        $imgFullPath = $imgDir . "/". $name;
                        move_uploaded_file($filepath, $imgDir . "/". $name);
                        if(!file_exists($imgFullPath))
                            throw new Exception("Co loi upload!");
                        $_POST[$field] = "/images/$name";                        
                    }
                } 
               
                    // echo '<pre>';
                    // print_r($_POST);
                    // echo '</pre>';
                    // die("1234");
                    // die($error);
                    // $_POST['is_admin']=$_POST['is_admin'] ?? "0";
                    // if($error = static::$model::validation($_POST) ?? ""){
                    //     // echo $error;
                    // }
                    // else{
                        $ret = static::$model::add($_POST);

                    // }
             
                if($ret ?? ""){
                    if($isApi){
                        return ['error'=>0, 'data'=>$ret, 'message'=>'insert(add) done!!'];
                    }
                    Header("Location: /admin/" . static::$nameTable);
                }


            } catch (Exception $e) {
                http_response_code(500);
                $error = "<br> Có lỗi" . $e->getMessage(). "<br>". $e->getTraceAsString();
                // return null;
            }
         }
        if($isApi) {
            return['error'=>1, 'message'=>$error];
        }
        
        // require_once "../app/views/users/userAdd.php";
        // require_once "../app/views/" . static::$nameTable . "/" . static::$viewFileName ."Add.php";

        require_once "../app/views/base-view/add.php";


        
    }

    public static function delete($isApi = 0) // Xoas vaof thungf racs 
    {

        $error = '';

        if ($id = ($_GET['id'] ?? "")) {

            try{
                $ret = static::$model::delete($id);
                if($ret){
                    if($isApi) {
                        return ['error'=>0, 'message'=>'Delete done!'];
                    }
                    Header("Location: /admin/" . static::$nameTable );
                }
            } catch (Exception $e) {

                http_response_code(500);
                if($isApi) {
                    return ['error'=>1, 'message'=>$error];
                }

                $error = "<br> Có lỗi" . $e->getMessage();
                // return null;

                echo '<pre>';
                print_r("Cos loix : " .$error);
                echo '</pre>';
                
            }


        }
        else {
            if($isApi) {
                http_response_code(400);
                echo json_encode(['error'=>1, 'message'=>"Not valid request!!"], JSON_PRETTY_PRINT);
                return;
            }

        }

        if($isApi) {
            return ['error'=>1, 'message'=> $error];
        }

    }

    public static function bin_delete()
    {

        require_once "../app/models/User.php";

        if ($id = ($_GET['id'] ?? "")) {

            try{
                $ret = static::$model::bin_delete($id);
                if($ret){
                    Header("Location: /admin/". static::$nameTable . "/bin");
                }
            } catch (Exception $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }
        }
    }

    public static function bin_restore()
    {



        if ($id = ($_GET['id'] ?? "")) {

            try{

                $ret = static::$model::bin_restore($id);
                if($ret){
                    Header("Location: /admin/" . static::$nameTable );
                }
            } catch (Exception $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }
        }

    }
}
