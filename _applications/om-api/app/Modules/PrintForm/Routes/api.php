<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(),'prefix' => 'printed-forms' ), function () {

    Route::get('/', 'PrintFormController@index')
        ->name('printed_forms.index');

    Route::get('/shortcode', 'PrintFormController@shortcode')
        ->name('printed_forms.shortcode');

    Route::get('/system-forms', 'PrintFormController@systemForms')
        ->name('printed_forms.system-forms');

    Route::get('/{id}', 'PrintFormController@show')
        ->name('printed_forms.edit')->where('id', '[0-9]+');

    Route::post('/', 'PrintFormController@store')
        ->name('printed_forms.store');

    Route::patch('/{id}', 'PrintFormController@update')
        ->name('printed_forms.store');
});
