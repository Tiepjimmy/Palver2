<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(), 'prefix' => 'payment-accounts' ), function () {

    Route::get('all-payment','PaymentsController@getAll')->name('payments.all');

    Route::get('/', 'PaymentsController@index')
        ->name('payments.index');

    Route::get('/{id}', 'PaymentsController@edit')
        ->name('payments.edit')->where('id', '[0-9]+');

    Route::post('/', 'PaymentsController@store')
        ->name('payments.store');

    Route::patch('/{id}', 'PaymentsController@update')
        ->name('payments.update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'PaymentsController@destroy')
        ->name('payments.delete')->where('id', '[0-9]+');

    Route::get('/all-payment','PaymentsController@getAll')
        ->name('payments.all');

});

Route::group(array('middleware' => array(), 'prefix' => 'type-collect-vouchers' ), function () {

    Route::get('/', 'TypeCollectVoucherController@index')
        ->name('type-collect-vouchers.index');

    Route::post('/', 'TypeCollectVoucherController@store')
        ->name('type-collect-vouchers.store');

    Route::get('/{id}', 'TypeCollectVoucherController@edit')
        ->name('type-collect-vouchers.edit')->where('id', '[0-9]+');

    Route::patch('/{id}', 'TypeCollectVoucherController@update')
        ->name('type-collect-vouchers.update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'TypeCollectVoucherController@destroy')
        ->name('type-collect-vouchers.delete')->where('id', '[0-9]+');

});
