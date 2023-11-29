<?php

require_once "BaseModel.php";

class tintuc extends  BaseModel
{ 
    static $table = 'news';

    static $fillable = ['name' , 'thumb', 'description', 'content'];
    static $search_field = 'name';
    static $sort_field = ['name', 'created_at'];



    static $indexListField = ['id', 'name', 'thumb', 'description' , 'content','created_at'];
    static $metaFieldName = [
        'id' => 'Mã tin tức',
        'name' => 'Tên tin tức',
        'thumb' => 'Ảnh',
        'description' => 'Mô tả ',
        'content' => 'Nội dung',
        'created_at' => 'Ngày tạo',

    ];

  static $metaFieldType = [
    'thumb' => 'image',
    'content' => 'textarea',
    'description' => 'textarea',
    'cat_id' => 'checkbox',
  ];

  static $nameView = 'Tin tức';  

}




