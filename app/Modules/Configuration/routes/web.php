<?php

Route::group(['prefix' => 'configuration', 'middleware' => 'adminCMS', 'as' => 'configuration'], function () {

    Route::group(['prefix' => 'city'], function () {
        Route::get('/', 'CityController@index');  
    });

    Route::group(['prefix' => 'banner'], function () {
        Route::get('/', 'BannerController@index');
        Route::get('form', 'BannerController@form');
        Route::get('form/{id}', 'BannerController@form');
        Route::post('store', 'BannerController@store');
    });
});
