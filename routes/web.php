<?php

//中转域名跳转
Route::domain(config('domains.redirect_domain'))->get('/wx/{id}', 'WechatPageController@redirect')->where('id', '[0-9]+');

//微信中转单页(加密和验证)
Route::get('/wx/{id}', 'WechatPageController@page')->where('id', '[0-9]+');

//微信中转单页(普通)
Route::get('/wx2/{id}', 'WechatPageController@page2')->where('id', '[0-9]+');

/**
 * 建设中
 */
Route::get('/construction/{name}', 'Web\IndexController@construction');

/**
 * 关于我们
 */
Route::get('/aboutUs', 'Web\IndexController@aboutUs');

/**
 * 首页
 */
Route::get('/', 'Web\IndexController@index');

/**
 * 商务合作页
 */
Route::get('/business ', 'Web\IndexController@business');

/**
 * 退出登录
 */
Route::get('/logout', 'Web\UserController@logout');

/**
 * 用户路由
 */
//用户注册
//Route::match(['get', 'post'], '/register', 'Web\UserController@register');
//用户是否存在
Route::post( '/isExist', 'Web\UserController@isExist');
//用户登录
Route::match(['get', 'post'], 'login', 'Web\UserController@login');
//用户忘记密码
Route::match(['get', 'post'], '/forgetPwd', 'Web\UserController@forgetPwd');
//用户获取手机验证码
Route::post('/getCode', 'Web\UserController@getCode');
//获取授权code
Route::any('/taobaoCode', 'Web\UserController@taobaoCode');

/**
 * 栏目商品列表
 */
Route::get('/columns/{code}/goods', 'Web\GoodsController@columnGoods');
/**
 * 商品列表
 */
Route::get('/goods', "Web\GoodsController@goodList");

/**
 * 热搜词
 */
Route::get('/hotKeyword', "Web\GoodsController@hotKeyWord");

/**
 * 限时抢购
 */
Route::get('/miaosha/goods', 'Web\GoodsController@getMiaoshaGoods');

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
    Route::post( '/accountUpdatePwd', 'Web\UserController@accountUpdatePwd');
    //授权管理
    Route::get('/accountAuth', 'Web\UserController@accountAuth');
    //授权管理
    Route::post('/updateAuth', 'Web\UserController@updateAuth');
    //删除用户授权
    Route::get('/delAuth', 'Web\UserController@delAuth');

    //商品详情
    Route::get('/goods/{goodsId}', "Web\GoodsController@detail")->where('goodsId', '[0-9]+');
    //生成连接
    Route::post('/transferLinkWeb', 'Web\GoodsController@transferLinkWeb');
    //关闭layer第三方弹框
    Route::get('/accountSucc', 'Web\UserController@accountSucc');

});