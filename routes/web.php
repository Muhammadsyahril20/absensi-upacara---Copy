<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\AttendanceController;

// Tambahkan baris ini di paling atas file routes/web.php
Route::get('/', function () {
    return redirect()->route('admin.events');
});
// Rute Admin Dashboard
Route::get('/admin/events', [EventController::class, 'index'])->name('admin.events');
Route::post('/admin/events', [EventController::class, 'store'])->name('admin.store');
Route::post('/admin/events/{id}/toggle', [EventController::class, 'toggleStatus'])->name('admin.toggle');
Route::post('/admin/instansi', [App\Http\Controllers\EventController::class, 'storeInstansi'])->name('instansi.store');
// Rute untuk melihat halaman rekap
Route::get('/admin/events/{id}/rekap', [App\Http\Controllers\EventController::class, 'showRekap'])->name('admin.rekap');
Route::get('/admin/events/{id}/export-excel', [App\Http\Controllers\EventController::class, 'exportExcel'])->name('admin.export.excel');
Route::delete('/admin/instansi/{id}', [App\Http\Controllers\EventController::class, 'destroyInstansi'])->name('instansi.destroy');
// Rute untuk update instansi
Route::put('/admin/instansi/{id}', [App\Http\Controllers\EventController::class, 'updateInstansi'])->name('instansi.update');
Route::delete('/admin/events/{id}', [App\Http\Controllers\EventController::class, 'destroyEvent'])->name('admin.destroy.event');

// Rute Form Absensi Peserta
Route::get('/absen/{id}', [AttendanceController::class, 'showForm'])->name('absen.form');
Route::post('/absen/{id}', [AttendanceController::class, 'store'])->name('absen.store');
