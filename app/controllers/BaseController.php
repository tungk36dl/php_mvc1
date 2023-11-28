<?php


class BaseController
{
    static public $model;

    static public $viewFileName;
    static public $nameTable;



    public static function edit()
    {
        // echo("<br/> Đây là trang ADMIN");
        $ret = null;
        $error = '';


        $modelClass = static::$model;

        $controllerClass = static::class;

        if ($id = ($_GET['id'] ?? "")) {

            try{

                $ret = static::$model::get($id);
                if(($_POST['username'] ?? "") || ($_POST['name'] ?? "")){ // có thể sửa thành ($_POST[static::$model::$fillable[0]] ?? ""))
                    if($_POST['username'] ?? ""){
                        $_POST['is_admin']=$_POST['is_admin'] ?? "0";


                            static::$model::save($id, $_POST);
                            $ret = static::$model::get($id);
                            $msg = "Update thành công!";
                    }
                    else{
                        static::$model::save($id, $_POST);
                        $ret = static::$model::get($id);
                        $msg = "Update thành công!";
                    }                                   
                    // Header("Location: /admin/users");
                }
                

            } catch (Exception $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                // return null;
            }


        }
        // require_once "../app/views/users/userEdit.php";
                // require_once "../app/views/" . static::$nameTable . "/" . static::$viewFileName ."Edit.php";
        require_once "../app/views/base-view/edit.php";

    }
    public static function list()
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

            // echo("<br/> nPage = $total ");
            
            $nPage = ceil($total / $limit);

            $modelClass = static::$model;

            $controllerClass = static::class;


            
        } catch (PDOException $e) {
            $error = "<br> Có lỗi" . $e->getMessage() .$e->getTraceAsString();
            // return null;
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

    public static function add()
    {

        
        $modelClass = static::$model;

        $controllerClass = static::class;

        if (($_POST[static::$model::$fillable[0]] ?? "")) {



            try{
               
                    // echo '<pre>';
                    // print_r($_POST);
                    // echo '</pre>';
                    // die($error);
                    // $_POST['is_admin']=$_POST['is_admin'] ?? "0";
                    // if($error = static::$model::validation($_POST) ?? ""){
                    //     // echo $error;
                    // }
                    // else{
                        $ret = static::$model::add($_POST);

                    // }
             
                if($ret ?? ""){
                    Header("Location: /admin/" . static::$nameTable);
                }


            } catch (Exception $e) {
                $error = "<br> Có lỗi" . $e->getMessage(). "<br>". $e->getTraceAsString();
                // return null;
            }
        

        }
        
        // require_once "../app/views/users/userAdd.php";
        // require_once "../app/views/" . static::$nameTable . "/" . static::$viewFileName ."Add.php";

        require_once "../app/views/base-view/add.php";


        
    }

    public static function delete()
    {


        if ($id = ($_GET['id'] ?? "")) {

            try{
                $ret = static::$model::delete($id);
                if($ret){
                    Header("Location: /admin/" . static::$nameTable );
                }
            } catch (Exception $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }


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
