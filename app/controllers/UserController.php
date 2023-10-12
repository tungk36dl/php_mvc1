<?php

require_once "../app/models/User.php";
class UserController
{
    public static function edit()
    {
        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/User.php";
        $ret = null;
        $error = '';
        if ($id = ($_GET['id'] ?? "")) {

            try{
                $ret = user::get($id);

                if($_POST['username'] ?? ""){
                    $pass = $_POST['password'] ?? '';
                                      
                    if(strlen($pass) < 8 || strlen($pass) > 20){
                        $error .= "Mật khẩu có độ dài từ 8 đến 20 kí tự <br>";
                    }
                    else {
                        user::save($id, $_POST);
                        // $ret = user::get($id);
                        $msg = "Update thành công!";
                    }                   
                    echo '<pre>';
                    print_r($_POST);
                    echo '</pre>';
                    
                    // Header("Location: /admin/users");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                // return null;
            }


        }
        require_once "../app/views/users/userEdit.php";
    }
    public static function list()
    {
    
        try{
            //sort_by & sort_type
            $sort_by = $_GET['sort_by'] ?? 0;
            $sort_type = $_GET['sort_type'] ?? 0;

            $search_email = $_GET['search_email'] ?? '';


            //Limit/Offset
            $page = $_GET['page'] ?? 1;
            $limit = 5;
            $param = ['page'=>$page, 
            'limit'=>$limit, 
            'sort_by'=>$sort_by, 
            'sort_type'=>$sort_type,
            'search_email'=>$search_email];

            $data = User::list($param);

            $total = User::count($param);

            // echo("<br/> nPage = $total ");
            
            $nPage = ceil($total / $limit);


            
        } catch (PDOException $e) {
            $error = "<br> Có lỗi" . $e->getMessage() .$e->getTraceAsString();
            // return null;
        }
        require_once "../app/views/users/userList.php";
    }

    public static function bin()
    {
    
        try{
            //sort_by & sort_type
            $sort_by = $_GET['sort_by'] ?? 0;
            $sort_type = $_GET['sort_type'] ?? 0;

            $search_email = $_GET['search_email'] ?? '';


            //Limit/Offset
            $page = $_GET['page'] ?? 1;
            $limit = 5;
            $param = ['page'=>$page, 
            'limit'=>$limit, 
            'sort_by'=>$sort_by, 
            'sort_type'=>$sort_type,
            'search_email'=>$search_email];

            $data = User::listBin($param);

            $total = User::countBin($param);

            // echo("<br/> nPage = $total ");
            
            $nPage = ceil($total / $limit);


            
        } catch (PDOException $e) {
            $error = "<br> Có lỗi" . $e->getMessage() .$e->getTraceAsString();
            // return null;
        }
        require_once "../app/views/users/userBin.php";
    }

    public static function add()
    {
        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/User.php";
        if ($_POST['username'] ?? "") {
            
            try{
                $user = $_POST['username'];
                $email = $_POST['email'];
                $pass1 = $_POST['password'];

                if (preg_match('/^[a-zA-Z0-9_]+$/', $user)) {
                } else {
                    $error .= "Tên tài khoản chỉ gồm chữ và số <br>";
                }

                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                } else {
                    $error .= "Email không đúng định dạng <br>";
                }

                if (strlen($pass1) < 8 || strlen($pass1) > 20) {
                    $error .= "Mật khẩu có độ dài từ 8 đến 20 kí tự <br>";
                }

                if (!$error) {
                    if( User::add($_POST)){
                        Header("Location: /admin/users");

                    }else{
                        echo ("Có lỗi đăng kí!! <br>");
                    }

                    $msg = "Đăng kí thành công";
                } 


            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                // return null;
            }
            // require_once "../app/views/users/userAdd.php";

        }
        require_once "../app/views/users/userAdd.php";

        
    }

    public static function delete()
    {
        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/User.php";

        if ($id = ($_GET['id'] ?? "")) {

            try{
                $ret = user::delete($id);
                if($ret){
                    Header("Location: /admin/users");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }


        }
        // require_once "../app/views/users/userAdd.php";
    }

    public static function bin_delete()
    {

        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/User.php";

        if ($id = ($_GET['id'] ?? "")) {

            try{
                $ret = user::bin_delete($id);
                if($ret){
                    Header("Location: /admin/users/bin");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }


        }
        // require_once "../app/views/users/userAdd.php";
    }

    public static function bin_restore()
    {

        // echo("<br/> Đây là trang ADMIN");
        require_once "../app/models/User.php";

        if ($id = ($_GET['id'] ?? "")) {

            try{

                $ret = user::bin_restore($id);
                if($ret){
                    Header("Location: /admin/users");
                }
            } catch (PDOException $e) {
                $error = "<br> Có lỗi" . $e->getMessage();
                return null;
            }


        }
        // require_once "../app/views/users/userAdd.php";
    }
}
