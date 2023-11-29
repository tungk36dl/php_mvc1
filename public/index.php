<?php


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

require_once "../app/Database.php";

$rqUri = $_SERVER['REQUEST_URI'];


require_once "../app/Helper/auth.php";

if(!auth::authorization($rqUri)){
    return;
}



$routes = [
    '/login' =>  [LoginController::class, 'login'],
    '/registration' =>  [LoginController::class, 'registration'],

    '/logout' =>  [LoginController::class, 'logout'],

    '/admin/news/add' => [NewController::class, 'add'],
    '/admin/news/delete' => [NewController::class, 'delete'],
    '/admin/news/edit' => [NewController::class, 'edit'],
    '/admin/news/bin/delete' => [NewController::class, 'bin_delete'],
    '/admin/news/bin/restore' => [NewController::class, 'bin_restore'],
    '/admin/news/bin' => [NewController::class, 'bin'],
    '/admin/news' => [NewController::class, 'list'],

    '/admin/products/add' => [ProductController::class, 'add'],
    '/admin/products/delete' => [ProductController::class, 'delete'],
    '/admin/products/edit' => [ProductController::class, 'edit'],
    '/admin/products/bin/delete' => [ProductController::class, 'bin_delete'],
    '/admin/products/bin/restore' => [ProductController::class, 'bin_restore'],
    '/admin/products/bin' => [ProductController::class, 'bin'],
    '/admin/products' => [ProductController::class, 'list'],

    '/admin/users/add' => [UserController::class, 'add'],
    '/admin/users/delete' => [UserController::class, 'delete'],
    '/admin/users/edit' => [UserController::class, 'edit'],
    '/admin/users/bin/delete' => [UserController::class, 'bin_delete'],
    '/admin/users/bin/restore' => [UserController::class, 'bin_restore'],

    '/admin/users/bin' => [UserController::class, 'bin'],
    '/admin/users' => [UserController::class, 'list'],
    
    '/member' =>  [MemberController::class, 'index'],
    '/admin' => [AdminController::class, 'index'],





    '/api/news/get' => [NewController::class, 'get_api'],
    '/api/news/edit' => [NewController::class, 'edit_api'],
    '/api/news/delete' => [NewController::class, 'delete_api'],
    '/api/news/add' => [NewController::class, 'add_api'],
    '/api/news' => [NewController::class, 'list_api'],

    '/api/products/get' => [ProductController::class, 'get_api'],
    '/api/products/edit' => [ProductController::class, 'edit_api'],
    '/api/products/delete' => [ProductController::class, 'delete_api'],
    '/api/products/add' => [ProductController::class, 'add_api'],
    '/api/products' => [ProductController::class, 'list_api'],






    '/' =>  [HomeController::class, 'index'],
];

foreach($routes AS $uri => $arrayCtrl){
    // echo("<br/> uri = $uri ");

    $class = $arrayCtrl[0];
    $method = $arrayCtrl[1];

    // echo("<br/> class = $class, method = $method");
    

    $file = "../app/controllers/$class.php";
    if(str_starts_with($rqUri, $uri)){

        require_once $file;

        $obj = new $class;
        $obj->$method();

        break;
    }
    
    
}

if(str_starts_with($rqUri, "/api/")){
    die();
}

echo("<hr><br/>DeBug: URI = $rqUri");
echo '<pre>';
print_r(get_included_files());
echo '</pre>';


?>

