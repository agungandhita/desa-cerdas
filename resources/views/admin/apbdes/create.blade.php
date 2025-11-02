@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.apbdes.index') }}" 
               class="text-slate-600 hover:text-slate-800 transition-colors duration-200">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Tambah APB Desa</h1>
                <p class="text-slate-600 mt-1">Tambahkan data anggaran pendapatan dan belanja desa baru</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Informasi APB Desa</h2>
        </div>

        <form action="{{ route('admin.apbdes.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tahun -->
                <div>
                    <label for="tahun" class="block text-sm font-medium text-slate-700 mb-2">
                        Tahun <span class="text-red-500">*</span>
                    </label>
                    <select name="tahun" id="tahun" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tahun') border-red-500 @enderror">
                        <option value="">Pilih Tahun</option>
                        @for($year = 2020; $year <= 2030; $year++)
                            <option value="{{ $year }}" {{ old('tahun') == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>
                    @error('tahun')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                        <option value="">Pilih Status</option>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bidang -->
                <div class="md:col-span-2">
                    <label for="bidang" class="block text-sm font-medium text-slate-700 mb-2">
                        Bidang <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="bidang" id="bidang" required
                           value="{{ old('bidang') }}"
                           placeholder="Contoh: Penyelenggaraan Pemerintahan Desa"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('bidang') border-red-500 @enderror">
                    @error('bidang')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah Anggaran -->
                <div>
                    <label for="jumlah_anggaran" class="block text-sm font-medium text-slate-700 mb-2">
                        Jumlah Anggaran <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-slate-500">Rp</span>
                        <input type="number" name="jumlah_anggaran" id="jumlah_anggaran" required
                               value="{{ old('jumlah_anggaran') }}"
                               placeholder="0"
                               min="0"
                               step="0.01"
                               class="w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jumlah_anggaran') border-red-500 @enderror">
                    </div>
                    @error('jumlah_anggaran')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Realisasi -->
                <div>
                    <label for="realisasi" class="block text-sm font-medium text-slate-700 mb-2">
                        Realisasi
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-slate-500">Rp</span>
                        <input type="number" name="realisasi" id="realisasi"
                               value="{{ old('realisasi') }}"
                               placeholder="0"
                               min="0"
                               step="0.01"
                               class="w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('realisasi') border-red-500 @enderror">
                    </div>
                    @error('realisasi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div class="md:col-span-2">
                    <label for="deskripsi" class="block text-sm font-medium text-slate-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              placeholder="Deskripsi detail tentang anggaran ini..."
                              class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-200">
                <a href="{{ route('admin.apbdes.index') }}" 
                   class="px-4 py-2 text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Format number inputs
    const numberInputs = document.querySelectorAll('input[type="number"]');
    numberInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Remove any non-numeric characters except decimal point
            this.value = this.value.replace(/[^0-9.]/g, '');
        });
    });
});
</script>
@endsection