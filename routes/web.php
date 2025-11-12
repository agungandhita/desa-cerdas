<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PermohonanSuratController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\ChatRoomController;
use App\Http\Controllers\Admin\ProdukUmkmController;
use App\Http\Controllers\Admin\LokasiDesaController;
use App\Http\Controllers\Admin\ApbdesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BeritaController as FrontendBeritaController;
use App\Http\Controllers\Frontend\ProdukUmkmController as FrontendProdukUmkmController;
use App\Http\Controllers\Frontend\LayananController;
use App\Http\Controllers\Frontend\ApbdesController as FrontendApbdesController;
use App\Http\Controllers\Frontend\ForumController;
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

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/beranda', [HomeController::class, 'index'])->name('beranda');
Route::get('/tentang', [HomeController::class, 'about'])->name('tentang');
Route::get('/kontak', [HomeController::class, 'contact'])->name('kontak');

// Frontend Berita Routes
Route::prefix('berita')->name('berita.')->group(function () {
    Route::get('/', [FrontendBeritaController::class, 'index'])->name('index');
    Route::get('/kategori/{category?}', [FrontendBeritaController::class, 'category'])->name('category');
    Route::get('/{slug}', [FrontendBeritaController::class, 'show'])->name('show');
});

// Frontend UMKM Routes
Route::prefix('umkm')->name('umkm.')->group(function () {
    Route::get('/', [FrontendProdukUmkmController::class, 'index'])->name('index');
    Route::get('/kategori/{kategori}', [FrontendProdukUmkmController::class, 'category'])->name('category');
    Route::get('/penjual/{userId}', [FrontendProdukUmkmController::class, 'seller'])->name('seller');
    Route::get('/{slug}', [FrontendProdukUmkmController::class, 'show'])->name('show');
});

// Frontend Layanan Publik Routes
Route::prefix('layanan')->name('layanan.')->group(function () {
    Route::get('/', [LayananController::class, 'index'])->name('index');
    Route::get('/info/{jenis}', [LayananController::class, 'info'])
        ->where('jenis', 'surat_keterangan_domisili|surat_keterangan_usaha|surat_keterangan_tidak_mampu|surat_pengantar_nikah|surat_keterangan_kelahiran|surat_keterangan_kematian')
        ->name('info');
    Route::get('/ajukan/{jenis?}', [LayananController::class, 'create'])->middleware(['auth', 'verified', 'role:warga'])->name('create');
    Route::post('/ajukan', [LayananController::class, 'store'])->middleware(['auth', 'verified', 'role:warga'])->name('store');
    Route::get('/riwayat', [LayananController::class, 'riwayat'])->middleware(['auth', 'verified', 'role:warga'])->name('riwayat');
    Route::get('/detail/{id}', [LayananController::class, 'show'])->middleware(['auth', 'verified', 'role:warga'])->name('show');
});

// Frontend APBDes Routes
Route::prefix('apbdes')->name('apbdes.')->group(function () {
    Route::get('/', [FrontendApbdesController::class, 'index'])->name('index');
    Route::get('/bidang/{bidang}', [FrontendApbdesController::class, 'sector'])->name('sector');
    Route::get('/perbandingan', [FrontendApbdesController::class, 'comparison'])->name('comparison');
    Route::get('/ringkasan', [FrontendApbdesController::class, 'summary'])->name('summary');
});

// Frontend Forum Routes
Route::prefix('forum')->name('forum.')->group(function () {
    Route::get('/', [ForumController::class, 'index'])->name('index');
    Route::get('/buat', [ForumController::class, 'create'])->name('create');
    Route::post('/buat', [ForumController::class, 'store'])->name('store');
    Route::get('/kategori/{kategori}', [ForumController::class, 'category'])->name('category');
    Route::get('/diskusi-saya', [ForumController::class, 'myDiscussions'])->name('my-discussions');
    Route::get('/{id}', [ForumController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ForumController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ForumController::class, 'update'])->name('update');
    Route::delete('/{id}', [ForumController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/komentar', [ForumController::class, 'storeComment'])->name('comment.store');
});

// Admin Dashboard Route - redirect to admin dashboard
Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'isAdmin'])
    ->name('admin.dashboard');

// Default dashboard route - redirect based on role
Route::get('/dashboard', function () {
    if (!auth()->check()) {
        return redirect()->route('home');
    }

    $user = auth()->user();
    if ($user->can('manage-surat')) {
        return redirect()->route('admin.dashboard');
    }

    // Warga atau role lain diarahkan ke layanan publik
    return redirect()->route('layanan.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes - protected by isAdmin
Route::middleware(['auth', 'verified', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    // Users Management Routes
    Route::resource('users', UserController::class);

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
