<?php

use App\Http\Controllers\Calendar\HolidayController;
use Illuminate\Support\Facades\Route;

// Calendar Routes
Route::name('calendar.')->prefix('calendar')->group(function () {
    Route::get('holidays/pre-requisite', [HolidayController::class, 'preRequisite'])->name('holidays.preRequisite');
    Route::apiResource('holidays', HolidayController::class);
});
