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

\Illuminate\Support\Facades\Auth::routes();

Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
});


///**
// * 登录
// */
//Route::get('/login', "UserController@login");
//
///**
// * 注册
// */
//Route::get('/register', "UserController@register");
