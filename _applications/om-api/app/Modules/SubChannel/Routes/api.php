<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(),'prefix' => 'sub-channels' ), function () {

    Route::get('/', 'SubChannelsController@index')
        ->name('subChannel.index');

    Route::get('/{id}', 'SubChannelsController@edit')
        ->name('subChannel.edit')->where('id', '[0-9]+');

    Route::post('/', 'SubChannelsController@store')
        ->name('subChannel.store');

    Route::patch('/{id}', 'SubChannelsController@update')
        ->name('subChannel.update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'SubChannelsController@destroy')
        ->name('subChannel.delete')->where('id', '[0-9]+');

    Route::delete('/', 'SubChannelsController@destroyMutil')
        ->name('subChannel.delete_multi');

    Route::get('all-sub-channels','SubChannelsController@allSubChannels')
        ->name('subChannelAll');
    Route::get('check-unique','SubChannelsController@checkUnique');
});
