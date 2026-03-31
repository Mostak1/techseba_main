<?php

use Modules\Category\Http\Controllers\CategoryController;
use Modules\Category\Http\Controllers\SubCategoryController;


Route::group(['as'=> 'admin.', 'prefix' => 'admin', 'middleware' => ['HtmlSpecialchars', 'MaintenanceMode','auth:admin']],function (){

    Route::resource('category', CategoryController::class);
    Route::resource('sub-category', SubCategoryController::class);

});
