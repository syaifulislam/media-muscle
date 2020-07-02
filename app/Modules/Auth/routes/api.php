<?php
Route::group(['prefix' => 'v1/api'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthApiController@login');
        Route::post('register', 'AuthApiController@register');
        Route::post('confirmEmail', 'AuthApiController@confirm_email');
        Route::post('forgotPassword', 'AuthApiController@forgot_password');
        Route::post('forgotPasswordGenerate', 'AuthApiController@forgot_password_generate');
    });

    Route::group(['prefix' => 'help'], function () {
        Route::post('/', 'AuthApiController@helpMail');
    });

    Route::group(['prefix' => 'city'], function () {
        Route::get('/', 'AuthApiController@city');
    });

    Route::group(['prefix' => 'member','middleware'=>'websiteApi'], function () {
        Route::get('getMe', 'AuthApiController@me');
        Route::post('update', 'AuthApiController@updateProfileMember');
        Route::post('changePassword', 'AuthApiController@changePasswordMember');
    });
});