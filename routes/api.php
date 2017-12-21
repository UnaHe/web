<?php
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

Route::domain(config('domains.api_domain'))->middleware(\App\Http\Middleware\ApiLog::class)->namespace('App\Http\Controllers')->group(function (){
    /**
     * 查询券信息, 工具验证券有效性调用
     */
    Route::get('/coupon', "TaobaoController@getTaobaoCoupon");

    /**
     * 授权登录
     */
    Route::post('/oauth/token', [
        'uses' => 'Auth\AccessTokenController@issueToken',
        'middleware' => 'throttle',
    ]);

    /**
     * 注册
     */
    Route::post('/register', "UserController@register");

    /**
     * 注册验证码
     */
    Route::post('/captcha/registerSms', "UserController@registerSms");

    /**
     * 修改密码验证码
     */
    Route::post('/captcha/modifyPasswordSms', "UserController@modifyPasswordSms");

    /**
     * 修改密码，忘记密码
     */
    Route::post('/modifyPassword', "UserController@modifyPassword");

    /**
     * 淘宝授权登录跳转
     */
    Route::get('/taobao/auth', "TaobaoController@auth");


    /**
     * 需要登录访问的接口列表
     */
    Route::middleware('auth.api')->group(function(){

        /**
         * 获取消息列表
         */
        Route::get('/messages', "MessageController@getMessageList");
        /**
         * 获取消息详情
         */
        Route::get('/messages/{messageId}', "MessageController@getMessage")->where('messageId', '[0-9]+');
        /**
         * 删除消息
         */
        Route::delete('/messages/{messageId}', "MessageController@deleteMessage")->where('messageId', '[0-9]+');
        /**
         * 获取未读消息数量
         */
        Route::get('/messages/unReadNum', "MessageController@unReadNum");

        /**
         * 商品转链
         */
        Route::post('/transferLink', "TransferController@transferLink");

        /**
         * 淘口令解析
         */
        Route::post('/queryTaoCode', "TransferController@queryTaoCode");

        /**
         * 保存淘宝授权信息
         */
        Route::post('/taobao/saveToken', "TaobaoController@saveAuthToken");

        /**
         * 保存PID
         */
        Route::post('/taobao/savePid', "TaobaoController@savePid");

        /**
         * 查询pid绑定状态和授权状态
         */
        Route::get('/taobao/authInfo', "TaobaoController@authInfo");

        /**
         * 提交意见反馈
         */
        Route::post('/feedback', "FeedbackController@feedback");

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

