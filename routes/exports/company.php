<?php

use App\Http\Controllers\Company\BranchExportController;
use App\Http\Controllers\Company\DepartmentExportController;
use App\Http\Controllers\Company\DesignationExportController;
use Illuminate\Support\Facades\Route;

Route::name('company.')->prefix('company')->group(function () {
    Route::get('departments/export', DepartmentExportController::class)->middleware('permission:department:export')->name('departments.export');

    Route::get('designations/export', DesignationExportController::class)->middleware('permission:designation:export')->name('designations.export');

    Route::get('branches/export', BranchExportController::class)->middleware('permission:branch:export')->name('branches.export');
});
