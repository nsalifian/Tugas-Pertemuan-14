<?php
 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
 
// Public routes (tanpa auth)
Route::get('/', function () {
    return redirect()->route('login');
});
 
// Protected routes (dengan auth middleware)
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
 
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Buku - Custom routes (harus sebelum resource)
    Route::get('/buku/export', [BukuController::class, 'export'])->name('buku.export');
    Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
    Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])->name('buku.kategori');
    Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])->name('buku.bulk-delete');

    Route::get('/anggota/export', [AnggotaController::class, 'export'])->name('anggota.export');
    Route::get('/anggota/search', [AnggotaController::class, 'search'])->name('anggota.search');
    Route::get('/anggota/filter', [AnggotaController::class, 'filter'])->name('anggota.filter');
    Route::post('/anggota/bulk-delete', [AnggotaController::class, 'bulkDelete'])->name('anggota.bulk-delete');

    // Buku - CRUD
    Route::resource('buku', BukuController::class);
 
    // Anggota - CRUD
    Route::resource('anggota', AnggotaController::class);

    // Laporan Transaksi
    Route::get('/transaksi/laporan', [TransaksiController::class, 'laporan'])->name('transaksi.laporan');
    
    // Transaksi - CRUD + Custom routes
    Route::resource('transaksi', TransaksiController::class);
    Route::put('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');
});
 
require __DIR__.'/auth.php';