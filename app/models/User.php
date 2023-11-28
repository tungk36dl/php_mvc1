<?php

// define('def_salt', "abc"); // Để gán thêm vào mật khẩu md5 bảo vệ tìa khoản

require_once 'BaseModel.php';
class user extends BaseModel
{

    static $table = 'users';

    static $fillable = ['username', 'email', 'password', 'is_admin'];
    static $search_field = 'username ';
    static $sort_field = ['username', 'is_admin'];





    public static function validation($param){
        if (!isset($param['username'], $param['email'], $param['password'])) {
            throw new Exception("Thiếu thông tin tài khoản, email hoặc mật khẩu.");
        }
    
        $error = '';
    
        $user = $param['username'];
        $email = $param['email'];
        $pass1 = $param['password'];
    
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $user)) {
            $error .= "Tên tài khoản chỉ gồm chữ và số <br>";
        }
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error .= "Email không đúng định dạng <br>";
        }
    
        if (strlen($pass1) < 8 || strlen($pass1) > 20) {
            $error .= "Mật khẩu có độ dài từ 8 đến 20 kí tự <br>";
        }
    
        if ($error) {
            throw new Exception($error);
        }
    
        // Nếu không có lỗi, bạn có thể thực hiện các hành động khác ở đây
    
        return true; // Hoặc bạn có thể trả về một giá trị khác để xác nhận không có lỗi
    }



    public static function auth($user, $pass)
    {
           
                // $pass0 = $pass;
                $pass = md5($pass.def_salt);

                
                // die("123: $pass / $pass0 ");

                $conn = Database::getConnection();

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM Users WHERE (username=:user or email=:user) AND password=:pass LIMIT 1");
                $stmt->bindParam(':user', $user);
                $stmt->bindParam(':pass', $pass);


                $stmt->execute();

                // set the resulting array to associative
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $ret = $stmt->fetch();

                if($ret) {
                    return $ret;
                }

                return null;
                // echo '<pre>';
                // print_r($ret);
                // echo '</pre>';
            
                
    }



    
    static $indexListField = ['id', 'username', 'email' , 'is_admin'];
    static $metaFieldName = [
        'id' => 'ID',
        'username' => 'Tên',
        'email' => 'Email ',
        'password' => 'Mật khẩu',
        'is_admin' => 'Is_admin',

    ];

  static $metaFieldType = [

    'is_admin' => 'checkbox',
  ];

  static $nameView = 'Tin tức';  

//   static $maHoaPassword = ['password'];

}
