<?php

Route::resource('user', UserApiController::class);

Route::prefix('update-status')->group(function(){
    Route::patch('/user/{id}', [\App\Modules\User\Controllers\Api\UserApiController::class, 'updateStatus']);
});

