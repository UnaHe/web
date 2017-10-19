<?php

namespace App\Http\Controllers;
use App\Services\CategoryService;


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
        $data = (new CategoryService())->getAllCategory();
        return $this->ajaxSuccess($data);
    }

}
