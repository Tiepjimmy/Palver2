<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Comment out because logout not avaiable
Route::middleware('guest')->group(function(){
    Route::prefix('/dang-nhap')->group(function(){
        Route::get('', 'LoginController@index')->name('login');
        Route::post('', 'LoginController@login')->name('login.post');
    });
});
Route::middleware('auth')->group(function(){
    Route::fallback('LoginController@redirectAfterLogin');
});

Route::get('/checklogin',function(){
    return \Illuminate\Support\Facades\Auth::user();
})->middleware('auth');

