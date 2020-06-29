<?php

Route::group(['prefix' => 'whitelist', 'as' => 'whitelist'], function () {
    Route::group(['prefix' => 'city'], function () {
        Route::get('/', 'WhitelistController@city');
    });
});
