<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 注册
 */
Route::post('/register', "UserController@register");


/**
 * 商品分类
 */
Route::get('/categorys', "CategoryController@getAllCategory");

/**
 * 商品列表
 */
Route::get('/goods', "GoodsController@goodList");

/**
 * 商品详情
 */
Route::get('/goods/{goodsId}', "GoodsController@detail")->where('goodsId', '[0-9]+');

/**
 * 栏目商品列表
 */
Route::get('/columns/{code}/goods', "GoodsController@columnGoods");
