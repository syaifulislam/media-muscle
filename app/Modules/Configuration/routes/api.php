<?php

Route::group(['prefix' => 'v1/api'], function () {
    Route::group(['prefix' => 'banner'], function () {
        Route::get('/', 'BannerApiController@get_banner');
    });
});