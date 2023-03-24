<?php
/**
 * Define route for module
 * @author Electric <huydien.it@gmail.com>
 */

// Route::group(array('middleware' => array()), function () {

// });
Route::resource('/stores', StoresController::class);
