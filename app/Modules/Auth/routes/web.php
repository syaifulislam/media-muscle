<?php

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', 'AuthController@page');

    Route::post('login', 'AuthController@action');

    Route::get('logout', 'AuthController@logout');
});
