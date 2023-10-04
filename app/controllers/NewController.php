<?php

require_once "../app/models/New.php";
class NewController
{
    public static function edit()
    {
        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/New.php";
        $ret = null;
        if ($id = ($_GET['id'] ?? "")) {

            try{
                $ret = tintuc::get($id);

                if($_POST['newname'] ?? ""){
                    tintuc::save($id, $_POST);
                    $ret = tintuc::get($id);
                    $msg = "Update thành công!";
                    // Header("Location: /admin/users");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }


        }
        require_once "../app/views/news/newEdit.php";
    }
    public static function list()
    {
    
        try{
            //sort_by & sort_type
            $sort_by = $_GET['sort_by'] ?? 0;
            $sort_type = $_GET['sort_type'] ?? 0;

            $search_name = $_GET['search_name'] ?? '';


            //Limit/Offset
            $page = $_GET['page'] ?? 1;
            $limit = 5;
            $param = ['page'=>$page, 
            'limit'=>$limit, 
            'sort_by'=>$sort_by, 
            'sort_type'=>$sort_type,
            'search_name'=>$search_name];

            $data = tintuc::list($param);

            $total = tintuc::count($param);

            // echo("<br/> nPage = $total ");
            
            $nPage = ceil($total / $limit);


            
        } catch (PDOException $e) {
            $error = "<br> Có lỗi" . $e->getMessage();
            // return null;
        }
        require_once "../app/views/news/newList.php";
    }

    

    public static function add()
    {
        // die("1234");
        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/New.php";
        if ($_POST['newname'] ?? "") {

            try{
                $ret = tintuc::add($_POST);
                if($ret){
                    Header("Location: /admin/news");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }
            // require_once "../app/views/news/newAdd.php";

        }
        require_once "../app/views/news/newAdd.php";

        
    }

    public static function delete()
    {
        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/New.php";

        if ($id = ($_GET['id'] ?? "")) {

            try{
                $ret = tintuc::delete($id);
                if($ret){
                    Header("Location: /admin/news");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }


        }
        // require_once "../app/views/news/newAdd.php";
    }
}
