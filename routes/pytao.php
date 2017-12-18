<?php
/*
* 朋友淘相关接口.
*/

Route::namespace('App\Http\Controllers')->group(function (){

    /**
     * WAP自动登录.
     */
    Route::get('/share/{code}', "Auth\AccessTokenController@Login");

    /**
     * 需要登录访问的接口列表
     */
    Route::middleware('pytao')->group(function(){

        /**
         * 商品转链
         */
        Route::post('/transferLink', "TransferController@transferLink");

        /**
         * 商品分类
         */
        Route::get('/categorys', "CategoryController@getAllCategory");

        /**
         * 商品列表
         */
        Route::get('/goods', "GoodsController@goodList");

        /**
         * 推荐商品列表
         */
        Route::get('/recommendGoods', "GoodsController@recommendGoods");

        /**
         * 商品详情
         */
        Route::get('/goods/{goodsId}', "GoodsController@detail")->where('goodsId', '[0-9]+');

        /**
         * 栏目商品列表
         */
        Route::get('/columns/{code}/goods', "GoodsController@columnGoods");

        /**
         * 指定位置广告banner列表
         */
        Route::get('/banners/{position}', "BannerController@getBanner");

        /**
         * 热搜词
         */
        Route::get('/hotKeyword', "GoodsController@hotKeyWord");

        /**
         * 全网搜索
         */
        Route::get('/queryAllGoods', "GoodsController@queryAllGoods");

        /**
         * 秒杀时间点
         */
        Route::get('/miaosha/times', "MiaoshaController@getTimes");

        /**
         * 服务器时间
         */
        Route::get('/miaosha/servertime', "MiaoshaController@getServerTime");

        /**
         * 秒杀商品列表
         */
        Route::get('/miaosha/goods', "MiaoshaController@getGoods");

    });

});

