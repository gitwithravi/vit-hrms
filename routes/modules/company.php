<?php

use App\Http\Controllers\Company\BranchController;
use App\Http\Controllers\Company\BranchImportController;
use App\Http\Controllers\Company\DepartmentController;
use App\Http\Controllers\Company\DepartmentImportController;
use App\Http\Controllers\Company\DesignationController;
use App\Http\Controllers\Company\DesignationImportController;
use Illuminate\Support\Facades\Route;

// Company Routes
Route::name('company.')->prefix('company')->group(function () {
    Route::get('departments/pre-requisite', [DepartmentController::class, 'preRequisite'])->name('departments.preRequisite');
    Route::post('departments/import', DepartmentImportController::class)->middleware('permission:department:create');
    Route::apiResource('departments', DepartmentController::class);

    Route::get('designations/pre-requisite', [DesignationController::class, 'preRequisite'])->name('designations.preRequisite');
    Route::post('designations/import', DesignationImportController::class)->middleware('permission:designation:create');
    Route::apiResource('designations', DesignationController::class);

    Route::get('branches/pre-requisite', [BranchController::class, 'preRequisite'])->name('branches.preRequisite');
    Route::post('branches/import', BranchImportController::class)->middleware('permission:branch:create');
    Route::apiResource('branches', BranchController::class);
});
