<?php

//中转域名跳转
Route::domain(config('domains.redirect_domain'))->get('/wx/{id}', 'WechatPageController@redirect')->where('id', '[0-9]+');

//微信中转单页(加密和验证)
Route::get('/wx/{id}', 'WechatPageController@page')->where('id', '[0-9]+');

//微信中转单页(普通)
Route::get('/wx2/{id}', 'WechatPageController@page2')->where('id', '[0-9]+');

// QQ群采集
Route::any('/test', 'CaijiController@caiji');