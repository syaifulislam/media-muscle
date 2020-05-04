<?php

Route::group(['prefix' => 'dashboard'], function () {
    Route::get('/', 'DashboardController@page');
});
