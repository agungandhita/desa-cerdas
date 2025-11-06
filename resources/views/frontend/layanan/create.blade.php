@extends('frontend.layouts.main')

@section('container')
<div class="bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900">Formulir Permohonan Surat</h1>
            <p class="mt-3 text-lg text-gray-600">Lengkapi data berikut untuk mengajukan permohonan surat Anda.</p>
        </div>

        <div class="bg-white rounded-2xl shadow-xl p-8">
            <form action="{{ route('layanan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                <!-- Step 1: Service Selection -->
                <div class="p-6 border border-gray-200 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg">1</div>
                        <h2 class="ml-4 text-2xl font-bold text-gray-800">Pilih Jenis Layanan</h2>
                    </div>
                    <div>
                        <label for="jenis_surat" class="sr-only">Jenis Surat</label>
                        <select name="jenis_surat" id="jenis_surat" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow @error('jenis_surat') border-red-500 @enderror">
                            <option value="">-- Pilih Jenis Surat --</option>
                            @foreach($jenisLayanan as $key => $nama)
                            <option value="{{ $key }}" {{ (old('jenis_surat', $jenis) == $key) ? 'selected' : '' }}>
                                {{ $nama }}
                            </option>
                            @endforeach
                        </select>
                        @error('jenis_surat')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Step 2: Details -->
                <div class="p-6 border border-gray-200 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg">2</div>
                        <h2 class="ml-4 text-2xl font-bold text-gray-800">Detail Keperluan</h2>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <label for="keperluan" class="block text-sm font-medium text-gray-700 mb-1">Keperluan</label>
                            <textarea name="keperluan" id="keperluan" rows="4" required
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('keperluan') border-red-500 @enderror"
                                      placeholder="Contoh: Untuk melamar pekerjaan di PT. Sejahtera Abadi">{{ old('keperluan') }}</textarea>
                            @error('keperluan')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="keterangan_tambahan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan (Opsional)</label>
                            <textarea name="keterangan_tambahan" id="keterangan_tambahan" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('keterangan_tambahan') border-red-500 @enderror"
                                      placeholder="Informasi lain yang relevan...">{{ old('keterangan_tambahan') }}</textarea>
                            @error('keterangan_tambahan')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Step 3: Document Upload -->
                <div class="p-6 border border-gray-200 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg">3</div>
                        <h2 class="ml-4 text-2xl font-bold text-gray-800">Unggah Dokumen</h2>
                    </div>
                    <div>
                        <label for="dokumen_pendukung" class="block text-sm font-medium text-gray-700 mb-2">Dokumen Pendukung (jika ada)</label>
                        <div id="file-upload-area" class="relative mt-1 flex justify-center px-6 pt-10 pb-10 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-500 transition-colors cursor-pointer">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="dokumen_pendukung" class="relative font-medium text-blue-600 hover:text-blue-500">
                                        <span>Pilih file untuk diunggah</span>
                                        <input id="dokumen_pendukung" name="dokumen_pendukung" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                                    </label>
                                    <p class="pl-1">atau seret dan lepas</p>
                                </div>
                                <p class="text-xs text-gray-500">PDF, JPG, PNG (maks. 2MB)</p>
                            </div>
                        </div>
                        <div id="file-preview" class="mt-4 hidden"></div>
                        @error('dokumen_pendukung')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Step 4: Confirmation -->
                <div class="p-6 border border-gray-200 rounded-lg">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold text-lg">4</div>
                        <h2 class="ml-4 text-2xl font-bold text-gray-800">Konfirmasi & Kirim</h2>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="terms" name="terms" type="checkbox" required
                                       class="focus:ring-blue-500 h-5 w-5 text-blue-600 border-gray-300 rounded">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="terms" class="font-medium text-gray-800">
                                    Saya menyatakan data yang diisi adalah benar.
                                </label>
                                <p class="text-gray-600 mt-1">
                                    Dengan ini, saya bertanggung jawab penuh atas kebenaran data dan dokumen yang saya lampirkan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submission -->
                <div class="pt-5">
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('layanan.index') }}" 
                           class="px-8 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-shadow">
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-lg shadow-blue-500/50 hover:shadow-xl transition-all">
                            Kirim Permohonan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileUploadArea = document.getElementById('file-upload-area');
    const fileInput = document.getElementById('dokumen_pendukung');
    const filePreview = document.getElementById('file-preview');

    fileUploadArea.addEventListener('click', () => fileInput.click());

    fileUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        fileUploadArea.classList.add('border-blue-500');
    });

    fileUploadArea.addEventListener('dragleave', () => {
        fileUploadArea.classList.remove('border-blue-500');
    });

    fileUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        fileUploadArea.classList.remove('border-blue-500');
        if (e.dataTransfer.files.length > 0) {
            fileInput.files = e.dataTransfer.files;
            handleFiles(fileInput.files);
        }
    });

    fileInput.addEventListener('change', () => {
        handleFiles(fileInput.files);
    });

    function handleFiles(files) {
        if (files.length === 0) {
            filePreview.innerHTML = '';
            filePreview.classList.add('hidden');
            return;
        }

        const file = files[0];
        const fileName = file.name;
        const fileSize = (file.size / 1024 / 1024).toFixed(2);

        filePreview.innerHTML = `
            <div class="flex items-center justify-between p-3 bg-gray-100 rounded-lg border border-gray-200">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <p class="text-sm font-medium text-gray-800">${fileName}</p>
                        <p class="text-xs text-gray-500">${fileSize} MB</p>
                    </div>
                </div>
                <button type="button" id="remove-file" class="text-red-500 hover:text-red-700">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        `;
        filePreview.classList.remove('hidden');

        document.getElementById('remove-file').addEventListener('click', () => {
            fileInput.value = ''; // Clear the file input
            filePreview.innerHTML = '';
            filePreview.classList.add('hidden');
        });
    }
});
</script>
@endsection