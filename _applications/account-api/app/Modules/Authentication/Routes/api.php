<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', 'LoginController@index')->name('login');
Route::prefix('auth')->middleware('auth:api')->group(function(){
    Route::get('/info', 'LoginController@info')->name('login.info');
    Route::get('/role', 'RoleController@index')->name('role');
});
