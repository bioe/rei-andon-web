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
    Route::get('status', [ReiController::class, 'getLatestMachineRecord'])->name('latest');
    Route::post('status', [ReiController::class, 'postStatus'])->name('status');
    Route::post('attend', [ReiController::class, 'postAttend'])->name('attend');
    Route::post('resolve', [ReiController::class, 'postResolve'])->name('resolve');
});


Route::prefix('watch')->name('api.watch.')->group(function () {
    Route::post('login', [WatchController::class, 'postLogin'])->name('login');
    Route::get('latest', [WatchController::class, 'getLatestMachineRecord'])->name('latest');
    Route::get('record/{id}', [WatchController::class, 'getRecord'])->name('record');
    Route::post('response', [WatchController::class, 'postResponse'])->name('response');
});
