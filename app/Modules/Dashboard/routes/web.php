<?php

Route::group(['prefix' => 'dashboard', 'middleware' => 'adminCMS', 'as' => 'dashboard'], function () {
    Route::get('/', 'DashboardController@page');
});
