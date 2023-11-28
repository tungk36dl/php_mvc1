<?php

require_once "../app/models/New.php";

require_once "BaseController.php";
class NewController extends BaseController
{
    static public $model = tintuc::class;
    // static public $viewPathModel = "../app/views/users";
    static public $viewFileName = "new";

    static public $nameTable = "news";

}