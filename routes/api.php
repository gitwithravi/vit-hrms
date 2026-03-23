<?php

use App\Http\Controllers\Attendance\DeviceTimesheetController;
use App\Http\Controllers\Config\ConfigController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Global Routes
Route::get('config/pre-requisite', [ConfigController::class, 'preRequisite'])->name('config.preRequisite');
Route::get('config', [ConfigController::class, 'index'])->name('config');

Route::post('timesheet', [DeviceTimesheetController::class, 'store'])
    ->name('device.timesheet.store')
    ->middleware('throttle:biometric');

// Fallback route
Route::fallback(function () {
    return response()->json(['message' => trans('general.errors.api_not_found')], 404);
});
