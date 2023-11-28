<?php

require_once "BaseModel.php";

class product extends BaseModel
{
    static $table = 'products';

    static $fillable = ['name','code','description','price'];

    static $search_field = 'name';

    static $sort_field = ['name', 'price'];


    static $indexListField = ['id', 'name', 'code', 'description', 'price'];
    static $metaFieldName = [
        'id' => 'Mã SP',
        'name' => 'Tên sản phẩm',
        'description' => 'Mô tả',
        'code' => 'Mã sản phẩm',
        'created_at' => 'Ngày tạo',
        'cat_id' => 'Thể loại',
        'price' => 'Giá',
    ];

  static $metaFieldType = [
    'content' => 'textarea',
    'cat_id' => 'checkbox',
  ];

  static $nameView = 'Sản phẩm';    
}
