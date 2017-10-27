<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 15:51
 */
namespace App\Services;

use App\Models\GoodsCategory;

class CategoryService
{
    /**
     * 获取所有商品分类
     * @return mixed
     */
    public function getAllCategory(){
        return GoodsCategory::select("id", "name", "icon_url")->orderBy("sort", "desc")->get();
    }
}
