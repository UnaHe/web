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
Route::get('/business ', 'Web\IndexController@business');
Route::get('/logout', 'Web\UserController@logout');
/**
 * 用户路由
 */
Route::match(['get', 'post'], '/register', 'Web\UserController@register');
Route::match(['get', 'post'], '/isExist', 'Web\UserController@isExist');
Route::match(['get', 'post'], '/login', 'Web\UserController@login');
Route::match(['get', 'post'], '/forgetPwd', 'Web\UserController@forgetPwd');
Route::get('/auth', 'Web\UserController@auth');


Route::post('/getCode', 'Web\UserController@getCode');
/**
 * 今日必推列表
 */
Route::get('/columns/{code}/goods', 'Web\GoodsController@columnGoods');
Route::get('/miaosha/goods', 'Web\GoodsController@getMiaoshaGoods');
/**
 * 商品详情
 */
Route::get('/goods/{goodsId}', "Web\GoodsController@detail")->where('goodsId', '[0-9]+');



Route::group(['middleware' => 'auth'], function () {
    //忘记密码=>修改密码
    Route::match(['get', 'post'], '/updatePwd', 'Web\UserController@updatePwd');
    //忘记密码=>修改密码成功
    Route::match(['get', 'post'], '/updatePwdSucc', 'Web\UserController@updatePwdSucc');
    //用户中心
    Route::match(['get', 'post'], '/userCenter', 'Web\UserController@userCenter');
    //账户安全
    Route::match(['get', 'post'], '/accountSecurity', 'Web\UserController@accountSecurity');
    //账户安全的修改密码
    Route::match(['get', 'post'], '/accountUpdatePwd', 'Web\UserController@accountUpdatePwd');
    //授权管理
    Route::get('/accountAuth', 'Web\UserController@accountAuth');
    //授权管理
    Route::match(['get', 'post'], '/updateAuth', 'Web\UserController@updateAuth');

    Route::get('/delAuth', 'Web\UserController@delAuth');


});