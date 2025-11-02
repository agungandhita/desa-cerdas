@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.forum.index') }}" class="text-slate-600 hover:text-slate-800 transition-colors duration-200">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Buat Forum Baru</h1>
                <p class="text-slate-600 mt-1">Buat topik diskusi baru untuk warga</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="p-6">
            <form action="{{ route('admin.forum.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Content -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Judul -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-slate-700 mb-2">
                                Judul Forum <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="judul" 
                                   name="judul" 
                                   value="{{ old('judul') }}"
                                   class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('judul') border-red-500 @enderror"
                                   placeholder="Masukkan judul forum yang menarik..."
                                   required>
                            @error('judul')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Isi -->
                        <div>
                            <label for="isi" class="block text-sm font-medium text-slate-700 mb-2">
                                Isi Forum <span class="text-red-500">*</span>
                            </label>
                            <textarea id="isi" 
                                      name="isi" 
                                      rows="12"
                                      class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('isi') border-red-500 @enderror"
                                      placeholder="Tulis isi forum atau topik diskusi..."
                                      required>{{ old('isi') }}</textarea>
                            @error('isi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Kategori -->
                        <div class="bg-slate-50 p-4 rounded-lg">
                            <label for="kategori" class="block text-sm font-medium text-slate-700 mb-2">
                                Kategori <span class="text-red-500">*</span>
                            </label>
                            <select id="kategori" 
                                    name="kategori" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kategori') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                                        {{ ucfirst($kategori) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="bg-slate-50 p-4 rounded-lg">
                            <label for="status" class="block text-sm font-medium text-slate-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select id="status" 
                                    name="status" 
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror"
                                    required>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Tertutup</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Pin Forum -->
                        <div class="bg-slate-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="is_pinned" 
                                       name="is_pinned" 
                                       value="1"
                                       {{ old('is_pinned') ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="is_pinned" class="ml-2 text-sm font-medium text-slate-700">
                                    Pin forum ini
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-slate-500">Forum yang di-pin akan muncul di bagian atas</p>
                        </div>

                        <!-- Actions -->
                        <div class="bg-slate-50 p-4 rounded-lg">
                            <div class="flex flex-col gap-3">
                                <button type="submit" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-save"></i>
                                    Simpan Forum
                                </button>
                                <a href="{{ route('admin.forum.index') }}" 
                                   class="w-full bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-times"></i>
                                    Batal
                                </a>
                            </div>
                        </div>

                        <!-- Tips -->
                        <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                            <h4 class="text-sm font-semibold text-blue-800 mb-2">
                                <i class="fas fa-lightbulb mr-1"></i>
                                Tips Membuat Forum
                            </h4>
                            <ul class="text-xs text-blue-700 space-y-1">
                                <li>• Gunakan judul yang jelas dan menarik</li>
                                <li>• Pilih kategori yang sesuai</li>
                                <li>• Tulis isi yang informatif dan mudah dipahami</li>
                                <li>• Pin forum penting agar mudah ditemukan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-resize textarea
    document.getElementById('isi').addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
</script>
@endpush
@endsection