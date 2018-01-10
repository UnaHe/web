<?php

//中转域名跳转
Route::domain(config('domains.redirect_domain'))->get('/wx/{id}', 'WechatPageController@redirect')->where('id', '[0-9]+');

//微信中转单页(加密和验证)
Route::get('/wx/{id}', 'WechatPageController@page')->where('id', '[0-9]+');

//微信中转单页(普通)
Route::get('/wx2/{id}', 'WechatPageController@page2')->where('id', '[0-9]+');

/**
 * 首页
 */
Route::get('/', 'Web\IndexController@index');
/**
 * 用户路由
 */
Route::match(['get','post'],'/register', 'Web\UserController@register');
Route::match(['get','post'],'/login', 'Web\UserController@login');
Route::match(['get','post'],'/forgetPwd', 'Web\UserController@forgetPwd');


Route::post('/getCode', 'Web\UserController@getCode');
/**
 * 今日必推列表
 */
Route::get('/columns/{code}/goods', 'Web\GoodsController@columnGoods');

/**
 * 商品详情
 */
Route::get('/goods/{goodsId}', "Web\GoodsController@detail")->where('goodsId', '[0-9]+');

/**
 * 需要登录访问的接口列表
 */
Route::middleware(['middleware' => ['web']])->group(function(){

});

Route::group(['middleware' => 'auth'],function(){
    Route::match(['get','post'],'/updatePwd', 'Web\UserController@updatePwd');
    Route::match(['get','post'],'/updatePwdSucc', 'Web\UserController@updatePwdSucc');
});