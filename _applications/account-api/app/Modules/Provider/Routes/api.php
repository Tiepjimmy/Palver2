<?php

Route::resource('provider', ProviderApiController::class);
Route::resource('provider-group', ProviderGroupApiController::class);

Route::prefix('update-status')->group(function(){
    Route::patch('/provider/{id}', [\App\Modules\Provider\Controllers\Api\ProviderApiController::class, 'updateStatus']);
});
