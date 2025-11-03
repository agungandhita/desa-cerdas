@extends('layouts.frontend')

@section('title', 'Edit Diskusi - ' . $forum->judul)

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
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('forum.show', $forum) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">{{ Str::limit($forum->judul, 30) }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Edit Diskusi</h1>
                        <p class="text-gray-600 mt-1">Perbarui diskusi Anda</p>
                    </div>

                    <form action="{{ route('forum.update', $forum) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Title -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Diskusi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="judul" 
                                   id="judul" 
                                   value="{{ old('judul', $forum->judul) }}"
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
                                <option value="umum" {{ old('kategori', $forum->kategori) == 'umum' ? 'selected' : '' }}>Umum</option>
                                <option value="pembangunan" {{ old('kategori', $forum->kategori) == 'pembangunan' ? 'selected' : '' }}>Pembangunan</option>
                                <option value="ekonomi" {{ old('kategori', $forum->kategori) == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                <option value="sosial" {{ old('kategori', $forum->kategori) == 'sosial' ? 'selected' : '' }}>Sosial</option>
                                <option value="budaya" {{ old('kategori', $forum->kategori) == 'budaya' ? 'selected' : '' }}>Budaya</option>
                                <option value="lingkungan" {{ old('kategori', $forum->kategori) == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                                <option value="kesehatan" {{ old('kategori', $forum->kategori) == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="pendidikan" {{ old('kategori', $forum->kategori) == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
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
                                      required>{{ old('isi', $forum->isi) }}</textarea>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('forum.show', $forum) }}" 
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
                <!-- Discussion Info -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Diskusi</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dibuat:</span>
                            <span class="font-medium">{{ $forum->created_at->format('d M Y') }}</span>
                        </div>
                        @if($forum->created_at != $forum->updated_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Terakhir diubah:</span>
                                <span class="font-medium">{{ $forum->updated_at->format('d M Y') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Views:</span>
                            <span class="font-medium">{{ $forum->views }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Komentar:</span>
                            <span class="font-medium">{{ $forum->jumlah_komentar }}</span>
                        </div>
                        @if($forum->kategori)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kategori:</span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst($forum->kategori) }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Edit Guidelines -->
                <div class="bg-yellow-50 rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold text-yellow-900 mb-3">Panduan Edit</h3>
                    <ul class="space-y-2 text-sm text-yellow-800">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Pastikan perubahan tidak mengubah konteks diskusi
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Komentar yang sudah ada tidak akan terpengaruh
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Tetap gunakan bahasa yang sopan dan konstruktif
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Perubahan akan ditandai sebagai "diedit"
                        </li>
                    </ul>
                </div>

                <!-- Quick Links -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tautan Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('forum.show', $forum) }}" class="flex items-center text-blue-600 hover:text-blue-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Lihat Diskusi
                        </a>
                        <a href="{{ route('forum.index') }}" class="flex items-center text-green-600 hover:text-green-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            Semua Diskusi
                        </a>
                        <a href="{{ route('forum.my-discussions') }}" class="flex items-center text-purple-600 hover:text-purple-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Diskusi Saya
                        </a>
                        <form action="{{ route('forum.destroy', $forum) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus diskusi ini? Tindakan ini tidak dapat dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="flex items-center text-red-600 hover:text-red-800 transition duration-300 w-full text-left">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Hapus Diskusi
                            </button>
                        </form>
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

    // Warn about unsaved changes
    let formChanged = false;
    const formElements = form.querySelectorAll('input, textarea, select');
    
    formElements.forEach(element => {
        element.addEventListener('change', function() {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    form.addEventListener('submit', function() {
        formChanged = false;
    });
});
</script>
@endsection