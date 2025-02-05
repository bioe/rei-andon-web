<?php

use App\Http\Controllers\Api\CabinetController;
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
    Route::post('logout', [WatchController::class, 'postLogout'])->name('logout');

    Route::get('record/{id}', [WatchController::class, 'getRecord'])->name('record');
    Route::post('response', [WatchController::class, 'postResponse'])->name('response');
    Route::post('complete', [WatchController::class, 'postComplete'])->name('complete');
    Route::post('help', [WatchController::class, 'postHelp'])->name('help');



    //Polling
    Route::prefix('poll')->name('poll.')->group(function () {
        Route::get('latest_record/{employee_code}', [WatchController::class, 'getPollLatestMachineRecord'])->name('latest_record');
        Route::get('login/{watch_code}', [WatchController::class, 'getPollLogin'])->name('response');
    });

    Route::get('time', [WatchController::class, 'getTime'])->name('time');
    Route::get('test', [WatchController::class, 'getTest'])->name('test');
});


//Smart Charging Cabinet
Route::prefix('cabinet')->name('api.cabinet.')->group(function () {
    Route::get('staff', [CabinetController::class, 'getStaff'])->name('staffs');
    Route::post('operation', [CabinetController::class, 'postOperation'])->name('operation');
});
