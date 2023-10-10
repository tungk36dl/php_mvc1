<?php

class product
{


    


    public static function edit($param){
        // die("123");
        $conn = Database::getConnection();
        $name = $param['name'];
        $code = $param['code'];
        $description = $param['description'];
        $price = $param['price'];
            $stmt = $conn->prepare("INSERT INTO products (name, code, description, price ) VALUES (:name, :code, :description, :price)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':description', $description);   
            $stmt->bindParam(':price', $price);   
            return $stmt->execute();
    }
    public static function delete($id){
        $conn = Database::getConnection();
            $stmt = $conn->prepare("UPDATE products SET delete_date = now() WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
    }

    public static function bin_restore($id){
        $conn = Database::getConnection();
            $stmt = $conn->prepare("UPDATE products SET delete_date = null WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
    }

    public static function bin_delete($id){
        $conn = Database::getConnection();
            $stmt = $conn->prepare("DELETE FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
    }
    public static function add($param){
        // die("124");
        $conn = Database::getConnection();
        $name = $param['name'];
        $code = $param['code'];
        $description = $param['description'];
        $price = $param['price'];
            $stmt = $conn->prepare("INSERT INTO products (name, code, description, price) VALUES (:name, :code, :description, :price)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':description', $description);   
            $stmt->bindParam(':price', $price);   
            return $stmt->execute();
    }

    public static function save($id, $param){
        $conn = Database::getConnection();
        $name = $param['name'];
        $code = $param['code'];
        $description = $param['description'];
        $price = $param['price'];
            $stmt = $conn->prepare("UPDATE products SET name = :name, code = :code, description = :description, price = :price WHERE id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':description', $description);   
            $stmt->bindParam(':price', $price);  
            return $stmt->execute();
    }

    public static function get($id)
    {
            try {

                $conn = Database::getConnection();

                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $conn->prepare("SELECT * FROM products WHERE id=:id");
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
        // $sql = "SELECT count(*) AS c FROM products";

        $search_name = $param['search_name'] ?? '';


        $search_string = null;

        if($search_name){
            $search_string = "AND name LIKE :search_name ";
            // $sql = "SELECT count(*) AS c FROM products $search_string ";
        }


        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT count(*) AS c FROM products WHERE delete_date IS NULL $search_string");

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

    public static function count_bin($param = null){

       

        $conn = Database::getConnection();
        // $sql = "SELECT count(*) AS c FROM products";

        $search_name = $param['search_name'] ?? '';


        $search_string = null;

        if($search_name){
            $search_string = "AND name LIKE :search_name ";
            // $sql = "SELECT count(*) AS c FROM products $search_string ";
        }


        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT count(*) AS c FROM products WHERE delete_date IS NOT NULL $search_string");

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


                // $sql = "SELECT * FROM products LIMIT :limit OFFSET :offset; ";

                $sort_by=$param['sort_by'];
                $sort_type=$param['sort_type'];
                $search_name = $param['search_name'];

                $search_string = null;

                if($search_name){
                    $search_string = "AND name LIKE :search_name ";
                }

                $sql = "SELECT * FROM products WHERE delete_date IS NULL  $search_string LIMIT :limit OFFSET :offset";
                if(in_array($sort_by, ['name', 'price'])){
                    if(in_array($sort_type, ['asc', 'desc'])){
                        $sql = "SELECT * FROM products WHERE delete_date IS NULL  $search_string ORDER BY $sort_by $sort_type LIMIT :limit OFFSET :offset; ";
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

    public static function list_bin($param)
    {
            // $servername = "localhost";
            // $name = "root";
            // $password = "";

                $page = $param['page'];
                $limit = $param['limit'];
                $offset = ($page - 1) * $limit;


                // $sql = "SELECT * FROM products LIMIT :limit OFFSET :offset; ";

                $sort_by=$param['sort_by'];
                $sort_type=$param['sort_type'];
                $search_name = $param['search_name'];

                $search_string = null;

                if($search_name){
                    $search_string = "AND name LIKE :search_name ";
                }

                $sql = "SELECT * FROM products WHERE delete_date IS NOT NULL  $search_string LIMIT :limit OFFSET :offset";
                if(in_array($sort_by, ['name', 'price'])){
                    if(in_array($sort_type, ['asc', 'desc'])){
                        if($sort_by === 'price'){
        
                            $sql = "SELECT * FROM products WHERE delete_date IS NOT NULL $search_string ORDER BY $sort_by $sort_type LIMIT :limit OFFSET :offset; ";
                        }
                        else{
                            $sql = "SELECT * FROM products WHERE delete_date IS NOT NULL $search_string ORDER BY $sort_by $sort_type LIMIT :limit OFFSET :offset; ";

                        }
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
