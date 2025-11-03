@extends('layouts.frontend')

@section('title', 'Buat Diskusi Baru')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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
                        <a href="{{ route('forum.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Forum Diskusi</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Buat Diskusi</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Buat Diskusi Baru</h1>
                        <p class="text-gray-600 mt-1">Mulai diskusi baru dengan warga desa</p>
                    </div>

                    <form action="{{ route('forum.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Diskusi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="judul" 
                                   id="judul" 
                                   value="{{ old('judul') }}"
                                   placeholder="Masukkan judul diskusi yang menarik..."
                                   class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('judul') border-red-500 @enderror"
                                   required>
                            @error('judul')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori
                            </label>
                            <select name="kategori" 
                                    id="kategori" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kategori') border-red-500 @enderror">
                                <option value="">Pilih Kategori (Opsional)</option>
                                <option value="umum" {{ old('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                                <option value="pembangunan" {{ old('kategori') == 'pembangunan' ? 'selected' : '' }}>Pembangunan</option>
                                <option value="ekonomi" {{ old('kategori') == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                <option value="sosial" {{ old('kategori') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                                <option value="budaya" {{ old('kategori') == 'budaya' ? 'selected' : '' }}>Budaya</option>
                                <option value="lingkungan" {{ old('kategori') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                                <option value="kesehatan" {{ old('kategori') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="pendidikan" {{ old('kategori') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            </select>
                            @error('kategori')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div>
                            <label for="isi" class="block text-sm font-medium text-gray-700 mb-2">
                                Isi Diskusi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="isi" 
                                      id="isi" 
                                      rows="10"
                                      placeholder="Tulis isi diskusi Anda di sini. Jelaskan topik yang ingin didiskusikan dengan detail..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('isi') border-red-500 @enderror"
                                      required>{{ old('isi') }}</textarea>
                            @error('isi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Minimum 10 karakter. Gunakan bahasa yang sopan dan konstruktif.</p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button type="submit" 
                                    class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-300 font-medium">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Buat Diskusi
                            </button>
                            <a href="{{ route('forum.index') }}" 
                               class="flex-1 bg-gray-500 text-white px-6 py-3 rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-300 font-medium text-center">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- User Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Penulis</h3>
                    <div class="flex items-center mb-4">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="ml-3">
                            <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800 text-sm transition duration-300">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Profil
                    </a>
                </div>

                <!-- Guidelines -->
                <div class="bg-blue-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-blue-900 mb-3">Panduan Diskusi</h3>
                    <ul class="space-y-2 text-sm text-blue-800">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Gunakan judul yang jelas dan deskriptif
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Pilih kategori yang sesuai dengan topik
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Jelaskan topik dengan detail dan jelas
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Gunakan bahasa yang sopan dan konstruktif
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Hindari konten yang menyinggung atau tidak pantas
                        </li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tautan Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('forum.index') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Lihat Semua Diskusi
                        </a>
                        <a href="{{ route('forum.my-discussions') }}" class="flex items-center text-green-600 hover:text-green-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Diskusi Saya
                        </a>
                        <a href="{{ route('home') }}" class="flex items-center text-purple-600 hover:text-purple-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-resize textarea
    const textarea = document.getElementById('isi');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Character counter for title
    const titleInput = document.getElementById('judul');
    const maxTitleLength = 255;
    
    titleInput.addEventListener('input', function() {
        const currentLength = this.value.length;
        if (currentLength > maxTitleLength) {
            this.value = this.value.substring(0, maxTitleLength);
        }
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const title = titleInput.value.trim();
        const content = textarea.value.trim();
        
        if (title.length < 5) {
            e.preventDefault();
            alert('Judul diskusi minimal 5 karakter');
            titleInput.focus();
            return;
        }
        
        if (content.length < 10) {
            e.preventDefault();
            alert('Isi diskusi minimal 10 karakter');
            textarea.focus();
            return;
        }
    });
});
</script>
@endsection