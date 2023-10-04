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

echo("<hr><br/>DeBug: URI = $rqUri");
echo '<pre>';
print_r(get_included_files());
echo '</pre>';


?>