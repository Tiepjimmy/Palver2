<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(),'prefix' => 'channels' ), function () {

    Route::get('/', 'ChannelController@index')
        ->name('channel.index');

    Route::get('/{id}', 'ChannelController@edit')
        ->name('channel.edit')->where('id', '[0-9]+');

    Route::post('/', 'ChannelController@store')
        ->name('channel.store');

    Route::patch('/{id}', 'ChannelController@update')
        ->name('channel.update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'ChannelController@destroy')
        ->name('channel.delete')->where('id', '[0-9]+');

    Route::delete('/', 'ChannelController@destroyMutil')
        ->name('channel.delete_multi');

    Route::get('all-channels','ChannelController@getAll')
        ->name('channel.all');
    Route::get('user-marketing','ChannelController@userPermissionMarketing')
        ->name('listUser');
});



/*Route::group(array('middleware' => array()), function () {
    Route::get('list', 'IndexController@index')
        ->name('channel.index');

    Route::get('edit/{id}', 'IndexController@edit')
        ->name('channel.edit');

    Route::post('store', 'IndexController@store')
        ->name('channel.store');

    Route::put('update', 'IndexController@update')
        ->name('channel.update');

    Route::delete('delete/{id}', 'IndexController@destroy')
        ->name('channel.delete');

});*/
