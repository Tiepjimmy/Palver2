<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(), 'prefix' => 'payment-voucher' ), function () {

    Route::get('/', 'PaymentVoucherController@index')
        ->name('payment-voucher.index');

    Route::get('/{id}', 'PaymentVoucherController@show')
        ->name('payments.show')->where('id', '[0-9]+');

    Route::get('/create', 'PaymentVoucherController@create')
        ->name('payment-voucher.create');

    Route::post('/', 'PaymentVoucherController@store')
        ->name('payment-voucher.store');

    Route::patch('/{id}', 'PaymentVoucherController@update')
        ->name('payment-voucher.update')->where('id', '[0-9]+');

    Route::get('/cancel-status/{id}', 'PaymentVoucherController@cancelStatus')
        ->name('payment-voucher.cancel-status');

    Route::get('/get-order', 'PaymentVoucherController@getOrder')
        ->name('payment-voucher.getOrder');
});

