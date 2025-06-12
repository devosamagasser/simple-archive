<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ProfileController;



Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('folders', FolderController::class)->except(['index', 'edit', 'create']);
    Route::resource('files', FileController::class)->except(['index', 'edit', 'create']);
    
    Route::get('/files/{id}/download', [FileController::class, 'download'])->name('files.download');
    Route::post('/files/share', [FileController::class, 'share'])->name('files.share');
    Route::post('/files/remove_access', [FileController::class, 'removeAccess'])->name('files.remove_access');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        return 'Storage link created successfully!';
    });
});