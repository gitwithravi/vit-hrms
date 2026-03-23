<?php

use App\Http\Controllers\Employee\EmployeeCategoryController;
use Illuminate\Support\Facades\Route;

Route::middleware('permission:employee-category:read')->group(function () {
    Route::get('employee-category/pre-requisite', [EmployeeCategoryController::class, 'preRequisite'])->name('employee-category.preRequisite');
    Route::post('employee-category/{employee}', [EmployeeCategoryController::class, 'update'])->name('employee-category.update');
    Route::get('employee-category', [EmployeeCategoryController::class, 'index'])->name('employee-category.index');
});
