@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.forum.show', $forum) }}" class="text-slate-600 hover:text-slate-800 transition-colors duration-200">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Edit Forum</h1>
                <p class="text-slate-600 mt-1">Perbarui informasi forum diskusi</p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="p-6">
            <form action="{{ route('admin.forum.update', $forum) }}" method="POST">
                @csrf
                @method('PUT')
                
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
                                   value="{{ old('judul', $forum->judul) }}"
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
                                      required>{{ old('isi', $forum->isi) }}</textarea>
                            @error('isi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Forum Info -->
                        <div class="bg-slate-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-slate-700 mb-3">Informasi Forum</h4>
                            <div class="space-y-2 text-sm text-slate-600">
                                <div class="flex justify-between">
                                    <span>Dibuat oleh:</span>
                                    <span class="font-medium">{{ $forum->user->name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Tanggal:</span>
                                    <span>{{ $forum->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Views:</span>
                                    <span>{{ $forum->views }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Komentar:</span>
                                    <span>{{ $forum->jumlah_komentar }}</span>
                                </div>
                            </div>
                        </div>

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
                                    <option value="{{ $kategori }}" {{ old('kategori', $forum->kategori) == $kategori ? 'selected' : '' }}>
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
                                <option value="active" {{ old('status', $forum->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="pending" {{ old('status', $forum->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="closed" {{ old('status', $forum->status) == 'closed' ? 'selected' : '' }}>Tertutup</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-slate-500">
                                @if($forum->status == 'active')
                                    Forum ini sedang aktif dan dapat dikomentari
                                @elseif($forum->status == 'closed')
                                    Forum ini ditutup, tidak dapat dikomentari
                                @else
                                    Forum ini menunggu persetujuan
                                @endif
                            </p>
                        </div>

                        <!-- Pin Forum -->
                        <div class="bg-slate-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="is_pinned" 
                                       name="is_pinned" 
                                       value="1"
                                       {{ old('is_pinned', $forum->is_pinned) ? 'checked' : '' }}
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
                                    Perbarui Forum
                                </button>
                                <a href="{{ route('admin.forum.show', $forum) }}" 
                                   class="w-full bg-slate-500 hover:bg-slate-600 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                                    <i class="fas fa-times"></i>
                                    Batal
                                </a>
                            </div>
                        </div>

                        <!-- Danger Zone -->
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <h4 class="text-sm font-semibold text-red-800 mb-2">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Zona Berbahaya
                            </h4>
                            <p class="text-xs text-red-700 mb-3">
                                Tindakan ini tidak dapat dibatalkan. Semua komentar akan ikut terhapus.
                            </p>
                            <form action="{{ route('admin.forum.destroy', $forum) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus forum ini? Semua komentar akan ikut terhapus dan tindakan ini tidak dapat dibatalkan.')">
                                    <i class="fas fa-trash"></i>
                                    Hapus Forum
                                </button>
                            </form>
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

    // Set initial height
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('isi');
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    });
</script>
@endpush
@endsection