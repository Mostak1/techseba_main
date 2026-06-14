<?php

use Illuminate\Support\Facades\Route;
use Modules\Scraper\App\Http\Controllers\Admin\SourceController;
use Modules\Scraper\App\Http\Controllers\Admin\StagingJobController;
use Modules\Scraper\App\Http\Controllers\Admin\LogController;

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

// Admin Dashboard Routes for Government Job Scraper
Route::group(['as'=> 'admin.scraper.', 'prefix' => 'admin/scraper', 'middleware' => ['HtmlSpecialchars', 'MaintenanceMode', 'auth:admin']], function () {
    
    // Scraper Sources CRUD
    Route::resource('sources', SourceController::class);
    Route::post('sources/{id}/run', [SourceController::class, 'run'])->name('sources.run');

    // Scraper Staging Jobs & Approval Workflow
    Route::get('staging', [StagingJobController::class, 'index'])->name('staging.index');
    Route::get('staging/{id}', [StagingJobController::class, 'show'])->name('staging.show');
    Route::get('staging/{id}/edit', [StagingJobController::class, 'edit'])->name('staging.edit');
    Route::put('staging/{id}', [StagingJobController::class, 'update'])->name('staging.update');
    Route::post('staging/{id}/approve', [StagingJobController::class, 'approve'])->name('staging.approve');
    Route::post('staging/{id}/reject', [StagingJobController::class, 'reject'])->name('staging.reject');

    // Scraper Execution Logs
    Route::get('logs', [LogController::class, 'index'])->name('logs.index');
});
