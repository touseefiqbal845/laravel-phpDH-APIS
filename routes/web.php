<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DoctorController;
use App\Models\Doctor;





Route::get('doctors', [DoctorController::class, 'index'])->name('doctors.index');

// Route::get('doctors', function () {
//     return view('doctors.index');
// })->name('doctors.index');


// Route::get('doctors/{id}', [DoctorController::class, 'show']);


Route::get('doctors/{id}', [DoctorController::class, 'show'])->name('doctors.show');

// Route::get('doctors/{id}', [DoctorController::class, 'show'])->name('doctors.show');
// Route::get('doctors/{id}', [DoctorController::class, 'update'])->name('doctors.edit');
// Route::get('doctors/{id}', [DoctorController::class, 'show']);
// Route::post('doctorss', [DoctorController::class, 'create']);
// Route::delete('doctors/{id}', [DoctorController::class, 'destroy']);

    