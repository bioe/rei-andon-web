<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\MachineTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reports\RecordReportController;
use App\Http\Controllers\SegmentController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\StatusRecordController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return redirect('/login');
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth', 'admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('users')->name('users.')->group(function () {
        Route::patch('menu/{id}', [UserController::class, 'patchMenu'])->name('menu.update');
        Route::patch('group/{id}', [UserController::class, 'patchGroup'])->name('group.update');
    });
    Route::resource('users', UserController::class);
    Route::resource('statuses', StatusController::class);
    Route::resource('groups', GroupController::class);
    Route::resource('watches', WatchController::class);
    Route::resource('machinetypes', MachineTypeController::class);
    Route::resource('machines', MachineController::class);
    Route::resource('segments', SegmentController::class);
    Route::resource('statusrecords', StatusRecordController::class);

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::prefix('records')->name('records.')->group(function () {
            Route::get('/', [RecordReportController::class, 'index'])->name('index');
            Route::delete('/destroy/{statusrecord}', [RecordReportController::class, 'destroy'])->name('destroy');
        });
    });
});

require __DIR__ . '/auth.php';
