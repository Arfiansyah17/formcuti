<?php
use App\Http\Controllers\LeaveController;

Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');


Route::get('/', [LeaveController::class, 'create'])->name('home');
Route::post('/', [LeaveController::class, 'store'])->name('home.store');

// Route untuk Edit dan Delete
Route::get('/leaves/{id}/edit', [LeaveController::class, 'edit'])->name('leaves.edit');
Route::put('/leaves/{id}', [LeaveController::class, 'update'])->name('leaves.update');
Route::delete('/leaves/{id}', [LeaveController::class, 'destroy'])->name('leaves.destroy');
// routes/web.php

Route::get('/leaves/pdf/{id}', [LeaveController::class, 'generatePdf'])->name('leaves.pdf');
// Rute untuk melihat PDF
Route::get('/leaves/{id}/pdf', [LeaveController::class, 'generatePdf'])->name('leaves.pdf');


// routes/web.php

Route::get('/leaves/{id}/edit', [LeaveController::class, 'edit'])->name('leaves.edit');
Route::put('/leaves/{id}', [LeaveController::class, 'update'])->name('leaves.update');
// routes/web.php
Route::get('/leaves/pdf/{id}', [LeaveController::class, 'showPdf'])->name('leaves.pdf');
Route::get('/leaves/{id}/pdf', [LeaveController::class, 'generatePdf'])->name('leaves.pdf');



use App\Http\Controllers\AdminController;

Route::get('admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'login']);
Route::get('admin/dashboard', [AdminController::class, 'showDashboard'])->name('admin.dashboard');
Route::get('/leaves/{id}/pdf', [LeaveController::class, 'generatePdf'])->name('leaves.pdf');
Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.edit');
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');



