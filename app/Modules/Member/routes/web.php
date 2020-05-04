<?php

Route::group(['prefix' => 'member'], function () {
    Route::group(['prefix' => 'personal'], function () {
        Route::get('/', 'MemberController@indexPersonal');
    });
    Route::group(['prefix' => 'company'], function () {
        Route::get('/', 'MemberController@indexCompany');
    });
});
