# 🏘️ Desa Cerdas Digital - Implementation Guide

## 📋 Project Overview
**Desa Cerdas Digital** adalah platform digital terintegrasi untuk pelayanan desa modern dengan fitur-fitur:
- 📄 Layanan Surat Online
- 📰 Berita Desa
- 💰 APBDes (Anggaran Pendapatan dan Belanja Desa)
- 💬 Forum Diskusi
- 🛒 Marketplace UMKM
- 🤖 Chatbot AI
- 🗺️ Peta Interaktif

---

## 🏗️ 1. Struktur Folder Project

```
desa-cerdas/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── UserController.php
│   │   │   │   ├── BeritaController.php
│   │   │   │   ├── SuratController.php
│   │   │   │   ├── APBDesController.php
│   │   │   │   ├── UMKMController.php
│   │   │   │   └── ForumController.php
│   │   │   ├── User/
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── SuratController.php
│   │   │   │   ├── ForumController.php
│   │   │   │   ├── UMKMController.php
│   │   │   │   └── ProfileController.php
│   │   │   ├── Api/
│   │   │   │   ├── ChatbotController.php
│   │   │   │   ├── MapController.php
│   │   │   │   └── NotificationController.php
│   │   │   └── Auth/
│   │   ├── Middleware/
│   │   │   ├── AdminMiddleware.php
│   │   │   └── UserMiddleware.php
│   │   └── Requests/
│   │       ├── Admin/
│   │       └── User/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Berita.php
│   │   ├── Surat.php
│   │   ├── JenisSurat.php
│   │   ├── APBDes.php
│   │   ├── Forum.php
│   │   ├── ForumReply.php
│   │   ├── UMKM.php
│   │   ├── ProdukUMKM.php
│   │   ├── Chatbot.php
│   │   └── Notification.php
│   ├── Services/
│   │   ├── OpenAIService.php
│   │   ├── PDFService.php
│   │   ├── NotificationService.php
│   │   └── FileUploadService.php
│   └── Providers/
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── layouts/
│   │   │   ├── dashboard/
│   │   │   ├── users/
│   │   │   ├── berita/
│   │   │   ├── surat/
│   │   │   ├── apbdes/
│   │   │   ├── umkm/
│   │   │   └── forum/
│   │   ├── user/
│   │   │   ├── layouts/
│   │   │   ├── dashboard/
│   │   │   ├── surat/
│   │   │   ├── forum/
│   │   │   ├── umkm/
│   │   │   └── profile/
│   │   ├── auth/
│   │   └── components/
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php
│   ├── admin.php
│   ├── api.php
│   └── auth.php
├── storage/
│   ├── app/
│   │   ├── public/
│   │   │   ├── surat/
│   │   │   ├── berita/
│   │   │   ├── umkm/
│   │   │   └── documents/
│   └── logs/
└── public/
    ├── assets/
    │   ├── images/
    │   ├── css/
    │   └── js/
    └── storage/ (symlink)
```

---

## ⚙️ 2. Environment Template (.env)

```env
# Application
APP_NAME="Desa Cerdas Digital"
APP_ENV=local
APP_KEY=base64:your-app-key-here
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=desa_cerdas
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration (Mailtrap)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@desacerdas.id"
MAIL_FROM_NAME="${APP_NAME}"

# OpenAI Configuration
OPENAI_API_KEY=your-openai-api-key-here
OPENAI_MODEL=gpt-3.5-turbo

# File Storage
FILESYSTEM_DISK=public

# Session & Cache
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

# Broadcasting
BROADCAST_DRIVER=log

# Google Maps (untuk peta interaktif)
GOOGLE_MAPS_API_KEY=your-google-maps-api-key

# Pagination
PAGINATION_PER_PAGE=10

# Upload Limits
MAX_FILE_SIZE=10240  # 10MB in KB
ALLOWED_FILE_TYPES=pdf,doc,docx,jpg,jpeg,png

# Desa Information
DESA_NAME="Desa Contoh"
DESA_ADDRESS="Jl. Contoh No. 123"
DESA_PHONE="021-12345678"
DESA_EMAIL="info@desacontoh.id"
KEPALA_DESA="Bapak/Ibu Kepala Desa"
```

---

## 📦 3. Package Dependencies

### Composer Packages

```bash
# Core Laravel packages (sudah terinstall)
composer require laravel/framework
composer require laravel/breeze

# Additional packages yang perlu diinstall
composer require barryvdh/laravel-dompdf          # PDF generation
composer require maatwebsite/laravel-excel        # Excel import/export
composer require spatie/laravel-permission        # Role & Permission
composer require intervention/image               # Image processing
composer require guzzlehttp/guzzle               # HTTP client untuk OpenAI
composer require laravel/sanctum                 # API authentication
composer require realrashid/sweet-alert          # Sweet Alert
composer require yajra/laravel-datatables-oracle # DataTables
composer require laravel/telescope               # Debugging (dev only)

# Development packages
composer require --dev barryvdh/laravel-debugbar
composer require --dev fakerphp/faker
```

### NPM Packages

```bash
# Core packages (sudah terinstall)
npm install

# Additional packages
npm install --save-dev @tailwindcss/forms
npm install --save-dev @tailwindcss/typography
npm install alpinejs
npm install axios
npm install sweetalert2
npm install chart.js
npm install leaflet                    # Untuk peta interaktif
npm install @fortawesome/fontawesome-free
npm install datatables.net-dt
npm install quill                      # Rich text editor
npm install moment                     # Date manipulation
```

---

## 🚀 4. Perintah Setup & Installation

### Initial Setup
```bash
# 1. Clone atau setup project
git clone <repository-url> desa-cerdas
cd desa-cerdas

# 2. Install dependencies
composer install
npm install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Database setup
php artisan migrate
php artisan db:seed

# 5. Storage link
php artisan storage:link

# 6. Build assets
npm run build

# 7. Start development server
php artisan serve
```

### Development Commands
```bash
# Database
php artisan migrate:fresh --seed
php artisan make:migration create_table_name
php artisan make:seeder TableNameSeeder

# Models & Controllers
php artisan make:model ModelName -mcr
php artisan make:controller Admin/ControllerName
php artisan make:request RequestName

# Permissions
php artisan permission:create-role admin
php artisan permission:create-permission "manage users"

# Cache & Optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Development tools
php artisan telescope:install
php artisan telescope:publish
```

---

## 🛣️ 5. Routes Structure

### Web Routes (routes/web.php)
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;

// Public routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes (handled by Breeze)
require __DIR__.'/auth.php';

// User routes (authenticated)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User specific routes
    Route::prefix('user')->name('user.')->group(function () {
        Route::resource('surat', SuratController::class);
        Route::resource('forum', ForumController::class);
        Route::resource('umkm', UMKMController::class);
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    });
});

// Admin routes
require __DIR__.'/admin.php';
```

### Admin Routes (routes/admin.php)
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Resource routes
    Route::resource('users', UserController::class);
    Route::resource('berita', BeritaController::class);
    Route::resource('surat', SuratController::class);
    Route::resource('apbdes', APBDesController::class);
    Route::resource('umkm', UMKMController::class);
    Route::resource('forum', ForumController::class);
    
    // Custom routes
    Route::get('surat/{id}/download', [SuratController::class, 'download'])->name('surat.download');
    Route::post('surat/{id}/approve', [SuratController::class, 'approve'])->name('surat.approve');
    Route::get('reports', [DashboardController::class, 'reports'])->name('reports');
});
```

### API Routes (routes/api.php)
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ChatbotController;

Route::middleware('auth:sanctum')->group(function () {
    // Chatbot API
    Route::post('/chatbot/message', [ChatbotController::class, 'sendMessage']);
    Route::get('/chatbot/history', [ChatbotController::class, 'getHistory']);
    
    // Map API
    Route::get('/map/locations', [MapController::class, 'getLocations']);
    Route::post('/map/report', [MapController::class, 'reportIssue']);
    
    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
});

// Public API
Route::get('/berita/latest', [BeritaController::class, 'latest']);
Route::get('/umkm/featured', [UMKMController::class, 'featured']);
```

---

## 🔄 6. Application Flow

### Admin Flow
```
1. Login Admin → Admin Dashboard
2. Kelola Data:
   ├── Users (CRUD warga)
   ├── Berita (Create, Edit, Publish)
   ├── Surat (Approve, Generate PDF)
   ├── APBDes (Input, Update anggaran)
   ├── UMKM (Verifikasi, Promosi)
   └── Forum (Moderasi diskusi)
3. Reports & Analytics
4. System Settings
```

### User Flow
```
1. Register/Login → User Dashboard
2. Layanan Tersedia:
   ├── Pengajuan Surat Online
   │   ├── Pilih jenis surat
   │   ├── Isi formulir
   │   ├── Upload dokumen pendukung
   │   └── Track status persetujuan
   ├── Forum Diskusi
   │   ├── Buat topik diskusi
   │   ├── Reply diskusi
   │   └── Like/dislike
   ├── UMKM Marketplace
   │   ├── Daftar sebagai seller
   │   ├── Upload produk
   │   └── Kelola toko
   ├── Chatbot AI
   │   ├── Tanya jawab seputar desa
   │   └── Bantuan navigasi website
   └── Informasi Desa
       ├── Berita terbaru
       ├── APBDes transparency
       └── Peta interaktif
3. Profile Management
4. Notification Center
```

---

## 🗃️ 7. Database Schema Overview

### Core Tables
- `users` - Data warga dan admin
- `roles` & `permissions` - Role-based access control
- `berita` - Artikel berita desa
- `jenis_surat` - Master data jenis surat
- `surat` - Pengajuan surat warga
- `apbdes` - Data anggaran desa
- `forum_topics` & `forum_replies` - Forum diskusi
- `umkm` & `produk_umkm` - Marketplace UMKM
- `chatbot_conversations` - History chat AI
- `notifications` - System notifications

### File Storage Structure
```
storage/app/public/
├── surat/           # Generated PDF surat
├── berita/          # Gambar artikel
├── umkm/           # Foto produk UMKM
├── documents/      # Dokumen pendukung
└── avatars/        # Profile pictures
```

---

## 🎨 8. UI/UX Guidelines

### Design System
- **Framework**: Tailwind CSS
- **Icons**: FontAwesome
- **Charts**: Chart.js
- **Maps**: Leaflet.js
- **Editor**: Quill.js
- **Alerts**: SweetAlert2

### Color Palette
```css
:root {
  --primary: #2563eb;      /* Blue */
  --secondary: #64748b;    /* Slate */
  --success: #059669;      /* Emerald */
  --warning: #d97706;      /* Amber */
  --danger: #dc2626;       /* Red */
  --info: #0891b2;         /* Cyan */
}
```

### Responsive Breakpoints
- Mobile: 320px - 768px
- Tablet: 768px - 1024px
- Desktop: 1024px+

---

## 🔐 9. Security Considerations

### Authentication & Authorization
- Laravel Breeze untuk auth dasar
- Spatie Permission untuk role management
- Middleware untuk proteksi route admin
- CSRF protection pada semua form

### File Upload Security
- Validasi tipe file
- Limit ukuran file
- Scan malware (optional)
- Storage di luar web root

### API Security
- Laravel Sanctum untuk API auth
- Rate limiting
- Input validation & sanitization

---

## 📊 10. Performance Optimization

### Database
- Index pada kolom yang sering di-query
- Eager loading untuk relasi
- Database query optimization
- Pagination untuk data besar

### Caching
- Route caching
- Config caching
- View caching
- Redis untuk session (production)

### Assets
- CSS/JS minification
- Image optimization
- CDN untuk static assets (production)

---

## 🚀 11. Deployment Checklist

### Production Setup
```bash
# Environment
cp .env.example .env.production
php artisan key:generate

# Database
php artisan migrate --force
php artisan db:seed --class=ProductionSeeder

# Optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Storage
php artisan storage:link

# Assets
npm run production
```

### Server Requirements
- PHP 8.2+
- MySQL 8.0+
- Nginx/Apache
- SSL Certificate
- Backup strategy

---

## 📞 12. Support & Maintenance

### Monitoring
- Laravel Telescope (development)
- Error logging
- Performance monitoring
- Backup automation

### Updates
- Regular Laravel updates
- Security patches
- Package updates
- Database migrations

---

**🎯 Next Steps:**
1. Setup development environment
2. Create database migrations
3. Implement authentication system
4. Build admin panel
5. Develop user features
6. API integration
7. Testing & deployment

**📝 Notes:**
- Pastikan semua API keys sudah dikonfigurasi
- Test email dengan Mailtrap sebelum production
- Backup database secara berkala
- Monitor performance dan error logs

---

*Generated for Desa Cerdas Digital Project - Laravel 10 Implementation*
