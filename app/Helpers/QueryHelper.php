<?php
/**
 * Created by PhpStorm.
 * User: yangtao
 * Date: 2017/10/18
 * Time: 16:26
 */
namespace App\Helpers;


use Illuminate\Database\Eloquent\Builder;

class QueryHelper
{
    /**
     * 构建分页查询条件
     * @param Builder $query
     * @return Builder
     */
    public function pagination(Builder $query){
        $request = app('request');
        //分页参数
        $page = $request->input("page");
        $page = $page ?: 1;
        $limit = $request->input("limit");
        $limit = $limit ?: 20;
        $start = ($page - 1)*$limit;

        return $query->skip($start)->take($limit);
    }
}