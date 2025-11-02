@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.berita.index') }}" class="text-slate-600 hover:text-slate-900">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Detail Berita</h1>
                    <p class="text-slate-600 mt-1">Informasi lengkap berita</p>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex items-center gap-3">
                <!-- Status Badge -->
                @if($berita->status == 'published')
                    <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                        <i class="fas fa-check-circle mr-1"></i>
                        Published
                    </span>
                @else
                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-medium rounded-full">
                        <i class="fas fa-clock mr-1"></i>
                        Draft
                    </span>
                @endif

                @if($berita->is_featured)
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                        <i class="fas fa-star mr-1"></i>
                        Featured
                    </span>
                @endif

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.berita.edit', $berita) }}" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    
                    <!-- Toggle Featured -->
                    <form action="{{ route('admin.berita.toggleFeatured', $berita) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                            class="px-4 py-2 {{ $berita->is_featured ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-gray-600 hover:bg-gray-700' }} text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                            <i class="fas fa-star"></i>
                            {{ $berita->is_featured ? 'Unfeature' : 'Feature' }}
                        </button>
                    </form>

                    <!-- Status Toggle -->
                    <form action="{{ route('admin.berita.updateStatus', $berita) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $berita->status == 'published' ? 'draft' : 'published' }}">
                        <button type="submit" 
                            class="px-4 py-2 {{ $berita->status == 'published' ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                            <i class="fas fa-{{ $berita->status == 'published' ? 'eye-slash' : 'eye' }}"></i>
                            {{ $berita->status == 'published' ? 'Unpublish' : 'Publish' }}
                        </button>
                    </form>

                    <!-- Delete -->
                    <form action="{{ route('admin.berita.destroy', $berita) }}" method="POST" class="inline" 
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors duration-200 flex items-center gap-2">
                            <i class="fas fa-trash"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Article Content -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 overflow-hidden">
                <!-- Cover Image -->
                @if($berita->cover)
                <div class="aspect-video bg-slate-100">
                    <img src="{{ Storage::url($berita->cover) }}" alt="{{ $berita->judul }}" 
                        class="w-full h-full object-cover">
                </div>
                @endif

                <div class="p-6">
                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-slate-900 mb-4">{{ $berita->judul }}</h1>
                    
                    <!-- Meta Info -->
                    <div class="flex items-center gap-4 text-sm text-slate-600 mb-6 pb-6 border-b border-slate-200">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user"></i>
                            <span>{{ $berita->author->name }}</span>
                        </div>
                        @if($berita->published_at)
                        <div class="flex items-center gap-2">
                            <i class="fas fa-calendar"></i>
                            <span>{{ $berita->published_at->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                        <div class="flex items-center gap-2">
                            <i class="fas fa-eye"></i>
                            <span>{{ number_format($berita->views) }} views</span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="prose prose-slate max-w-none">
                        {!! $berita->isi !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Info -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Informasi Berita</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Status:</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $berita->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($berita->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Featured:</span>
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $berita->is_featured ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $berita->is_featured ? 'Ya' : 'Tidak' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Penulis:</span>
                        <span class="text-slate-900 font-medium">{{ $berita->author->name }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Dibuat:</span>
                        <span class="text-slate-900">{{ $berita->created_at->format('d M Y') }}</span>
                    </div>
                    @if($berita->published_at)
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Dipublikasi:</span>
                        <span class="text-slate-900">{{ $berita->published_at->format('d M Y') }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center">
                        <span class="text-slate-600">Views:</span>
                        <span class="text-slate-900 font-medium">{{ number_format($berita->views) }}</span>
                    </div>
                </div>
            </div>

            <!-- SEO Info -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">SEO Information</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-slate-600">Slug:</label>
                        <p class="text-sm text-slate-900 bg-slate-50 p-2 rounded mt-1 font-mono">{{ $berita->slug }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600">Excerpt:</label>
                        <p class="text-sm text-slate-700 mt-1">{{ $berita->excerpt }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-slate-600">Character Count:</label>
                        <p class="text-sm text-slate-900 mt-1">{{ strlen($berita->isi) }} karakter</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
                <h3 class="text-lg font-semibold text-slate-900 mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.berita.edit', $berita) }}" 
                        class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-edit"></i>
                        Edit Berita
                    </a>
                    
                    <form action="{{ route('admin.berita.toggleFeatured', $berita) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                            class="w-full px-4 py-2 {{ $berita->is_featured ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-gray-600 hover:bg-gray-700' }} text-white rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-star"></i>
                            {{ $berita->is_featured ? 'Remove from Featured' : 'Set as Featured' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.berita.updateStatus', $berita) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="{{ $berita->status == 'published' ? 'draft' : 'published' }}">
                        <button type="submit" 
                            class="w-full px-4 py-2 {{ $berita->status == 'published' ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                            <i class="fas fa-{{ $berita->status == 'published' ? 'eye-slash' : 'eye' }}"></i>
                            {{ $berita->status == 'published' ? 'Unpublish' : 'Publish Now' }}
                        </button>
                    </form>

                    <button onclick="copyToClipboard('{{ $berita->slug }}')" 
                        class="w-full px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200 flex items-center justify-center gap-2">
                        <i class="fas fa-copy"></i>
                        Copy Slug
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        toast.textContent = 'Slug copied to clipboard!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 3000);
    });
}
</script>
@endpush
@endsection