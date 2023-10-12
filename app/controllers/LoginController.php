<?php


require_once "../app/models/User.php";

class LoginController
{
    public static function login()
    {
        // echo("<br/> Đây là trang ADMIN");

        $_SESSION;

        if (isset($_POST['username'])) {
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $ret = User::auth($user, $pass);
            if ($ret) {

                $_SESSION['userinfo'] = $ret;

                $msg = "Đăng nhập thành công";
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!!!";
            }
        }


        require_once "../app/views/auth/login.php";
    }

    function registration()
    {
        // $_SESSION;
        try {
            $error = '';

            if (isset($_POST['username'])) {
                $user = $_POST['username'];
                $email = $_POST['email'];
                $pass1 = $_POST['password'];
                $pass2 = $_POST['re_password'];

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
                

                if ($pass1 === $pass2) {
                } else {
                    $error .= "Nhập lại mật khẩu không đúng!!!!<br>";
                }

                // Sử dụng biểu thức chính quy để kiểm tra định dạng username


                if (!$error) {
                    if( User::add($_POST)){
                
                    }else{
                        echo ("Có lỗi đăng kí!! <br>");
                    }

                    $msg = "Đăng kí thành công";
                } 
            }
        } catch (PDOException $e) {
            $error = "<br> Có lỗi" . $e->getMessage() ."<br>". $e->getTraceAsString();
            // return null;
        }


        require_once "../app/views/auth/registration.php";
    }






    public static function logout()
    {
        session_destroy();
        header("location: /login");
    }
}
