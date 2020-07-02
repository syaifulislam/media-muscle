<?php

Route::group(['prefix' => 'order', 'middleware' => 'adminCMS', 'as' => 'order'], function () {
    Route::get('/', 'OrderController@index');
    Route::get('/{invoice_number}', 'OrderController@detail');
    Route::post('/{id}', 'OrderController@update');
});
