<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\DTO\ProxyResult;

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
//Proxy
Route::prefix('/proxy')->middleware('auth')->group(function(){
    /**
     * Router :
     * + Phân hệ account   : /proxy/account/user
     * + Phân hệ om        : /proxy/ordermanager/order
     * + Phân hệ inventory : /proxy/inventory/stocks
     */
    $uri = '{uri}';
    Route::get($uri, [\App\Http\Controllers\ProxyController::class, 'get'])->where('uri', '.*')->name('ProxyController@Get');
    Route::post($uri, [\App\Http\Controllers\ProxyController::class, 'post'])->where('uri', '.*')->name('ProxyController@Post');
    Route::patch($uri, [\App\Http\Controllers\ProxyController::class, 'patch'])->where('uri', '.*')->name('ProxyController@Patch');
    Route::delete($uri, [\App\Http\Controllers\ProxyController::class, 'delete'])->where('uri', '.*')->name('ProxyController@Delete');
});

Route::prefix('/download')->middleware('auth')->group(function(){
    Route::get('/template-single', [\App\Http\Controllers\ProductController::class, 'exportTemplateSingle']);
    Route::get('/template-combo', [\App\Http\Controllers\ProductController::class, 'exportTemplateCombo']);
    Route::get('/template-single-branch', [\App\Http\Controllers\ProductController::class, 'exportTemplateSingleBranch']);
    Route::get('/template-combo-branch', [\App\Http\Controllers\ProductController::class, 'exportTemplateComboBranch']);
});
Route::post('/import-product', [\App\Http\Controllers\ProductController::class, 'import'])->middleware('auth')->name('import-product');
Route::get('/export-product', [\App\Http\Controllers\ProductController::class, 'export'])->middleware('auth')->name('export-product');

//Auth
Route::prefix('/auth')->group(function(){
    Route::get('/user/profile', [\App\Http\Controllers\AuthController::class, 'info']);
});

//For GUEST
Route::get('/redirect-login',function(){
    return redirect(config('sso.login_url'));
})->middleware('guest')->name('login');

//For Other link
Route::fallback(function(){
    if(\Illuminate\Support\Facades\Auth::guest()){
        return redirect(config('sso.login_url'));
    }else{
        return view('app');
    }
});

