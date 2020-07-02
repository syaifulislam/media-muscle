<?php
Route::group(['prefix' => 'v1/api'], function () {
    Route::group(['prefix' => 'television','middleware'=>'websiteApi'], function () {
        Route::get('dropdown', 'TelevisionApiController@dropdown');
        Route::post('getPrice', 'TelevisionApiController@get_price');
        Route::get('getProgram/{id}', 'TelevisionApiController@get_program');
    });

    Route::group(['prefix' => 'radio','middleware'=>'websiteApi'], function () {
        Route::get('dropdown', 'RadioApiController@dropdown');
        Route::post('getPrice', 'RadioApiController@get_price');
    });

    Route::group(['prefix' => 'newspaper','middleware'=>'websiteApi'], function () {
        Route::get('dropdown', 'NewspaperApiController@dropdown');
        Route::post('getPrice', 'NewspaperApiController@get_price');
    });

    Route::group(['prefix' => 'outOfHome','middleware'=>'websiteApi'], function () {
        Route::get('dropdown', 'OutOfHomeApiController@dropdown');
        Route::post('getPrice', 'OutOfHomeApiController@get_price');
    });
});