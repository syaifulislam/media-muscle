<?php

Route::group(['prefix' => 'member', 'middleware' => 'adminCMS', 'as' => 'member'], function () {
    Route::group(['prefix' => 'personal'], function () {
        Route::get('/', 'MemberController@indexPersonal');
        Route::get('/{id}', 'MemberController@indexPersonalDetail');
        Route::post('/{id}', 'MemberController@updatePersonal');
    });
    Route::group(['prefix' => 'company'], function () {
        Route::get('/', 'MemberController@indexCompany');
    });
});
