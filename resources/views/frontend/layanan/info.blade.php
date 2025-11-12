@extends('frontend.layouts.main')

@section('breadcrumb')
<div class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="py-4">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div>
                            <a href="{{ route('beranda') }}" class="text-gray-400 hover:text-gray-500">
                                <svg class="flex-shrink-0 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                <span class="sr-only">Beranda</span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="{{ route('layanan.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Layanan</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500">{{ $info['nama'] }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('container')
<div class="bg-white">
    <div class="relative bg-blue-800">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1505904267569-f02b7b46b43a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Layanan Publik">
            <div class="absolute inset-0 bg-blue-800 mix-blend-multiply" aria-hidden="true"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">{{ $info['nama'] }}</h1>
            <p class="mt-6 text-xl text-blue-100 max-w-3xl">{{ $info['deskripsi'] }}</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid lg:grid-cols-3 lg:gap-8">
            <div class="lg:col-span-2">
                <div class="bg-gray-50 rounded-xl p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Persyaratan</h2>
                    <ul class="space-y-4">
                        @foreach($info['persyaratan'] as $index => $syarat)
                        <li class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <p class="ml-3 text-gray-700">{{ $syarat }}</p>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="bg-gray-50 rounded-xl p-8 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Alur Proses Layanan</h2>
                    <div class="relative">
                        <div class="absolute left-4 top-4 bottom-4 w-0.5 bg-gray-200"></div>
                        <div class="space-y-8">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold z-10">1</div>
                                <div class="ml-6">
                                    <h3 class="font-bold text-gray-900">Persiapan Dokumen</h3>
                                    <p class="mt-1 text-gray-600">Siapkan semua dokumen persyaratan yang diperlukan dalam format digital (PDF/JPG).</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold z-10">2</div>
                                <div class="ml-6">
                                    <h3 class="font-bold text-gray-900">Pengajuan Online</h3>
                                    <p class="mt-1 text-gray-600">Isi formulir permohonan online dan unggah semua dokumen pendukung.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold z-10">3</div>
                                <div class="ml-6">
                                    <h3 class="font-bold text-gray-900">Verifikasi Petugas</h3>
                                    <p class="mt-1 text-gray-600">Petugas kami akan memeriksa kelengkapan dan keabsahan data serta dokumen Anda.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold z-10">4</div>
                                <div class="ml-6">
                                    <h3 class="font-bold text-gray-900">Proses Penerbitan</h3>
                                    <p class="mt-1 text-gray-600">Dokumen akan diproses dan ditandatangani oleh pejabat yang berwenang.</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white font-bold z-10">5</div>
                                <div class="ml-6">
                                    <h3 class="font-bold text-gray-900">Selesai & Unduh</h3>
                                    <p class="mt-1 text-gray-600">Dokumen hasil layanan dapat diunduh melalui halaman riwayat permohonan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.21 3.03-1.742 3.03H4.42c-1.532 0-2.492-1.696-1.742-3.03l5.58-9.92zM10 13a1 1 0 110-2 1 1 0 010 2zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-yellow-800">Catatan Penting</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Pastikan semua dokumen yang diunggah jelas dan dapat dibaca.</li>
                                    <li>Data yang diisi harus sesuai dengan dokumen kependudukan yang sah.</li>
                                    <li>Permohonan yang tidak lengkap atau tidak valid akan ditolak.</li>
                                    <li>Waktu proses dapat bervariasi tergantung pada kelengkapan dokumen.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-8 mt-8 lg:mt-0">
                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Informasi Layanan</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div class="ml-3">
                                <dt class="text-sm font-medium text-gray-500">Waktu Proses</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $info['waktu_proses'] }}</dd>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H9a2 2 0 00-2 2v2m10 0a5 5 0 01-10 0m10 0H7m10 0v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4m10 0v4" />
                            </svg>
                            <div class="ml-3">
                                <dt class="text-sm font-medium text-gray-500">Biaya</dt>
                                <dd class="text-sm font-semibold text-gray-900">{{ $info['biaya'] }}</dd>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <svg class="h-6 w-6 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div class="ml-3">
                                <dt class="text-sm font-medium text-gray-500">Jam Layanan</dt>
                                <dd class="text-sm font-semibold text-gray-900">Senin - Jumat, 08:00 - 15:00</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-600 rounded-xl p-6 text-white">
                    <h3 class="text-xl font-bold mb-4">Siap Mengajukan?</h3>
                    <p class="mb-6">Klik tombol di bawah ini untuk memulai proses permohonan layanan.</p>
                    <a href="{{ route('layanan.create', ['jenis' => $jenis]) }}" class="w-full block text-center bg-white text-blue-600 font-bold py-3 px-4 rounded-lg hover:bg-blue-50 transition-colors">
                        Ajukan Permohonan
                    </a>
                </div>

                <div class="bg-gray-50 rounded-xl p-6">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Butuh Bantuan?</h3>
                    <p class="text-gray-600 mb-4">Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan.</p>
                    <a href="{{ route('kontak') }}" class="font-semibold text-blue-600 hover:text-blue-800">
                        Hubungi Kami &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection