<?php

Route::group(['prefix' => 'configuration', 'middleware' => 'adminCMS', 'as' => 'configuration'], function () {
    Route::get('city', 'CityController@index');
});
