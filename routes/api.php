<?php

use App\Http\Controllers\Api\ReiController;
use App\Http\Controllers\Api\WatchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('rei')->name('api.rei.')->group(function () {
    Route::get('statuses', [ReiController::class, 'getStatuses'])->name('statuses');
    Route::post('status', [ReiController::class, 'postStatus'])->name('status');
    Route::get('last_record', [ReiController::class, 'getLastMachineRecord'])->name('last_record');
    Route::post('latest_attend', [ReiController::class, 'postLatestAttend'])->name('latest_attend');
    Route::post('latest_resolve', [ReiController::class, 'postLatestResolve'])->name('latest_resolve');
});


Route::prefix('watch')->name('api.watch.')->group(function () {
    Route::post('login', [WatchController::class, 'postLogin'])->name('login');
    Route::get('latest_record/{employee_code}', [WatchController::class, 'getLatestMachineRecord'])->name('latest_record');
    Route::get('record/{id}', [WatchController::class, 'getRecord'])->name('record');
    Route::post('response', [WatchController::class, 'postResponse'])->name('response');
});
