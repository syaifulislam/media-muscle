<?php

Route::group(['prefix' => 'user', 'middleware' => 'adminCMS', 'as' => 'user'], function () {
    Route::get('/', 'UserController@index');
    Route::get('/view/{id}', 'UserController@view');
    Route::get('/create', 'UserController@form');
    Route::post('/store', 'UserController@store');
});
