<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

// Pas de page vitrine — redirect vers login
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Documents
    Route::resource('documents', DocumentController::class)->except(['edit', 'update']);

    // Templates
    Route::resource('templates', TemplateController::class)->except(['show']);
    Route::get('/templates/{template}/variables', [TemplateController::class, 'variables'])->name('templates.variables');

    // PDF / Word / Excel download
    Route::get('/documents/{document}/download/{format?}', [PdfController::class, 'download'])
        ->name('documents.download')
        ->where('format', 'pdf|word|excel');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
