<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(), 'prefix' => 'mission-results' ), function () {

    Route::get('/', 'MissionResultController@index')
        ->name('missionResult.index');

    Route::get('/{id}', 'MissionResultController@edit')
        ->name('missionResult.edit')->where('id', '[0-9]+');

    Route::post('/', 'MissionResultController@store')
        ->name('missionResult.store');

    Route::patch('/{id}', 'MissionResultController@update')
        ->name('missionResult.update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'MissionResultController@destroy')
        ->name('missionResult.delete')->where('id', '[0-9]+');

    Route::get('all-result','MissionResultController@allResult')
        ->name('missionResult.allResult');
});