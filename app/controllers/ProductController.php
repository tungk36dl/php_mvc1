<?php

require_once "../app/models/Product.php";
class ProductController
{
    public static function edit()
    {
        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/Product.php";
        $ret = null;
        if ($id = ($_GET['id'] ?? "")) {

            try{
                $ret = product::get($id);

                if($_POST['name'] ?? ""){
                    // die("123456");
                    product::save($id, $_POST);
                    $ret = product::get($id);
                    $msg = "Update thành công!";
                    // Header("Location: /admin/users");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }


        }
        require_once "../app/views/products/productEdit.php";
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

            $data = product::list($param);

            $total = product::count($param);

            // echo("<br/> nPage = $total ");
            
            $nPage = ceil($total / $limit);


            
        } catch (PDOException $e) {
            $error = "<br> Có lỗi" . $e->getMessage();
            // return null;
        }
        require_once "../app/views/products/productList.php";
    }

    public static function bin()
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

            $data = product::list_bin($param);

            $total = product::count_bin($param);

            // echo("<br/> nPage = $total ");
            
            $nPage = ceil($total / $limit);


            
        } catch (PDOException $e) {
            $error = "<br> Có lỗi" . $e->getMessage();
            // return null;
        }
        require_once "../app/views/products/productList.php";
    }

    public static function add()
    {
        // die("1234");
        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/Product.php";
        if ($_POST['name'] ?? "") {

            try{
                $ret = product::add($_POST);
                if($ret){
                    Header("Location: /admin/products");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }
            // require_once "../app/views/products/productAdd.php";

        }
        require_once "../app/views/products/productAdd.php";

        
    }

    public static function delete()
    {
        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/Product.php";

        if ($id = ($_GET['id'] ?? "")) {

            try{
                $ret = product::delete($id);
                if($ret){
                    Header("Location: /admin/products");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }


        }
        // require_once "../app/views/products/productAdd.php";
    }

    public static function bin_restore()
    {

        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/Product.php";

        if ($id = ($_GET['id'] ?? "")) {

            try{
                // die("123214");
                $ret = product::bin_restore($id);
                if($ret){
                    Header("Location: /admin/products/bin");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }


        }
        // require_once "../app/views/products/productAdd.php";
    }

    public static function bin_delete()
    {
        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/Product.php";

        if ($id = ($_GET['id'] ?? "")) {

            try{
                $ret = product::bin_delete($id);
                if($ret){
                    Header("Location: /admin/products");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }


        }
        // require_once "../app/views/products/productAdd.php";
    }

}
