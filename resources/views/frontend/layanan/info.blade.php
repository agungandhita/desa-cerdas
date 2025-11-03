@extends('frontend.layouts.main')

@section('breadcrumb')
<div class="bg-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-4">
                <li>
                    <div>
                        <a href="{{ route('beranda') }}" class="text-gray-400 hover:text-gray-500">
                            <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            <span class="sr-only">Beranda</span>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('layanan.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Layanan Publik</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-4 text-sm font-medium text-gray-500">{{ $info['nama'] }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-gray-900">{{ $info['nama'] }}</h1>
            <p class="mt-2 text-gray-600">Informasi lengkap tentang layanan {{ strtolower($info['nama']) }}</p>
        </div>
    </div>
</div>
@endsection

@section('container')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Service Description -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Deskripsi Layanan</h2>
                <p class="text-gray-700 leading-relaxed">{{ $info['deskripsi'] }}</p>
            </div>

            <!-- Requirements -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Persyaratan</h2>
                <div class="space-y-3">
                    @foreach($info['persyaratan'] as $index => $syarat)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mr-3 mt-0.5">
                            <span class="text-xs font-medium text-blue-600">{{ $index + 1 }}</span>
                        </div>
                        <p class="text-gray-700">{{ $syarat }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Process Flow -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Alur Proses</h2>
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-sm font-medium text-white">1</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Persiapan Dokumen</h3>
                            <p class="text-sm text-gray-600">Siapkan semua dokumen persyaratan yang diperlukan</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-sm font-medium text-white">2</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Pengajuan Online</h3>
                            <p class="text-sm text-gray-600">Isi formulir permohonan dan upload dokumen pendukung</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-sm font-medium text-white">3</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Verifikasi</h3>
                            <p class="text-sm text-gray-600">Petugas desa akan memverifikasi dokumen dan data Anda</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-sm font-medium text-white">4</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Proses Pembuatan</h3>
                            <p class="text-sm text-gray-600">Surat akan diproses dan ditandatangani oleh pejabat yang berwenang</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-sm font-medium text-white">5</span>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-900">Pengambilan</h3>
                            <p class="text-sm text-gray-600">Surat siap diambil di kantor desa sesuai jadwal yang ditentukan</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Notes -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-medium text-yellow-900">Catatan Penting</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Pastikan semua dokumen yang diupload jelas dan dapat dibaca</li>
                                <li>Data yang diisi harus sesuai dengan dokumen asli</li>
                                <li>Permohonan yang tidak lengkap akan dikembalikan untuk diperbaiki</li>
                                <li>Bawa dokumen asli saat pengambilan surat untuk verifikasi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Service Summary -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Layanan</h3>
                <div class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Waktu Proses</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $info['waktu_proses'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Biaya</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $info['biaya'] }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Jam Layanan</dt>
                        <dd class="mt-1 text-sm text-gray-900">Senin - Jumat<br>08:00 - 16:00 WIB</dd>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi</h3>
                <div class="space-y-3">
                    <a href="{{ route('layanan.create', $jenis) }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ajukan Permohonan
                    </a>
                    
                    <a href="{{ route('layanan.index') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Layanan
                    </a>
                    
                    @auth
                    <a href="{{ route('layanan.riwayat') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Riwayat Permohonan
                    </a>
                    @endauth
                </div>
            </div>

            <!-- Contact Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Butuh Bantuan?</h3>
                <div class="space-y-3">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        (021) 1234-5678
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        desa@example.com
                    </div>
                    <a href="{{ route('kontak') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        Lihat informasi kontak lengkap →
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection