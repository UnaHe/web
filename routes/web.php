<?php

//微信中转单页
Route::get('/wx/{id}', 'WechatPageController@page')->where('id', '[0-9]+');