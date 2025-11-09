@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.lokasi-desa.index') }}" class="text-slate-600 hover:text-slate-800">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">{{ $lokasiDesa->nama }}</h1>
                    <p class="text-slate-600 mt-1">Detail informasi lokasi desa</p>
                </div>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.lokasi-desa.edit', $lokasiDesa) }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <form action="{{ route('admin.lokasi-desa.destroy', $lokasiDesa) }}" method="POST" class="inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus lokasi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Informasi Dasar</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Nama Lokasi</label>
                        <p class="text-slate-800 font-medium">{{ $lokasiDesa->nama }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Kategori</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $lokasiDesa->kategori_label }}
                        </span>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-600 mb-1">Alamat</label>
                        <p class="text-slate-800">{{ $lokasiDesa->alamat }}</p>
                    </div>
                    @if($lokasiDesa->kontak)
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Kontak</label>
                            <p class="text-slate-800">{{ $lokasiDesa->kontak }}</p>
                        </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Status</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $lokasiDesa->status_badge_class }}">
                            {{ $lokasiDesa->status_label }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($lokasiDesa->deskripsi)
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Deskripsi</h2>
                    <div class="prose prose-slate max-w-none">
                        <p class="text-slate-700 leading-relaxed">{{ $lokasiDesa->deskripsi }}</p>
                    </div>
                </div>
            @endif

            <!-- Photos -->
            @if($lokasiDesa->foto && is_array($lokasiDesa->foto) && count($lokasiDesa->foto) > 0)
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-semibold text-slate-800 mb-4">Foto Lokasi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($lokasiDesa->foto as $index => $foto)
                            <div class="relative group cursor-pointer" onclick="openImageModal('{{ asset('storage/' . $foto) }}', '{{ $lokasiDesa->nama }} - Foto {{ $index + 1 }}')">
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto {{ $index + 1 }}" 
                                     class="w-full h-48 object-cover rounded-lg border border-slate-200 hover:shadow-lg transition-shadow duration-200">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white text-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200"></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Coordinates -->
            @if($lokasiDesa->hasCoordinates())
                <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-semibold text-slate-800 mb-4">Koordinat</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Latitude</label>
                            <p class="text-slate-800 font-mono">{{ $lokasiDesa->latitude }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Longitude</label>
                            <p class="text-slate-800 font-mono">{{ $lokasiDesa->longitude }}</p>
                        </div>
                        <div class="pt-3 border-t border-slate-200">
                            <a href="https://www.google.com/maps?q={{ $lokasiDesa->latitude }},{{ $lokasiDesa->longitude }}" 
                               target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 w-full justify-center">
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                Lihat di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Metadata -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Informasi Sistem</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <label class="block text-slate-600 mb-1">Dibuat</label>
                        <p class="text-slate-800">{{ $lokasiDesa->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-slate-600 mb-1">Terakhir Diperbarui</label>
                        <p class="text-slate-800">{{ $lokasiDesa->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-800 mb-4">Aksi Cepat</h3>
                <div class="space-y-3">
                    <form action="{{ route('admin.lokasi-desa.updateStatus', $lokasiDesa) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $lokasiDesa->status === 'active' ? 'inactive' : 'active' }}">
                        <button type="submit" 
                                class="w-full px-4 py-2 {{ $lokasiDesa->status === 'active' ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-colors duration-200">
                            <i class="fas fa-{{ $lokasiDesa->status === 'active' ? 'pause' : 'play' }} mr-2"></i>
                            {{ $lokasiDesa->status === 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
            <i class="fas fa-times text-2xl"></i>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain rounded-lg">
        <div class="absolute bottom-4 left-4 right-4 text-center">
            <p id="modalCaption" class="text-white text-lg font-medium bg-black bg-opacity-50 px-4 py-2 rounded-lg"></p>
        </div>
    </div>
</div>

<script>
function openImageModal(src, caption) {
    document.getElementById('modalImage').src = src;
    document.getElementById('modalCaption').textContent = caption;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal when clicking outside the image
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection