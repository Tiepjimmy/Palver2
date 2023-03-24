<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(),'prefix' => 'customer-groups' ), function () {

    Route::get('/', 'CustomerGroupController@index')
        ->name('customer_group.index');

    Route::post('/', 'CustomerGroupController@store')
        ->name('customer_group.store');

    Route::patch('/{id}/', 'CustomerGroupController@update')
        ->name('customer_group.update');

    Route::delete('/{id}/', 'CustomerGroupController@destroy')
        ->name('customer_group.destroy');

    Route::get('/all','CustomerGroupController@getAll')
        ->name('customer_group.all');
});