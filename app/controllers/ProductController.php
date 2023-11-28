<?php

require_once "../app/models/Product.php";

require_once "BaseController.php";
class ProductController extends BaseController
{
    static public $model = product::class;
    // static public $viewPathModel = "../app/views/users";
    static public $viewFileName = "product";

    static public $nameTable = "products";

}