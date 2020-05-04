<?php

Route::group(['prefix' => 'auth'], function () {
    Route::get('login', 'AuthController@welcome');
});
