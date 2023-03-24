<?php

Route::resource('attribute-group', AttributeGroupApiController::class);

Route::resource('attribute', AttributeApiController::class);

Route::prefix('update-status')->group(function(){
    Route::patch('/attribute-group/{id}', [\App\Modules\Product\Controllers\Api\AttributeGroupApiController::class, 'updateStatus']);
    Route::patch('/attribute/{id}', [\App\Modules\Product\Controllers\Api\AttributeApiController::class, 'updateStatus']);
});

Route::resource('san-pham', ProductController::class);

Route::prefix('import')->group(function(){
    Route::post('/product-single', [\App\Modules\Product\Controllers\Api\ProductController::class, 'importSingle']);
    Route::post('/product-combo', [\App\Modules\Product\Controllers\Api\ProductController::class, 'importCombo']);
});

Route::get('search-entity', [\App\Modules\Product\Controllers\Api\ProductController::class, 'searchEntity']);
Route::get('search-product', [\App\Modules\Product\Controllers\Api\ProductController::class, 'searchProduct']);
Route::get('owner-shop', [\App\Modules\Product\Controllers\Api\ProductController::class, 'ownerShop']);
