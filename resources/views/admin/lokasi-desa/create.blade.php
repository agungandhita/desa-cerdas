@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.lokasi-desa.index') }}" class="text-slate-600 hover:text-slate-800">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah Lokasi Desa</h1>
                <p class="text-slate-600 mt-1">Tambahkan lokasi atau tempat penting di desa</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <form action="{{ route('admin.lokasi-desa.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Nama -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-slate-700 mb-2">
                            Nama Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama" id="nama" value="{{ old('nama') }}" 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror"
                               placeholder="Masukkan nama lokasi" required>
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-slate-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori" id="kategori" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kategori') border-red-500 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $key => $value)
                                <option value="{{ $key }}" {{ old('kategori') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-medium text-slate-700 mb-2">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat" id="alamat" rows="3" 
                                  class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror"
                                  placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Koordinat -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-slate-700 mb-2">
                                Latitude
                            </label>
                            <input type="number" name="latitude" id="latitude" value="{{ old('latitude') }}" 
                                   step="any" min="-90" max="90"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('latitude') border-red-500 @enderror"
                                   placeholder="Contoh: -6.200000">
                            @error('latitude')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="longitude" class="block text-sm font-medium text-slate-700 mb-2">
                                Longitude
                            </label>
                            <input type="number" name="longitude" id="longitude" value="{{ old('longitude') }}" 
                                   step="any" min="-180" max="180"
                                   class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('longitude') border-red-500 @enderror"
                                   placeholder="Contoh: 106.816666">
                            @error('longitude')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <div class="flex items-center gap-3">
                                <button type="button" id="btnGetLocation" 
                                        class="inline-flex items-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-location-arrow mr-2"></i>
                                    Gunakan lokasi perangkat
                                </button>
                                <span id="geoStatus" class="text-sm text-slate-600"></span>
                            </div>
                            <p class="text-xs text-slate-500 mt-2">Pastikan GPS aktif dan izinkan akses lokasi di browser.</p>
                        </div>
                    </div>

                    <!-- Kontak -->
                    <div>
                        <label for="kontak" class="block text-sm font-medium text-slate-700 mb-2">
                            Kontak
                        </label>
                        <input type="text" name="kontak" id="kontak" value="{{ old('kontak') }}" 
                               class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kontak') border-red-500 @enderror"
                               placeholder="Nomor telepon atau email">
                        @error('kontak')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="deskripsi" id="deskripsi" rows="5" 
                                  class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror"
                                  placeholder="Masukkan deskripsi lokasi">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" 
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto -->
                    <div>
                        <label for="foto" class="block text-sm font-medium text-slate-700 mb-2">
                            Foto Lokasi
                        </label>
                        <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-slate-400 transition-colors">
                            <input type="file" name="foto[]" id="foto" multiple accept="image/*" 
                                   class="hidden" onchange="previewImages(this)">
                            <label for="foto" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-3xl text-slate-400 mb-2"></i>
                                <p class="text-slate-600">Klik untuk upload foto</p>
                                <p class="text-sm text-slate-500 mt-1">Maksimal 2MB per file, format: JPG, PNG, GIF</p>
                                <p class="text-sm text-slate-500">Anda dapat memilih beberapa foto sekaligus</p>
                            </label>
                        </div>
                        @error('foto.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Preview Images -->
                        <div id="imagePreview" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4 hidden"></div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-4 mt-8 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.lokasi-desa.index') }}" 
                   class="px-6 py-2 border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    Simpan Lokasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImages(input) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (input.files && input.files.length > 0) {
        preview.classList.remove('hidden');
        
        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-slate-200">
                        <div class="absolute top-1 right-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                            ${index + 1}
                        </div>
                    `;
                    preview.appendChild(div);
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        preview.classList.add('hidden');
    }
}

// Geolocation: isi latitude/longitude dari perangkat
document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('btnGetLocation');
    const latInput = document.getElementById('latitude');
    const lngInput = document.getElementById('longitude');
    const statusEl = document.getElementById('geoStatus');

    if (btn) {
        btn.addEventListener('click', () => {
            if (!('geolocation' in navigator)) {
                statusEl.textContent = 'Perangkat tidak mendukung GPS/geolocation.';
                statusEl.className = 'text-sm text-red-600';
                return;
            }

            statusEl.textContent = 'Mengambil lokasi perangkat…';
            statusEl.className = 'text-sm text-slate-600';
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');

            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const { latitude, longitude, accuracy } = pos.coords;
                    // Simpan dengan 6 digit desimal
                    latInput.value = Number(latitude).toFixed(6);
                    lngInput.value = Number(longitude).toFixed(6);
                    statusEl.textContent = `Koordinat diambil (akurasi ±${Math.round(accuracy)}m).`;
                    statusEl.className = 'text-sm text-green-600';
                    btn.disabled = false;
                    btn.classList.remove('opacity-70', 'cursor-not-allowed');
                },
                (err) => {
                    let msg = 'Gagal mengambil lokasi.';
                    if (err.code === 1) msg = 'Akses lokasi ditolak. Izinkan lokasi di browser.';
                    else if (err.code === 2) msg = 'Lokasi tidak tersedia. Coba aktifkan GPS.';
                    else if (err.code === 3) msg = 'Permintaan lokasi kedaluwarsa. Coba lagi.';
                    statusEl.textContent = msg;
                    statusEl.className = 'text-sm text-red-600';
                    btn.disabled = false;
                    btn.classList.remove('opacity-70', 'cursor-not-allowed');
                },
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
            );
        });
    }
});
</script>
@endsection