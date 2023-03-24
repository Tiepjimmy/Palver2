<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(),'prefix' => 'orders' ), function () {
    
    Route::get('/', 'OrderController@index')
        ->name('orders.index');

    Route::get('/{id}', 'OrderController@detail')
        ->name('orders.edit')->where('id', '[0-9]+');

    Route::post('/', 'OrderController@store')
        ->name('orders.store');

    Route::patch('/{id}', 'OrderController@update')
        ->name('orders.update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'OrderController@destroy')
        ->name('orders.delete')->where('id', '[0-9]+');

    Route::delete('/', 'OrderController@destroyMutil')
        ->name('orders.delete_multi');

    Route::get('/province', 'OrderController@getProvince')
        ->name('orders.province');

    Route::get('/district/{province_id}', 'OrderController@getDistrict')
        ->name('orders.district');

    Route::get('/wards/{district}', 'OrderController@getWards')
        ->name('orders.wards');

    Route::get('/list-status-order', 'OrderController@getListStatus')
        ->name('orders.listStatus');

    Route::get('/list-stock', 'OrderController@getListStock')
        ->name('order.listStock');

    Route::get('/product/{id}/', 'OrderController@getListProductStock')
        ->name('orders.product');

    Route::get('/list-product', 'OrderController@getListProduct')
        ->name('orders.list_product');

    Route::get('/{id}', 'OrderController@detail')
        ->name('orders.detail')->where('id', '[0-9]+');

    Route::get('/list-addess', 'OrderController@listAddress')
        ->name('order.listAddress');

    Route::patch('/{id}/approve', 'OrderController@approve')
        ->name('order.approve');

    Route::patch('/approve', 'OrderController@bulkApprove')
        ->name('order.bulkApprove');

    Route::patch('/{id}/un-approve', 'OrderController@unApprove')
        ->name('order.un_approve');

    Route::post('/{id}/checkout', 'OrderController@checkout')
        ->name('order.checkout');

    Route::get('/{id}/checkouts', 'OrderController@listCheckout')
        ->name('order.checkouts');

    Route::post('/{id}/payment-confirm', 'OrderController@paymentConfirm')
        ->name('order.paymentConfirm');

    Route::post('/payment-confirm', 'OrderController@bulkPaymentConfirm')
        ->name('order.paymentConfirm');

    Route::delete('/{id}/payment-confirm', 'OrderController@cancelPaymentConfirm')
        ->name('order.paymentConfirm');

    Route::delete('/payment-confirm', 'OrderController@bulkCancelPaymentConfirm')
        ->name('order.bulk-paymentConfirm');

    Route::get('/{id}/payment-history', 'OrderController@paymentHistory')
        ->name('order.payment-history');

    Route::get('/payment-history', 'OrderController@bulkPaymentHistory')
        ->name('order.bulk-payment-history');

    Route::get('/{id}/status-logs', 'OrderController@statusLogs')
        ->name('order.status-logs');

    Route::patch('/shipping', 'OrderController@shipping')
        ->name('orders.shipping');
});

Route::group(array('middleware' => array(), 'prefix' => 'order-cancel-reasons'), function () {

    Route::get('/', 'OrderCancelReasonController@index')
        ->name('order-cancel-reasons.index');

    Route::post('/', 'OrderCancelReasonController@store')
        ->name('order-cancel-reasons.store');

    Route::get('/{id}', 'OrderCancelReasonController@edit')
        ->name('order-cancel-reasons.edit')->where('id', '[0-9]+');

    Route::patch('/{id}', 'OrderCancelReasonController@update')
        ->name('order-cancel-reasons.update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'OrderCancelReasonController@destroy')
        ->name('order-cancel-reasons.delete')->where('id', '[0-9]+');
});

Route::group(['prefix' => 'order-status', 'as' => 'statuses.'], function () {
    Route::get('/', 'StatusController@list')->name('list');
    Route::get('/{id}', 'StatusController@show')->name('show');
    Route::post('/', 'StatusController@store')->name('store');
    Route::patch('/{id}', 'StatusController@update')->name('update');
    Route::delete('/{id}', 'StatusController@destroy')->name('destroy');
});

Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('get-by-store', 'OrderProductController@getByStore')->name('get-by-store');
    });

    Route::get('/{id}/sub-statuses', 'OrderController@subStatuses')
        ->name('order.sub_statuses')
        ->where('id', '[0-9]+');

    Route::patch('/{id}/cancel', 'OrderController@cancel')
        ->name('order.cancel')
        ->where('id', '[0-9]+');

    Route::patch('/{id}/shipping-success', 'OrderController@shippingSuccess')
        ->name('order.success')
        ->where('id', '[0-9]+');

    Route::patch('/{id}/refund', 'OrderController@refund')
        ->name('order.refund')
        ->where('id', '[0-9]+');
});
