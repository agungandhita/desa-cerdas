@extends('layouts.frontend')

@section('title', 'Detail Permohonan Layanan')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('layanan.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Layanan Publik</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('layanan.riwayat') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Riwayat Permohonan</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail Permohonan</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Header -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                                {{ ucwords(str_replace('_', ' ', $permohonan->jenis_layanan)) }}
                            </h1>
                            <p class="text-gray-600">No. Permohonan: #{{ $permohonan->id }}</p>
                        </div>
                        <span class="mt-2 sm:mt-0 px-4 py-2 rounded-full text-sm font-medium
                            @if($permohonan->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($permohonan->status == 'diproses') bg-blue-100 text-blue-800
                            @elseif($permohonan->status == 'selesai') bg-green-100 text-green-800
                            @elseif($permohonan->status == 'ditolak') bg-red-100 text-red-800
                            @endif">
                            @if($permohonan->status == 'pending') Menunggu Verifikasi
                            @elseif($permohonan->status == 'diproses') Sedang Diproses
                            @elseif($permohonan->status == 'selesai') Selesai
                            @elseif($permohonan->status == 'ditolak') Ditolak
                            @endif
                        </span>
                    </div>

                    <!-- Status Progress -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">Progress Status</span>
                            <span class="text-sm text-gray-500">
                                @if($permohonan->status == 'pending') 25%
                                @elseif($permohonan->status == 'diproses') 75%
                                @elseif($permohonan->status == 'selesai') 100%
                                @elseif($permohonan->status == 'ditolak') 0%
                                @endif
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full
                                @if($permohonan->status == 'pending') bg-yellow-500 w-1/4
                                @elseif($permohonan->status == 'diproses') bg-blue-500 w-3/4
                                @elseif($permohonan->status == 'selesai') bg-green-500 w-full
                                @elseif($permohonan->status == 'ditolak') bg-red-500 w-0
                                @endif">
                            </div>
                        </div>
                    </div>

                    <!-- Timeline -->
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-sm font-medium text-gray-900">Permohonan Diajukan</h4>
                                <p class="text-sm text-gray-600">{{ $permohonan->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        @if($permohonan->status != 'pending')
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 
                                    @if($permohonan->status == 'ditolak') bg-red-500 @else bg-green-500 @endif 
                                    rounded-full flex items-center justify-center">
                                    @if($permohonan->status == 'ditolak')
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900">
                                        @if($permohonan->status == 'ditolak') Permohonan Ditolak
                                        @else Permohonan Diverifikasi
                                        @endif
                                    </h4>
                                    <p class="text-sm text-gray-600">{{ $permohonan->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($permohonan->status == 'diproses' || $permohonan->status == 'selesai')
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900">Sedang Diproses</h4>
                                    <p class="text-sm text-gray-600">Dokumen sedang dalam proses pembuatan</p>
                                </div>
                            </div>
                        @endif

                        @if($permohonan->status == 'selesai')
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900">Selesai</h4>
                                    <p class="text-sm text-gray-600">Dokumen siap untuk diunduh</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Request Details -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Permohonan</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan</label>
                            <p class="text-gray-900">{{ ucwords(str_replace('_', ' ', $permohonan->jenis_layanan)) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pengajuan</label>
                            <p class="text-gray-900">{{ $permohonan->created_at->format('d M Y, H:i') }}</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Keperluan</label>
                            <p class="text-gray-900">{{ $permohonan->keperluan }}</p>
                        </div>

                        @if($permohonan->keterangan_tambahan)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
                                <p class="text-gray-900">{{ $permohonan->keterangan_tambahan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Supporting Documents -->
                @if($permohonan->dokumen_pendukung)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Dokumen Pendukung</h2>
                        
                        @php
                            $documents = json_decode($permohonan->dokumen_pendukung, true);
                        @endphp

                        @if($documents && count($documents) > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($documents as $index => $document)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center mb-2">
                                            <svg class="w-8 h-8 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">Dokumen {{ $index + 1 }}</p>
                                                <p class="text-xs text-gray-500">{{ basename($document) }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ Storage::url($document) }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Lihat
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Admin Response -->
                @if($permohonan->keterangan_admin)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Keterangan Admin</h2>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900">{{ $permohonan->keterangan_admin }}</p>
                        </div>
                    </div>
                @endif

                <!-- Result Document -->
                @if($permohonan->status == 'selesai' && $permohonan->file_hasil)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Dokumen Hasil</h2>
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <div class="flex items-center mb-4">
                                <svg class="w-12 h-12 text-green-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-medium text-green-900">Dokumen Siap Diunduh</h3>
                                    <p class="text-green-700">Permohonan Anda telah selesai diproses</p>
                                </div>
                            </div>
                            <a href="{{ Storage::url($permohonan->file_hasil) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Unduh Dokumen
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('layanan.riwayat') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Kembali ke Riwayat
                        </a>
                        <a href="{{ route('layanan.create') }}" class="flex items-center text-green-600 hover:text-green-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Ajukan Permohonan Baru
                        </a>
                        <a href="{{ route('layanan.index') }}" class="flex items-center text-purple-600 hover:text-purple-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Lihat Semua Layanan
                        </a>
                        <a href="{{ route('kontak') }}" class="flex items-center text-orange-600 hover:text-orange-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Hubungi Kami
                        </a>
                    </div>
                </div>

                <!-- Request Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Permohonan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">No. Permohonan:</span>
                            <span class="text-sm font-medium text-gray-900">#{{ $permohonan->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tanggal Pengajuan:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $permohonan->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="text-sm font-medium
                                @if($permohonan->status == 'pending') text-yellow-600
                                @elseif($permohonan->status == 'diproses') text-blue-600
                                @elseif($permohonan->status == 'selesai') text-green-600
                                @elseif($permohonan->status == 'ditolak') text-red-600
                                @endif">
                                @if($permohonan->status == 'pending') Menunggu
                                @elseif($permohonan->status == 'diproses') Diproses
                                @elseif($permohonan->status == 'selesai') Selesai
                                @elseif($permohonan->status == 'ditolak') Ditolak
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Terakhir Update:</span>
                            <span class="text-sm font-medium text-gray-900">{{ $permohonan->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Help & Support -->
                <div class="bg-blue-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Butuh Bantuan?</h3>
                    <p class="text-blue-700 text-sm mb-4">Jika Anda memiliki pertanyaan tentang permohonan ini, silakan hubungi kami.</p>
                    <div class="space-y-2">
                        <a href="tel:+62123456789" class="flex items-center text-blue-600 hover:text-blue-800 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            (0123) 456-789
                        </a>
                        <a href="mailto:admin@desa.go.id" class="flex items-center text-blue-600 hover:text-blue-800 text-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            admin@desa.go.id
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection