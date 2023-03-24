<?php

//Route::get('/districts', [\App\Modules\Districts\Controllers\Api\IndexController::class,'index']);

Route::resource('/districts', DistrictsController::class);