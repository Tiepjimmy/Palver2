<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(),'prefix' => 'customers' ), function () {
    
    Route::get('/', 'CustomerController@index')
        ->name('customer.index');

    Route::get('/{id}', 'CustomerController@edit')
        ->name('customer.edit')->where('id', '[0-9]+');

    Route::post('/', 'CustomerController@store')
        ->name('customer.store');

    Route::patch('/{id}', 'CustomerController@update')
        ->name('customer.update')->where('id', '[0-9]+');

    Route::get('/province','CustomerController@getProvince')
        ->name('customer.province');

    Route::get('/district/{province_id}','CustomerController@getDistrict')
        ->name('customer.district');

    Route::get('/wards/{district}','CustomerController@getWards')
        ->name('customer.wards');

    Route::post('/check-unique','CustomerController@checkUnique')
        ->name('customer.checkUnique');

    Route::get('/{id}','CustomerController@detail')
        ->name('customer.edit')->where('id', '[0-9]+');
});

Route::group(['prefix' => 'customer-address', 'as' => 'customer-address.'], function () {
    Route::get('/', 'CustomerAddressController@list')->name('list');
    Route::get('/{id}', 'CustomerAddressController@show')->name('show');
    Route::post('/', 'CustomerAddressController@store')->name('store');
    Route::patch('/{id}', 'CustomerAddressController@update')->name('update');
    Route::delete('/{id}', 'CustomerAddressController@destroy')->name('destroy');
});
