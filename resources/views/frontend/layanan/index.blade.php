@extends('frontend.layouts.main')

@section('container')
<!-- Hero Section (match theme from Tentang page) -->
<section class="relative h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px] xl:h-[500px] flex items-center justify-center text-center text-white" style="background-image: url('https://images.unsplash.com/photo-1519791883288-dc8bd696e667?q=80&w=1935&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative z-10 p-4">
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight leading-tight mb-2">Layanan Publik Desa</h1>
        <p class="text-base sm:text-lg md:text-xl lg:text-2xl font-light max-w-3xl mx-auto">Akses berbagai layanan administrasi desa dengan mudah dan cepat secara online.</p>
    </div>
    
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Service Information -->
    <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 mb-8" role="alert">
        <div class="flex">
            <div class="py-1">
                <svg class="h-6 w-6 text-blue-500 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="font-bold">Informasi Penting</p>
                <ul class="list-disc list-inside text-sm">
                    <li>Layanan online tersedia 24 jam.</li>
                    <li>Verifikasi permohonan dilakukan pada hari dan jam kerja.</li>
                    <li>Status permohonan akan diinformasikan melalui notifikasi sistem.</li>
                    <li>Dokumen fisik dapat diambil di kantor desa setelah permohonan disetujui.</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
        @foreach($layanan as $service)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 ease-in-out group">
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        @switch($service['icon'])
                            @case('home')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                @break
                            @case('briefcase')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V8m8 0V6a2 2 0 00-2-2H10a2 2 0 00-2 2v2"></path></svg>
                                @break
                            @case('heart')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                @break
                            @case('users')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path></svg>
                                @break
                            @case('baby')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @break
                            @case('cross')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @break
                            @default
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        @endswitch
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 ml-4">{{ $service['nama'] }}</h3>
                </div>
                <p class="text-gray-600 text-sm mb-4 h-16">{{ Str::limit($service['deskripsi'], 100) }}</p>

                <div class="border-t border-gray-200 pt-4">
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Persyaratan:</h4>
                    <ul class="text-xs text-gray-500 space-y-1 mb-4">
                        @foreach(array_slice($service['persyaratan'], 0, 2) as $syarat)
                        <li class="flex items-start">
                            <svg class="w-3 h-3 text-green-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span>{{ $syarat }}</span>
                        </li>
                        @endforeach
                        @if(count($service['persyaratan']) > 2)
                        <li class="text-blue-500 font-semibold">... dan lainnya</li>
                        @endif
                    </ul>
                    <div class="flex space-x-3 mt-4">
                        <a href="{{ route('layanan.info', ['jenis' => $service['jenis']]) }}" class="flex-1 text-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Info Lengkap
                        </a>
                        <a href="{{ route('layanan.create', ['jenis' => $service['jenis']]) }}" class="flex-1 text-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                            Ajukan Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Quick Actions -->
    <div class="bg-gray-50 rounded-lg p-6 sm:p-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Akses Cepat</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @auth
            <a href="{{ route('layanan.riwayat') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex-shrink-0 flex items-center justify-center w-16 h-16 bg-green-100 rounded-full text-green-600 mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <p class="text-sm font-semibold text-gray-800 text-center">Riwayat Permohonan</p>
            </a>
            @else
            <a href="{{ route('login') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex-shrink-0 flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full text-blue-600 mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                </div>
                <p class="text-sm font-semibold text-gray-800 text-center">Login Pengguna</p>
            </a>
            @endauth

            <a href="{{ route('kontak') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex-shrink-0 flex items-center justify-center w-16 h-16 bg-yellow-100 rounded-full text-yellow-600 mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <p class="text-sm font-semibold text-gray-800 text-center">Hubungi Kami</p>
            </a>

            <a href="{{ route('berita.index') }}" class="flex flex-col items-center justify-center p-4 bg-white rounded-lg shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="flex-shrink-0 flex items-center justify-center w-16 h-16 bg-purple-100 rounded-full text-purple-600 mb-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
                <p class="text-sm font-semibold text-gray-800 text-center">Berita Terkini</p>
            </a>
        </div>
    </div>
</div>
@endsection
