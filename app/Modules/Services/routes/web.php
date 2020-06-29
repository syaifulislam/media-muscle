<?php

Route::group(['prefix' => 'services', 'middleware' => 'adminCMS', 'as' => 'services'], function () {
    Route::group(['prefix' => 'television'], function () {
        Route::get('/', 'TelevisionController@index');
        Route::get('form', 'TelevisionController@form');
        Route::get('form/{id}', 'TelevisionController@form');
        Route::get('detail/{id}', 'TelevisionController@detail');
        Route::get('detail-television/{id}', 'TelevisionController@detail_television');
        Route::post('detail/{id}', 'TelevisionController@detail_post');
        Route::post('post', 'TelevisionController@post');
    });

    Route::group(['prefix' => 'radio'], function () {
        Route::get('/', 'RadioController@index');
        Route::get('form', 'RadioController@form');
        Route::get('form/{id}', 'RadioController@form');
        Route::get('detail/{id}', 'RadioController@detail');
        Route::post('detail/{id}', 'RadioController@detail_post');
        Route::get('detail-radio/{id}', 'RadioController@detail_radio');
        Route::post('post', 'RadioController@post');
    });
});
