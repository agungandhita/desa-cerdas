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
                        <span class="ml-4 text-sm font-medium text-gray-500">Ajukan Permohonan</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-gray-900">Ajukan Permohonan Surat</h1>
            <p class="mt-2 text-gray-600">Isi formulir di bawah ini untuk mengajukan permohonan surat</p>
        </div>
    </div>
</div>
@endsection

@section('container')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- Service Type -->
                    <div>
                        <label for="jenis_surat" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Surat <span class="text-red-500">*</span>
                        </label>
                        <select name="jenis_surat" id="jenis_surat" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('jenis_surat') border-red-500 @enderror">
                            <option value="">Pilih Jenis Surat</option>
                            @foreach($jenisLayanan as $key => $nama)
                            <option value="{{ $key }}" {{ (old('jenis_surat', $jenis) == $key) ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('jenis_surat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Purpose -->
                    <div>
                        <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-2">
                            Keperluan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="keperluan" id="keperluan" rows="4" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('keperluan') border-red-500 @enderror"
                                  placeholder="Jelaskan keperluan surat yang Anda ajukan...">{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Maksimal 500 karakter</p>
                    </div>

                    <!-- Additional Information -->
                    <div>
                        <label for="keterangan_tambahan" class="block text-sm font-medium text-gray-700 mb-2">
                            Keterangan Tambahan
                        </label>
                        <textarea name="keterangan_tambahan" id="keterangan_tambahan" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('keterangan_tambahan') border-red-500 @enderror"
                                  placeholder="Informasi tambahan yang perlu diketahui (opsional)...">{{ old('keterangan_tambahan') }}</textarea>
                        @error('keterangan_tambahan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter</p>
                    </div>

                    <!-- Supporting Documents -->
                    <div>
                        <label for="dokumen_pendukung" class="block text-sm font-medium text-gray-700 mb-2">
                            Dokumen Pendukung
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="dokumen_pendukung" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload file</span>
                                        <input id="dokumen_pendukung" name="dokumen_pendukung" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, JPG, JPEG, PNG hingga 2MB</p>
                            </div>
                        </div>
                        @error('dokumen_pendukung')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                       class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-700">
                                    Saya menyetujui syarat dan ketentuan
                                </label>
                                <p class="text-gray-500">
                                    Dengan mencentang kotak ini, saya menyatakan bahwa data yang saya berikan adalah benar dan dapat dipertanggungjawabkan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex space-x-4">
                        <button type="submit" 
                                class="flex-1 inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Ajukan Permohonan
                        </button>
                        
                        <a href="{{ route('layanan.index') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- User Info -->
            @auth
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Pemohon</h3>
                <div class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nama</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->email }}</dd>
                    </div>
                    @if(Auth::user()->phone)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Telepon</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ Auth::user()->phone }}</dd>
                    </div>
                    @endif
                </div>
                <div class="mt-4">
                    <a href="{{ route('profile.edit') }}" class="text-sm text-blue-600 hover:text-blue-800">
                        Edit profil →
                    </a>
                </div>
            </div>
            @endauth

            <!-- Important Notes -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-900">Catatan Penting</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Pastikan data yang diisi benar dan lengkap</li>
                                <li>Upload dokumen dengan kualitas yang jelas</li>
                                <li>Permohonan akan diproses dalam 3-5 hari kerja</li>
                                <li>Anda akan mendapat notifikasi status permohonan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tautan Cepat</h3>
                <div class="space-y-3">
                    <a href="{{ route('layanan.index') }}" 
                       class="block text-sm text-gray-600 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali ke Layanan
                    </a>
                    
                    @auth
                    <a href="{{ route('layanan.riwayat') }}" 
                       class="block text-sm text-gray-600 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Riwayat Permohonan
                    </a>
                    @endauth
                    
                    <a href="{{ route('kontak') }}" 
                       class="block text-sm text-gray-600 hover:text-blue-600 transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Bantuan & Kontak
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// File upload preview
document.getElementById('dokumen_pendukung').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        
        // Create preview element
        const preview = document.createElement('div');
        preview.className = 'mt-2 text-sm text-gray-600';
        preview.innerHTML = `
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <span>${fileName} (${fileSize} MB)</span>
            </div>
        `;
        
        // Remove existing preview
        const existingPreview = e.target.parentNode.parentNode.parentNode.querySelector('.mt-2');
        if (existingPreview) {
            existingPreview.remove();
        }
        
        // Add new preview
        e.target.parentNode.parentNode.parentNode.appendChild(preview);
    }
});
</script>
@endsection