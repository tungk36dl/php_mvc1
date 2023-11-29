<?php

define('def_salt', "abc");// Để gán thêm vào mật khẩu md5 bảo vệ tìa khoản

class BaseModel
{
    static $table;
    static $fillable;

    static $search_field;
    static $sort_field;
    static $maHoaPassword;
    static function validation($param){
    }
    

    public static function delete($id){
        $table = static::$table;

        $conn = Database::getConnection();
            $stmt = $conn->prepare("UPDATE $table SET delete_date = now() WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
    }

    public static function bin_restore($id){
        $table = static::$table;

        $conn = Database::getConnection();
            $stmt = $conn->prepare("UPDATE $table SET delete_date = NULL WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
    }

    public static function bin_delete($id){
        $table = static::$table;

        $conn = Database::getConnection();
            $stmt = $conn->prepare("DELETE FROM $table WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
    }

    public static function add($param){
        $table = static::$table;

        // if($table == 'user') { 
        //     user::validation($param);
        // }
        static::validation($param);


        $conn = Database::getConnection();

        $fillable = static::$fillable;

        $strField = '';
        $strBind = '';
        $arrBind = [];
        foreach($fillable AS $field){
            $strField .= "$field,";
            $strBind .= ":$field,";
            $arrBind[$field] = $param[$field] ?? "";
    
        }
        $strField = trim($strField, ',');
        $strBind = trim($strBind, ',');

        // $username = $param['username'];
        // $email = $param['email'];
        // $password = $param['password'];
        // $password = md5($password.def_salt);
        // $is_admin = $param['is_admin'] ?? "";
        // echo("$strBind");
        // die("<br> 1243");

            $stmt = $conn->prepare("INSERT INTO $table ($strField) VALUES ($strBind)");


            foreach($arrBind AS $field => $val){
                if($field == 'password'){
                    $val = md5($val.def_salt);
                    $stmt->bindValue(":$field", $val);

                }else
                    $stmt->bindValue(":$field", $val);
            }
            // $stmt->bindParam(':username', $username);
            // $stmt->bindParam(':email', $email);
            // $stmt->bindParam(':password', $password); 
            // $stmt->bindParam(':is_admin', $is_admin);     
            // return $stmt->execute();

            if($stmt->execute()) {
                return $conn->lastInsertId();
            }
            return null;
    }

    public static function save($id, $param){

        if(!is_numeric($id)) {
            throw new Exception("Save: Not valid id!");
        }


        $table = static::$table;

        static::validation($param);

        $conn = Database::getConnection();

        $fillable = static::$fillable;

        $strField = '';
        // $strBind = '';
        $arrBind = [];
        foreach($fillable AS $field){
            if(!isset($param[$field]))
                continue; // Câu điều kiện này dùng để khi sử dụng edit bằng API chỉ post 1 phần tử thì sẽ vẫn tiếp tục(ko cần phải post đủu số phần tử) mà ko bị báo lỗi 
            
            $strField .= "$field=:$field,";
            $arrBind[$field] = $param[$field];


        }
        $strField = trim($strField, ',');
        // $strBind = trim($strBind, ',');



        // $username = $param['username'];
        // $email = $param['email'];
        // $password = $param['password'];
        // $password = md5($password.def_salt);
        // $is_admin = $param['is_admin'] ?? '';
        // echo("$strField");
        // die("123");

            $stmt = $conn->prepare("UPDATE $table SET $strField  WHERE id = $id");


            foreach($arrBind AS $field => $val){
                if($field == 'password'){
                    $val = md5($val.def_salt);
                    $stmt->bindValue(":$field", $val);

                }else
                    $stmt->bindValue(":$field", $val);
            }
            // $stmt->bindParam(':username', $username);
            // $stmt->bindParam(':id', $id);
            // $stmt->bindParam(':email', $email);
            // $stmt->bindParam(':password', $password); 
            // $stmt->bindParam(':is_admin', $is_admin);   
  
            return $stmt->execute();
    }

    public static function get($id)
    {
        $table = static::$table;

            try {

                $conn = Database::getConnection();

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM $table WHERE id=:id");
                $stmt->bindParam(':id', $id);

                $stmt->execute();

                // set the resulting array to associative
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $ret = $stmt->fetchAll();

                if($ret) {
                    return $ret[0];
                }

                return null;

                // echo '<pre>';
                // print_r($ret);
                // echo '</pre>';
                

            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
           
    }

    public static function count($param){
        $table = static::$table;

        $search_field = static::$search_field;

       

        $conn = Database::getConnection();
        $sql = "SELECT count(*) AS c FROM $table  WHERE delete_date IS NULL";

        $search_value = $param['search_value'] ?? '';


        // $search_string = null;

        if($search_value){            
            // $search_string = "AND email LIKE :search_value ";
            $sql = "SELECT count(*) AS c FROM $table  WHERE delete_date IS NULL AND $search_field LIKE :search_value  ;";
            // echo "search_value = :search_value";
            // echo("<br/> search_value =  $search_value;");
            
        }


        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare($sql);

        if($search_value){
            $search_value = "%$search_value%";
            $stmt->bindParam(':search_value' , $search_value);
        }
        $stmt->execute();

        // echo '<pre>';
        // print_r($stmt->debugDumpParams());
        // echo '</pre>';

      

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $ret = $stmt->fetchAll();

        return $ret[0]['c']; 
    
        

    }

    public static function countBin($param){
        $table = static::$table;

        $search_field = static::$search_field;

       

        $conn = Database::getConnection();
        $sql = "SELECT count(*) AS c FROM $table  WHERE delete_date IS NOT NULL";

        $search_value = $param['search_value'] ?? '';


        // $search_string = null;

        if($search_value){            
            // $search_string = "AND email LIKE :search_value ";
            $sql = "SELECT count(*) AS c FROM $table  WHERE delete_date IS NOT NULL AND $search_field LIKE :search_value  ;";
            // echo "search_value = :search_value";
            // echo("<br/> search_value =  $search_value;");
            
        }


        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare($sql);

        if($search_value){
            $search_value = "%$search_value%";
            $stmt->bindParam(':search_value' , $search_value);
        }
        $stmt->execute();

        // echo '<pre>';
        // print_r($stmt->debugDumpParams());
        // echo '</pre>';

      

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $ret = $stmt->fetchAll();

        return $ret[0]['c']; 
    }

    

    public static function list($param)
    {
        $table = static::$table;




                $page = $param['page'];
                $limit = $param['limit'];
                $offset = ($page - 1) * $limit;


                // $sql = "SELECT * FROM $table LIMIT :limit OFFSET :offset; ";

                $sort_by=$param['sort_by'];
                $sort_type=$param['sort_type'];
                $search_value = $param['search_value'];

                $search_string = "";

                if($search_value){
                    $search_string = "AND ".static::$search_field ." LIKE :search_value ";
                }
                // echo(" search_string = ".$search_string);

                $sql = "SELECT * FROM $table WHERE delete_date is null $search_string LIMIT :limit OFFSET :offset";
                if(in_array($sort_by, static::$sort_field)){
                    if(in_array($sort_type, ['asc', 'desc'])){
                        $sql = "SELECT * FROM $table WHERE delete_date is null $search_string ORDER BY $sort_by $sort_type LIMIT :limit OFFSET :offset; ";
                    }
                }

                $conn = Database::getConnection();

                // $conn = new PDO("mysql:host=$servername;dbname=demo_mvc", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Connected successfully";

                // echo '<pre>';
                // print_r($sql);
                // echo '</pre>';

                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':limit' , $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset' , $offset, PDO::PARAM_INT);
                if($search_value){
                    $search_value = "%$search_value%";
                    $stmt->bindParam(':search_value' , $search_value);
                }

                $stmt->execute();

                // set the resulting array to associative
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $ret = $stmt->fetchAll();
                // echo '<pre>';
                // print_r($ret);
                // echo '</pre>';
                return $ret;

    }

    public static function listBin($param)
    {
        $table = static::$table;


                $page = $param['page'];
                $limit = $param['limit'];
                $offset = ($page - 1) * $limit;


                // $sql = "SELECT * FROM $table LIMIT :limit OFFSET :offset; ";

                $sort_by=$param['sort_by'];
                $sort_type=$param['sort_type'];
                $search_value = $param['search_value'];

                $search_string = null;

                if($search_value){
                    $search_string = "AND ".static::$search_field ."  LIKE :search_value ";
                }

                $sql = "SELECT * FROM $table WHERE delete_date is not null $search_string LIMIT :limit OFFSET :offset";
                if(in_array($sort_by, static::$sort_field)){
                    if(in_array($sort_type, ['asc', 'desc'])){
                        $sql = "SELECT * FROM $table WHERE delete_date is not null $search_string ORDER BY $sort_by $sort_type LIMIT :limit OFFSET :offset; ";
                    }
                }

                $conn = Database::getConnection();

                // $conn = new PDO("mysql:host=$servername;dbname=demo_mvc", $username, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Connected successfully";



                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':limit' , $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset' , $offset, PDO::PARAM_INT);
                if($search_value){
                    $search_value = "%$search_value%";
                    $stmt->bindParam(':search_value' , $search_value);
                }

                $stmt->execute();

                // set the resulting array to associative
                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

                $ret = $stmt->fetchAll();
                // echo '<pre>';
                // print_r($ret);
                // echo '</pre>';
                return $ret;

    }
        // public static function auth($user, $pass)
    // {
        // $table = static::$table;

           
    //             // $pass0 = $pass;
    //             $pass = md5($pass.def_salt);

                
    //             // die("123: $pass / $pass0 ");

    //             $conn = Database::getConnection();

    //             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //             $stmt = $conn->prepare("SELECT * FROM $table WHERE (username=:user or email=:user) AND password=:pass LIMIT 1");
    //             $stmt->bindParam(':user', $user);
    //             $stmt->bindParam(':pass', $pass);


    //             $stmt->execute();

    //             // set the resulting array to associative
    //             $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

    //             $ret = $stmt->fetch();

    //             if($ret) {
    //                 return $ret;
    //             }

    //             return null;

    //             // echo '<pre>';
    //             // print_r($ret);
    //             // echo '</pre>';
                        
    // }
}
