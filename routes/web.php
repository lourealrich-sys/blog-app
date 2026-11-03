<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\PostReportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/posts/reports', [PostReportController::class, 'index'])->name('posts.reports.index');
    Route::get('/posts/reports/pdf', [PostReportController::class, 'exportPdf'])->name('posts.reports.pdf');
    Route::get('/posts/reports/csv', [PostReportController::class, 'exportCsv'])->name('posts.reports.csv');

    Route::resource('posts', PostController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
