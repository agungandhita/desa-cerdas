@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.permohonan-surat.index') }}" class="text-slate-600 hover:text-slate-900">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah Permohonan Surat</h1>
                <p class="text-slate-600 mt-1">Buat permohonan surat baru untuk warga</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">Informasi Permohonan</h3>
        </div>

        <form action="{{ route('admin.permohonan-surat.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Pemohon -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-slate-700 mb-2">
                        Pemohon <span class="text-red-500">*</span>
                    </label>
                    <select name="user_id" id="user_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('user_id') border-red-500 @enderror" required>
                        <option value="">Pilih Pemohon</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
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
                    <label for="jenis_surat" class="block text-sm font-medium text-slate-700 mb-2">
                        Jenis Surat <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_surat" id="jenis_surat" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_surat') border-red-500 @enderror" required>
                        <option value="">Pilih Jenis Surat</option>
                        @foreach($jenisSurat as $jenis)
                        <option value="{{ $jenis }}" {{ old('jenis_surat') == $jenis ? 'selected' : '' }}>
                            {{ $jenis }}
                        </option>
                        @endforeach
                    </select>
                    @error('jenis_surat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diproses" {{ old('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                    @error('status')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Selesai -->
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-slate-700 mb-2">
                        Tanggal Selesai
                    </label>
                    <input type="datetime-local" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_selesai') border-red-500 @enderror">
                    @error('tanggal_selesai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-slate-500 mt-1">Kosongkan jika belum selesai</p>
                </div>
            </div>

            <!-- Keperluan -->
            <div class="mt-6">
                <label for="keperluan" class="block text-sm font-medium text-slate-700 mb-2">
                    Keperluan <span class="text-red-500">*</span>
                </label>
                <textarea name="keperluan" id="keperluan" rows="4" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('keperluan') border-red-500 @enderror" placeholder="Jelaskan keperluan surat..." required>{{ old('keperluan') }}</textarea>
                @error('keperluan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Catatan -->
            <div class="mt-6">
                <label for="catatan" class="block text-sm font-medium text-slate-700 mb-2">
                    Catatan Admin
                </label>
                <textarea name="catatan" id="catatan" rows="3" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('catatan') border-red-500 @enderror" placeholder="Catatan dari admin...">{{ old('catatan') }}</textarea>
                @error('catatan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- File PDF -->
            <div class="mt-6">
                <label for="file_pdf" class="block text-sm font-medium text-slate-700 mb-2">
                    File PDF Surat
                </label>
                <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center">
                    <input type="file" name="file_pdf" id="file_pdf" accept=".pdf" class="hidden" onchange="updateFileName(this)">
                    <div id="file-upload-area" class="cursor-pointer" onclick="document.getElementById('file_pdf').click()">
                        <i class="fas fa-cloud-upload-alt text-4xl text-slate-400 mb-4"></i>
                        <p class="text-lg font-medium text-slate-700">Klik untuk upload file PDF</p>
                        <p class="text-sm text-slate-500">Maksimal 2MB, format PDF</p>
                    </div>
                    <div id="file-info" class="hidden">
                        <i class="fas fa-file-pdf text-4xl text-red-500 mb-4"></i>
                        <p class="text-lg font-medium text-slate-700" id="file-name"></p>
                        <button type="button" onclick="removeFile()" class="text-sm text-red-600 hover:text-red-800 mt-2">
                            <i class="fas fa-trash mr-1"></i>Hapus File
                        </button>
                    </div>
                </div>
                @error('file_pdf')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.permohonan-surat.index') }}" class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan Permohonan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateFileName(input) {
    const fileInfo = document.getElementById('file-info');
    const fileUploadArea = document.getElementById('file-upload-area');
    const fileName = document.getElementById('file-name');
    
    if (input.files && input.files[0]) {
        fileName.textContent = input.files[0].name;
        fileUploadArea.classList.add('hidden');
        fileInfo.classList.remove('hidden');
    }
}

function removeFile() {
    const fileInput = document.getElementById('file_pdf');
    const fileInfo = document.getElementById('file-info');
    const fileUploadArea = document.getElementById('file-upload-area');
    
    fileInput.value = '';
    fileInfo.classList.add('hidden');
    fileUploadArea.classList.remove('hidden');
}

// Auto-hide tanggal selesai field based on status
document.getElementById('status').addEventListener('change', function() {
    const tanggalSelesaiField = document.getElementById('tanggal_selesai').parentElement;
    
    if (this.value === 'selesai') {
        tanggalSelesaiField.style.display = 'block';
        if (!document.getElementById('tanggal_selesai').value) {
            document.getElementById('tanggal_selesai').value = new Date().toISOString().slice(0, 16);
        }
    } else {
        document.getElementById('tanggal_selesai').value = '';
    }
});
</script>
@endsection