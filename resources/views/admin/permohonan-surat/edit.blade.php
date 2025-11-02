@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.permohonan-surat.show', $permohonanSurat) }}" class="text-slate-600 hover:text-slate-900">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Permohonan Surat #{{ $permohonanSurat->id }}</h1>
                <p class="text-slate-600 mt-1">Ubah informasi permohonan surat</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Form Edit Permohonan</h3>
        </div>
        
        <form action="{{ route('admin.permohonan-surat.update', $permohonanSurat) }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Pemohon -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-slate-700 mb-2">Pemohon <span class="text-red-500">*</span></label>
                        <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror" required>
                            <option value="">Pilih Pemohon</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $permohonanSurat->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Surat -->
                    <div>
                        <label for="jenis_surat" class="block text-sm font-medium text-slate-700 mb-2">Jenis Surat <span class="text-red-500">*</span></label>
                        <select name="jenis_surat" id="jenis_surat" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_surat') border-red-500 @enderror" required>
                            <option value="">Pilih Jenis Surat</option>
                            <option value="Surat Keterangan Domisili" {{ old('jenis_surat', $permohonanSurat->jenis_surat) == 'Surat Keterangan Domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                            <option value="Surat Keterangan Usaha" {{ old('jenis_surat', $permohonanSurat->jenis_surat) == 'Surat Keterangan Usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                            <option value="Surat Keterangan Tidak Mampu" {{ old('jenis_surat', $permohonanSurat->jenis_surat) == 'Surat Keterangan Tidak Mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                            <option value="Surat Pengantar KTP" {{ old('jenis_surat', $permohonanSurat->jenis_surat) == 'Surat Pengantar KTP' ? 'selected' : '' }}>Surat Pengantar KTP</option>
                            <option value="Surat Pengantar KK" {{ old('jenis_surat', $permohonanSurat->jenis_surat) == 'Surat Pengantar KK' ? 'selected' : '' }}>Surat Pengantar KK</option>
                            <option value="Surat Keterangan Kelahiran" {{ old('jenis_surat', $permohonanSurat->jenis_surat) == 'Surat Keterangan Kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                            <option value="Surat Keterangan Kematian" {{ old('jenis_surat', $permohonanSurat->jenis_surat) == 'Surat Keterangan Kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                            <option value="Surat Keterangan Pindah" {{ old('jenis_surat', $permohonanSurat->jenis_surat) == 'Surat Keterangan Pindah' ? 'selected' : '' }}>Surat Keterangan Pindah</option>
                            <option value="Lainnya" {{ old('jenis_surat', $permohonanSurat->jenis_surat) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('jenis_surat')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                            <option value="pending" {{ old('status', $permohonanSurat->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="diproses" {{ old('status', $permohonanSurat->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ old('status', $permohonanSurat->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="ditolak" {{ old('status', $permohonanSurat->status) == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Selesai -->
                    <div id="tanggal_selesai_container" style="display: {{ old('status', $permohonanSurat->status) == 'selesai' ? 'block' : 'none' }};">
                        <label for="tanggal_selesai" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Selesai</label>
                        <input type="datetime-local" name="tanggal_selesai" id="tanggal_selesai" 
                               value="{{ old('tanggal_selesai', $permohonanSurat->tanggal_selesai ? $permohonanSurat->tanggal_selesai->format('Y-m-d\TH:i') : '') }}" 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_selesai') border-red-500 @enderror">
                        @error('tanggal_selesai')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Keperluan -->
                    <div>
                        <label for="keperluan" class="block text-sm font-medium text-slate-700 mb-2">Keperluan <span class="text-red-500">*</span></label>
                        <textarea name="keperluan" id="keperluan" rows="4" 
                                  class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('keperluan') border-red-500 @enderror" 
                                  placeholder="Jelaskan keperluan surat..." required>{{ old('keperluan', $permohonanSurat->keperluan) }}</textarea>
                        @error('keperluan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan Admin -->
                    <div>
                        <label for="catatan" class="block text-sm font-medium text-slate-700 mb-2">Catatan Admin</label>
                        <textarea name="catatan" id="catatan" rows="4" 
                                  class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('catatan') border-red-500 @enderror" 
                                  placeholder="Tambahkan catatan...">{{ old('catatan', $permohonanSurat->catatan) }}</textarea>
                        @error('catatan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File PDF -->
                    <div>
                        <label for="file_pdf" class="block text-sm font-medium text-slate-700 mb-2">File PDF</label>
                        
                        @if($permohonanSurat->file_pdf)
                        <div class="mb-3 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-file-pdf text-red-500"></i>
                                    <span class="text-sm text-slate-700">File saat ini tersedia</span>
                                </div>
                                <a href="{{ route('admin.permohonan-surat.download', $permohonanSurat) }}" 
                                   class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                            </div>
                        </div>
                        @endif
                        
                        <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('file_pdf') border-red-500 @enderror">
                        <p class="text-xs text-slate-500 mt-1">Upload file PDF (maksimal 5MB). Kosongkan jika tidak ingin mengubah file.</p>
                        @error('file_pdf')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        
                        <!-- File Preview -->
                        <div id="file_preview" class="mt-3 hidden">
                            <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-file-pdf text-red-500"></i>
                                    <span id="file_name" class="text-sm text-slate-700"></span>
                                    <button type="button" id="remove_file" class="text-red-600 hover:text-red-800 text-sm ml-auto">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-4 mt-8 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.permohonan-surat.show', $permohonanSurat) }}" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const tanggalSelesaiContainer = document.getElementById('tanggal_selesai_container');
    const tanggalSelesaiInput = document.getElementById('tanggal_selesai');
    const fileInput = document.getElementById('file_pdf');
    const filePreview = document.getElementById('file_preview');
    const fileName = document.getElementById('file_name');
    const removeFileBtn = document.getElementById('remove_file');

    // Handle status change
    statusSelect.addEventListener('change', function() {
        if (this.value === 'selesai') {
            tanggalSelesaiContainer.style.display = 'block';
            tanggalSelesaiInput.required = true;
            // Set current datetime if empty
            if (!tanggalSelesaiInput.value) {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                const day = String(now.getDate()).padStart(2, '0');
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                tanggalSelesaiInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
            }
        } else {
            tanggalSelesaiContainer.style.display = 'none';
            tanggalSelesaiInput.required = false;
            tanggalSelesaiInput.value = '';
        }
    });

    // Handle file input
    fileInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            // Validate file type
            if (file.type !== 'application/pdf') {
                alert('Hanya file PDF yang diperbolehkan!');
                this.value = '';
                return;
            }
            
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('Ukuran file maksimal 5MB!');
                this.value = '';
                return;
            }
            
            // Show preview
            fileName.textContent = file.name;
            filePreview.classList.remove('hidden');
        } else {
            filePreview.classList.add('hidden');
        }
    });

    // Handle remove file
    removeFileBtn.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.add('hidden');
    });
});
</script>
@endsection