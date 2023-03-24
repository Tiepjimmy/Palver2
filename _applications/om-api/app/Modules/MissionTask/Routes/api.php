<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(), 'prefix' => 'mission-tasks' ), function () {

    Route::get('/', 'MissionTaskController@index')
        ->name('missionTask.index');

    Route::get('/{id}', 'MissionTaskController@edit')
        ->name('missionTask.edit')->where('id', '[0-9]+');

    Route::post('/', 'MissionTaskController@store')
        ->name('missionTask.store');

    Route::patch('/{id}', 'MissionTaskController@update')
        ->name('missionTask.update')->where('id', '[0-9]+');

    Route::delete('/{id}', 'MissionTaskController@destroy')
        ->name('missionTask.delete')->where('id', '[0-9]+');

    Route::get('all-task','MissionTaskController@allTask')
        ->name('missionTask.all');
});
