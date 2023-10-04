<?php

class tintuc
{ 

    public static function edit($param){
        $conn = Database::getConnection();
        $newname = $param['newname'];
        $description = $param['description'];
        $content = $param['content'];

            $stmt = $conn->prepare("INSERT INTO news (newname, description,  content) VALUES (:newname, :description,:content)");
            $stmt->bindParam(':newname', $newname);
            $stmt->bindParam(':description', $description);   
            $stmt->bindParam(':content', $content);   
            return $stmt->execute();
    }
    public static function delete($id){
        $conn = Database::getConnection();
            $stmt = $conn->prepare("DELETE FROM news WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
    }
    public static function add($param){
        // die("124");
        $conn = Database::getConnection();
        $newname = $param['newname'];
        $description = $param['description'];
        $content = $param['content'];
            $stmt = $conn->prepare("INSERT INTO news (newname, description, content) VALUES (:newname, :description, :content)");
            $stmt->bindParam(':newname', $newname);
            $stmt->bindParam(':description', $description);   
            $stmt->bindParam(':content', $content);   
            return $stmt->execute();
    }

    public static function save($id, $param){
        $conn = Database::getConnection();
        $newname = $param['newname'];
        $description = $param['description'];
        $content = $param['content'];
            $stmt = $conn->prepare("UPDATE news SET newname = :newname,  description = :description, content = :content WHERE id = :id");
            $stmt->bindParam(':newname', $newname);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':description', $description);   
            $stmt->bindParam(':content', $content);  
            return $stmt->execute();
    }

    public static function get($id)
    {
            try {

                $conn = Database::getConnection();

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM news WHERE id=:id");
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

    public static function count($param = null){

       

        $conn = Database::getConnection();
        $sql = "SELECT count(*) AS c FROM news";

        $search_name = $param['search_name'] ?? '';


        $search_string = null;

        if($search_name){
            $search_string = "WHERE newname LIKE :search_name ";
            $sql = "SELECT count(*) AS c FROM news $search_string ";
        }


        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT count(*) AS c FROM news $search_string");

        if($search_name){
            $search_name = "%$search_name%";
            $stmt->bindParam(':search_name' , $search_name);
        }

        $stmt->execute();

      

        // set the resulting array to associative
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $ret = $stmt->fetchAll();

        return $ret[0]['c']; 
    
        

    }

    public static function list($param)
    {
            // $servername = "localhost";
            // $name = "root";
            // $password = "";

         

                $page = $param['page'];
                $limit = $param['limit'];
                $offset = ($page - 1) * $limit;


                // $sql = "SELECT * FROM news LIMIT :limit OFFSET :offset; ";

                $sort_by=$param['sort_by'];
                $sort_type=$param['sort_type'];
                $search_name = $param['search_name'];

                $search_string = null;

                if($search_name){
                    $search_string = "WHERE newname LIKE :search_name ";
                }

                $sql = "SELECT * FROM news $search_string LIMIT :limit OFFSET :offset";
                if(in_array($sort_by, ['newname', 'created_at'])){
                    if(in_array($sort_type, ['asc', 'desc'])){
                        $sql = "SELECT * FROM news $search_string ORDER BY $sort_by $sort_type LIMIT :limit OFFSET :offset; ";
                    }
                }

                $conn = Database::getConnection();

                // $conn = new PDO("mysql:host=$servername;dbname=demo_mvc", $name, $password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // echo "Connected successfully";



                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':limit' , $limit, PDO::PARAM_INT);
                $stmt->bindParam(':offset' , $offset, PDO::PARAM_INT);
                if($search_name){
                    $search_name = "%$search_name%";
                    $stmt->bindParam(':search_name' , $search_name);
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

