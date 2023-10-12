<?php

define('def_salt', "abc");// Để gán thêm vào mật khẩu md5 bảo vệ tìa khoản

class BaseModel
{

    // public static function auth($user, $pass)
    // {
           
    //             // $pass0 = $pass;
    //             $pass = md5($pass.def_salt);

                
    //             // die("123: $pass / $pass0 ");

    //             $conn = Database::getConnection();

    //             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //             $stmt = $conn->prepare("SELECT * FROM Users WHERE (username=:user or email=:user) AND password=:pass LIMIT 1");
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

    public static function delete($id){
        $conn = Database::getConnection();
            $stmt = $conn->prepare("UPDATE users SET delete_date = now() WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
    }

    public static function bin_restore($id){
        $conn = Database::getConnection();
            $stmt = $conn->prepare("UPDATE users SET delete_date = NULL WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
    }

    public static function bin_delete($id){
        $conn = Database::getConnection();
            $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
    }
    public static function add($param){

        $conn = Database::getConnection();
        $username = $param['username'];
        $email = $param['email'];
        $password = $param['password'];
        $password = md5($password.def_salt);
        $is_admin = $param['is_admin'] ?? "";


            $stmt = $conn->prepare("INSERT INTO users (username, email, password, is_admin) VALUES (:username, :email, :password, :is_admin)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password); 
            $stmt->bindParam(':is_admin', $is_admin);     
            return $stmt->execute();
    }

    public static function save($id, $param){
        $conn = Database::getConnection();
        $username = $param['username'];
        $email = $param['email'];
        $password = $param['password'];
        $password = md5($password.def_salt);
        $is_admin = $param['is_admin'] ?? '';


            $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email, password = :password,is_admin = :is_admin  WHERE id = :id");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password); 
            $stmt->bindParam(':is_admin', $is_admin);   
  
            return $stmt->execute();
    }

    public static function get($id)
    {
            try {

                $conn = Database::getConnection();

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM Users WHERE id=:id");
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

       

        $conn = Database::getConnection();
        $sql = "SELECT count(*) AS c FROM users  WHERE delete_date IS NULL";

        $search_email = $param['search_email'] ?? '';


        // $search_string = null;

        if($search_email){            
            // $search_string = "AND email LIKE :search_email ";
            $sql = "SELECT count(*) AS c FROM users  WHERE delete_date IS NULL AND email LIKE :search_email  ;";
            // echo "search_email = :search_email";
            // echo("<br/> search_email =  $search_email;");
            
        }


        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare($sql);

        if($search_email){
            $search_email = "%$search_email%";
            $stmt->bindParam(':search_email' , $search_email);
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

       

        $conn = Database::getConnection();
        $sql = "SELECT count(*) AS c FROM users  WHERE delete_date IS NOT NULL";

        $search_email = $param['search_email'] ?? '';


        // $search_string = null;

        if($search_email){            
            // $search_string = "AND email LIKE :search_email ";
            $sql = "SELECT count(*) AS c FROM users  WHERE delete_date IS NOT NULL AND email LIKE :search_email  ;";
            // echo "search_email = :search_email";
            // echo("<br/> search_email =  $search_email;");
            
        }


        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare($sql);

        if($search_email){
            $search_email = "%$search_email%";
            $stmt->bindParam(':search_email' , $search_email);
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
                $page = $param['page'];
                $limit = $param['limit'];
                $offset = ($page - 1) * $limit;


                // $sql = "SELECT * FROM Users LIMIT :limit OFFSET :offset; ";

                $sort_by=$param['sort_by'];
                $sort_type=$param['sort_type'];
                $search_email = $param['search_email'];

                $search_string = null;

                if($search_email){
                    $search_string = "AND email LIKE :search_email ";
                }

                $sql = "SELECT * FROM users WHERE delete_date is null $search_string LIMIT :limit OFFSET :offset";
                if(in_array($sort_by, ['username', 'email'])){
                    if(in_array($sort_type, ['asc', 'desc'])){
                        $sql = "SELECT * FROM Users WHERE delete_date is null $search_string ORDER BY $sort_by $sort_type LIMIT :limit OFFSET :offset; ";
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
                if($search_email){
                    $search_email = "%$search_email%";
                    $stmt->bindParam(':search_email' , $search_email);
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
                $page = $param['page'];
                $limit = $param['limit'];
                $offset = ($page - 1) * $limit;


                // $sql = "SELECT * FROM Users LIMIT :limit OFFSET :offset; ";

                $sort_by=$param['sort_by'];
                $sort_type=$param['sort_type'];
                $search_email = $param['search_email'];

                $search_string = null;

                if($search_email){
                    $search_string = "AND email LIKE :search_email ";
                }

                $sql = "SELECT * FROM users WHERE delete_date is not null $search_string LIMIT :limit OFFSET :offset";
                if(in_array($sort_by, ['username', 'email'])){
                    if(in_array($sort_type, ['asc', 'desc'])){
                        $sql = "SELECT * FROM Users WHERE delete_date is not null $search_string ORDER BY $sort_by $sort_type LIMIT :limit OFFSET :offset; ";
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
                if($search_email){
                    $search_email = "%$search_email%";
                    $stmt->bindParam(':search_email' , $search_email);
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
}
