<?php

use Illuminate\Support\Facades\Route;

Route::group(array('middleware' => array(), 'prefix' => 'leads' ), function () {
    Route::get('/', 'LeadController@index')
        ->name('lead.index');

    Route::get('/get-total-lead-by-status', 'LeadController@getTotalLeaByStatus')
        ->name('lead.total_lead_by_status');

    Route::get('/{id}', 'LeadController@show')
        ->name('lead.edit')->where('id', '[0-9]+');

    Route::post('/', 'LeadController@store')
        ->name('lead.store');

    Route::patch('/{id}', 'LeadController@update')
        ->name('lead.update')->where('id', '[0-9]+');

    Route::patch('/update-by-sale/{id}', 'LeadController@updateBySale')
        ->name('lead.update_by_sale')->where('id', '[0-9]+');

    Route::delete('/{id}', 'LeadController@destroy')
        ->name('lead.destroy')->where('id', '[0-9]+');

    Route::post('/reject-data/{id}', 'LeadController@reject')
        ->name('lead.reject')->where('id', '[0-9]+');

    Route::post('/accept-assign/{id}', 'LeadController@accept')
        ->name('lead.accept')->where('id', '[0-9]+');

    Route::post('/cancel-assign/{id}', 'LeadController@cancel')
        ->name('lead.cancel')->where('id', '[0-9]+');

    Route::post('check-duplicate','LeadController@checkDuplicate')->name('lead.checkDuplicate');

    Route::get('/list-status','LeadController@listStatus')->name('lead.listStatus');

    Route::post('/assign-sale-group', 'LeadController@assignSaleGroup')
        ->name('lead.assign_sale_group');

    Route::post('/assign-user', 'LeadController@assignUser')
        ->name('lead.assign_user');

    Route::post('/setting-assign-user', 'LeadController@settingAssignUser')
        ->name('lead.setting_assign_user');

    Route::post('/setting-assign-sale-group', 'LeadController@settingAssignSaleGroup')
        ->name('lead.setting_assign_sale_group');
});
