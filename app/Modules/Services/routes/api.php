<?php
Route::group(['prefix' => 'v1/api'], function () {
    Route::group(['prefix' => 'television','middleware'=>'websiteApi'], function () {
        Route::get('dropdown', 'TelevisionApiController@dropdown');
        Route::post('getPrice', 'TelevisionApiController@get_price');
        Route::get('getProgram/{id}', 'TelevisionApiController@get_program');
    });
});