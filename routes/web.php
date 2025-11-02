<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermohonanSuratController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\ChatRoomController;
use App\Http\Controllers\Admin\ProdukUmkmController;
use App\Http\Controllers\Admin\LokasiDesaController;
use App\Http\Controllers\Admin\ApbdesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Default dashboard route - redirect to admin dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Dashboard Route
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');

// Admin Permohonan Surat Routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('permohonan-surat', PermohonanSuratController::class);
    Route::patch('permohonan-surat/{permohonanSurat}/status', [PermohonanSuratController::class, 'updateStatus'])
        ->name('permohonan-surat.update-status');
    Route::get('permohonan-surat/{permohonanSurat}/download', [PermohonanSuratController::class, 'downloadPdf'])
        ->name('permohonan-surat.download');
    Route::get('permohonan-surat/export/excel', [PermohonanSuratController::class, 'export'])
        ->name('permohonan-surat.export');
    
    // Berita Routes
    Route::resource('berita', BeritaController::class)->parameters([
        'berita' => 'berita'
    ])->names([
        'index' => 'berita.index',
        'create' => 'berita.create',
        'store' => 'berita.store',
        'show' => 'berita.show',
        'edit' => 'berita.edit',
        'update' => 'berita.update',
        'destroy' => 'berita.destroy'
    ]);
    Route::patch('berita/{berita}/status', [BeritaController::class, 'updateStatus'])
        ->name('berita.updateStatus');
    Route::patch('berita/{berita}/featured', [BeritaController::class, 'toggleFeatured'])
        ->name('berita.toggleFeatured');
    
    // Froala Editor Upload Routes
    Route::post('berita/upload-image', [BeritaController::class, 'uploadImage'])
        ->name('berita.upload-image');
    Route::post('berita/upload-file', [BeritaController::class, 'uploadFile'])
        ->name('berita.upload-file');
    
    // Chat Room Routes
    Route::resource('chat-room', ChatRoomController::class)->parameters([
        'chat-room' => 'chatRoom'
    ])->names([
        'index' => 'chat-room.index',
        'create' => 'chat-room.create',
        'store' => 'chat-room.store',
        'show' => 'chat-room.show',
        'edit' => 'chat-room.edit',
        'update' => 'chat-room.update',
        'destroy' => 'chat-room.destroy'
    ]);
    Route::patch('chat-room/{chatRoom}/status', [ChatRoomController::class, 'updateStatus'])
        ->name('chat-room.updateStatus');
    Route::post('chat-room/{chatRoom}/messages', [ChatRoomController::class, 'sendMessage'])
        ->name('chat-room.sendMessage');
    Route::get('chat-room/{chatRoom}/messages', [ChatRoomController::class, 'getMessages'])
        ->name('chat-room.getMessages');
    Route::put('chat-room/messages/{message}', [ChatRoomController::class, 'updateMessage'])
        ->name('chat-room.updateMessage');
    Route::delete('chat-room/messages/{message}', [ChatRoomController::class, 'deleteMessage'])
        ->name('chat-room.deleteMessage');
    Route::post('chat-room/{chatRoom}/upload', [ChatRoomController::class, 'uploadFile'])
        ->name('chat-room.uploadFile');
    
    // Produk UMKM Routes
    Route::resource('produk-umkm', ProdukUmkmController::class)->parameters([
        'produk-umkm' => 'produkUmkm'
    ])->names([
        'index' => 'produk-umkm.index',
        'create' => 'produk-umkm.create',
        'store' => 'produk-umkm.store',
        'show' => 'produk-umkm.show',
        'edit' => 'produk-umkm.edit',
        'update' => 'produk-umkm.update',
        'destroy' => 'produk-umkm.destroy'
    ]);
    Route::patch('produk-umkm/{produkUmkm}/status', [ProdukUmkmController::class, 'updateStatus'])
        ->name('produk-umkm.updateStatus');
    Route::patch('produk-umkm/{produkUmkm}/featured', [ProdukUmkmController::class, 'toggleFeatured'])
        ->name('produk-umkm.toggleFeatured');
    
    // Froala Editor Upload Routes for Produk UMKM
    Route::post('produk-umkm/upload-image', [ProdukUmkmController::class, 'uploadImage'])
        ->name('produk-umkm.upload-image');
    Route::post('produk-umkm/upload-file', [ProdukUmkmController::class, 'uploadFile'])
        ->name('produk-umkm.upload-file');
    
    // Lokasi Desa Routes
    Route::resource('lokasi-desa', LokasiDesaController::class)->parameters([
        'lokasi-desa' => 'lokasiDesa'
    ])->names([
        'index' => 'lokasi-desa.index',
        'create' => 'lokasi-desa.create',
        'store' => 'lokasi-desa.store',
        'show' => 'lokasi-desa.show',
        'edit' => 'lokasi-desa.edit',
        'update' => 'lokasi-desa.update',
        'destroy' => 'lokasi-desa.destroy'
    ]);
    Route::patch('lokasi-desa/{lokasiDesa}/status', [LokasiDesaController::class, 'updateStatus'])
        ->name('lokasi-desa.updateStatus');
    Route::delete('lokasi-desa/{lokasiDesa}/delete-photo', [LokasiDesaController::class, 'deletePhoto'])
        ->name('lokasi-desa.delete-photo');
    
    // APB Desa Routes
    Route::resource('apbdes', ApbdesController::class)->parameters([
        'apbdes' => 'apbdes'
    ])->names([
        'index' => 'apbdes.index',
        'create' => 'apbdes.create',
        'store' => 'apbdes.store',
        'show' => 'apbdes.show',
        'edit' => 'apbdes.edit',
        'update' => 'apbdes.update',
        'destroy' => 'apbdes.destroy'
    ]);
    Route::get('apbdes/export/excel', [ApbdesController::class, 'export'])
        ->name('apbdes.export');
    Route::get('apbdes/statistics', [ApbdesController::class, 'getStatistics'])
        ->name('apbdes.statistics');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
