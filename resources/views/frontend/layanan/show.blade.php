@extends('frontend.layouts.main')

@section('title', 'Detail Permohonan Layanan')

@push('styles')
<style>
    .timeline-item:last-child .timeline-line {
        display: none;
    }
</style>
@endpush

@section('container')
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0                          20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('layanan.index') }}" class="ml-1 font-medium text-gray-700 hover:text-blue-600 md:ml-2">Layanan</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <a href="{{ route('layanan.riwayat') }}" class="ml-1 font-medium text-gray-700 hover:text-blue-600 md:ml-2">Riwayat</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <span class="ml-1 font-medium text-gray-500 md:ml-2">Detail Permohonan</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Header -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800 mb-1">
                                {{ ucwords(str_replace('_', ' ', $permohonan->jenis_surat)) }}
                            </h1>
                            <p class="text-gray-500 text-sm">No. Permohonan: #{{ $permohonan->id }}</p>
                        </div>
                        <div class="mt-3 sm:mt-0">
                            <span class="px-4 py-2 rounded-full text-sm font-semibold
                                @if($permohonan->status == 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
                                @elseif($permohonan->status == 'diproses') bg-blue-100 text-blue-800 border border-blue-200
                                @elseif($permohonan->status == 'selesai') bg-green-100 text-green-800 border border-green-200
                                @elseif($permohonan->status == 'ditolak') bg-red-100 text-red-800 border border-red-200
                                @endif">
                                @if($permohonan->status == 'pending') Menunggu Verifikasi
                                @elseif($permohonan->status == 'diproses') Sedang Diproses
                                @elseif($permohonan->status == 'selesai') Selesai
                                @elseif($permohonan->status == 'ditolak') Ditolak
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Request Details -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-4">Detail Permohonan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Layanan</label>
                            <p class="text-gray-800 font-semibold">{{ ucwords(str_replace('_', ' ', $permohonan->jenis_surat)) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tanggal Pengajuan</label>
                            <p class="text-gray-800 font-semibold">{{ $permohonan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-500 mb-1">Keperluan</label>
                            <p class="text-gray-800">{{ $permohonan->keperluan }}</p>
                        </div>
                        @if($permohonan->keterangan_tambahan)
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-500 mb-1">Keterangan Tambahan</label>
                                <p class="text-gray-800">{{ $permohonan->keterangan_tambahan }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Supporting Documents -->
                @if($permohonan->dokumen_pendukung)
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 border-b pb-4">Dokumen Pendukung</h2>
                        @php
                            $documents = json_decode($permohonan->dokumen_pendukung, true);
                        @endphp
                        @if($documents && count($documents) > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($documents as $document)
                                    <a href="{{ Storage::url($document) }}" target="_blank" class="group border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition duration-300">
                                        <div class="flex items-center">
                                            <svg class="w-10 h-10 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <div>
                                                <p class="text-sm font-medium text-gray-800 group-hover:text-blue-600">Lihat Dokumen</p>
                                                <p class="text-xs text-gray-500">{{ basename($document) }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Admin Response -->
                @if($permohonan->catatan)
                    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Catatan dari Admin</h2>
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                            <p class="text-gray-700 italic">"{{ $permohonan->catatan }}"</p>
                        </div>
                    </div>
                @endif

                <!-- Result Document -->
                @if($permohonan->status == 'selesai' && $permohonan->file_pdf)
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl shadow-lg p-8">
                        <div class="flex flex-col md:flex-row items-center text-white">
                            <svg class="w-16 h-16 mb-4 md:mb-0 md:mr-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <h2 class="text-2xl font-bold">Dokumen Anda Telah Terbit!</h2>
                                <p class="mt-1 opacity-90">Permohonan Anda telah selesai diproses. Silakan unduh dokumen hasilnya.</p>
                            </div>
                            <div class="mt-6 md:mt-0 md:ml-auto">
                                <a href="{{ Storage::url($permohonan->file_pdf) }}" target="_blank" class="inline-flex items-center px-6 py-3 bg-white text-green-600 font-bold rounded-lg hover:bg-gray-100 transition duration-300 shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    Unduh Dokumen
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Timeline -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 border-b pb-4">Riwayat Status</h3>
                    <div class="relative">
                        <!-- Timeline Item: Diajukan -->
                        <div class="flex items-start mb-6 timeline-item">
                            <div class="flex flex-col items-center mr-4">
                                <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center z-10">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                </div>
                                <div class="w-px h-full bg-gray-300 timeline-line"></div>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Permohonan Diajukan</h4>
                                <p class="text-sm text-gray-500">{{ $permohonan->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <!-- Timeline Item: Diverifikasi / Ditolak -->
                        @if($permohonan->status != 'pending')
                            <div class="flex items-start mb-6 timeline-item">
                                <div class="flex flex-col items-center mr-4">
                                    <div class="flex-shrink-0 w-10 h-10 @if($permohonan->status == 'ditolak') bg-red-500 @else bg-green-500 @endif rounded-full flex items-center justify-center z-10">
                                        @if($permohonan->status == 'ditolak')
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        @else
                                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                        @endif
                                    </div>
                                    <div class="w-px h-full bg-gray-300 timeline-line"></div>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">
                                        @if($permohonan->status == 'ditolak') Permohonan Ditolak
                                        @else Permohonan Diverifikasi
                                        @endif
                                    </h4>
                                    <p class="text-sm text-gray-500">{{ $permohonan->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Timeline Item: Diproses -->
                        @if($permohonan->status == 'diproses' || $permohonan->status == 'selesai')
                            <div class="flex items-start mb-6 timeline-item">
                                <div class="flex flex-col items-center mr-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center z-10">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                                    </div>
                                    <div class="w-px h-full bg-gray-300 timeline-line"></div>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Sedang Diproses</h4>
                                    <p class="text-sm text-gray-500">Dokumen sedang dalam proses pengerjaan oleh staf.</p>
                                </div>
                            </div>
                        @endif

                        <!-- Timeline Item: Selesai -->
                        @if($permohonan->status == 'selesai')
                            <div class="flex items-start timeline-item">
                                <div class="flex flex-col items-center mr-4">
                                    <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-full flex items-center justify-center z-10">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800">Selesai</h4>
                                    <p class="text-sm text-gray-500">Dokumen siap untuk diunduh.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('layanan.riwayat') }}" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-300">
                            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            Kembali ke Riwayat
                        </a>
                        <a href="{{ route('layanan.create') }}" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-300">
                            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Ajukan Permohonan Baru
                        </a>
                        <a href="{{ route('kontak') }}" class="flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition duration-300">
                            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Hubungi Bantuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
