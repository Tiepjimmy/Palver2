<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(), 'prefix' => 'campaigns' ), function () {

    Route::get('/', 'CampaignController@index')
        ->name('campaign.index');

    Route::get('/{id}', 'CampaignController@edit')
        ->name('campaign.edit')->where('id', '[0-9]+');

    Route::post('/', 'CampaignController@store')
        ->name('campaign.store');

    Route::patch('/{id}', 'CampaignController@update')
        ->name('campaign.update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'CampaignController@destroy')
        ->name('campaign.delete')->where('id', '[0-9]+');

    Route::get('list-bundle','CampaignController@listBundle')
        ->name('bundle.list');
});

