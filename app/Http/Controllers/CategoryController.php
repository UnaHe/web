<?php

namespace App\Http\Controllers;

use App\Models\GoodsCategory;


/**
 * 商品分类
 * Class CategoryController
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
{
    /**
     * 获取所有商品分类
     */
    public function getAllCategory(){
        $data = GoodsCategory::select("id", "name", "icon_url")->get();
        return $this->ajaxSuccess($data);
    }

}
