<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(), 'prefix' => 'mission-scripts' ), function () {

    Route::get('/', 'MissionScriptController@index')
        ->name('missionScript.index');

    Route::get('/{id}', 'MissionScriptController@edit')
        ->name('missionScript.edit')->where('id', '[0-9]+');

    Route::get('/get-one-script', 'MissionScriptController@getOneScript')
        ->name('missionScript.get_one_script')->where('id', '[0-9]+');

    Route::post('/', 'MissionScriptController@store')
        ->name('missionScript.store');

    Route::patch('/{id}', 'MissionScriptController@update')
        ->name('missionScript.update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'MissionScriptController@destroy')
        ->name('missionScript.delete')->where('id', '[0-9]+');

});