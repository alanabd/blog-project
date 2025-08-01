<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController; // CategoryController'ı ekleyin



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Kategori Yönetimi Rotası (Admin için)
    // 'can:isAdmin' middleware'i ile yetkilendirme kontrolü yapılır.
    // Alternatif olarak controller constructor'da da yapılabilir.
    Route::resource('categories', CategoryController::class)
        ->middleware('can:isAdmin'); // Sadece admin rolüne sahip kullanıcılar erişebilir.
});

require __DIR__.'/auth.php';