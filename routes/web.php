<?php

//中转域名跳转
Route::domain(env('REDIRECT_DOMAIN'))->get('/wx/{id}', 'WechatPageController@redirect')->where('id', '[0-9]+');

//微信中转单页
Route::get('/wx/{id}', 'WechatPageController@page')->where('id', '[0-9]+');
