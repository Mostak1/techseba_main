<?php

use Illuminate\Support\Facades\Route;
use Modules\Jobs\Http\Controllers\JobController;
use Modules\Jobs\Http\Controllers\CategoryController;
use Modules\Jobs\Http\Controllers\OrganizationController;

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

// Public Frontend Routes
Route::group(['middleware' => ['HtmlSpecialchars', 'MaintenanceMode']], function () {
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{slug}', [JobController::class, 'show'])->name('jobs.show');
    Route::get('/jobs/category/{slug}', [CategoryController::class, 'show'])->name('jobs.category');
    Route::get('/jobs/organization/{slug}', [OrganizationController::class, 'show'])->name('jobs.organization');
});

// Authenticated User Bookmark Routes
Route::group(['as' => 'user.jobs.', 'prefix' => 'user/jobs', 'middleware' => ['HtmlSpecialchars', 'MaintenanceMode', 'auth:web']], function () {
    Route::get('/bookmarks', [Modules\Jobs\Http\Controllers\BookmarkController::class, 'index'])->name('bookmarks');
    Route::post('/bookmarks', [Modules\Jobs\Http\Controllers\BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{id}', [Modules\Jobs\Http\Controllers\BookmarkController::class, 'destroy'])->name('bookmarks.destroy');
});

// Admin Dashboard Routes
Route::group(['as'=> 'admin.', 'prefix' => 'admin/jobs-management', 'middleware' => ['HtmlSpecialchars', 'MaintenanceMode', 'auth:admin']], function () {
    Route::resource('organizations', Modules\Jobs\Http\Controllers\Admin\OrganizationController::class);
    Route::resource('categories', Modules\Jobs\Http\Controllers\Admin\CategoryController::class);
    Route::resource('jobs', Modules\Jobs\Http\Controllers\Admin\JobController::class);
    Route::resource('attachments', Modules\Jobs\Http\Controllers\Admin\AttachmentController::class);
});
