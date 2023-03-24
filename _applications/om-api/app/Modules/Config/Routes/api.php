<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => [], 'prefix' => 'config'], function () {
    Route::get('/{any}', 'ConfigController')->name('config.get');
});
