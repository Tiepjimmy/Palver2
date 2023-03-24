<?php
use Illuminate\Support\Facades\Route;

Route::prefix('/async-account')->group(function () {
    Route::post('/', 'UserController@store')->name('user.store');
    Route::post('/update', 'UserController@update')->name('user.update');
});

