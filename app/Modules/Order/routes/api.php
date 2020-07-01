<?php

Route::group(['prefix' => 'v1/api'], function () {
    Route::group(['prefix' => 'order','middleware'=>'websiteApi'], function () {
        Route::post('/', 'OrderApiController@order');
        Route::get('history', 'OrderApiController@order_history');
    });
});