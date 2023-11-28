<?php

require_once "../app/models/User.php";

require_once "BaseController.php";
class UserController extends BaseController
{
    static public $model = user::class;
    // static public $viewPathModel = "../app/views/users";
    static public $viewFileName = "user";

    static public $nameTable = "users";

}
