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
                        <a href="{{ route('berita.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Berita</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-4 text-sm font-medium text-gray-500">{{ $category->nama }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-gray-900">{{ $category->nama }}</h1>
            @if($category->deskripsi)
            <p class="mt-2 text-gray-600">{{ $category->deskripsi }}</p>
            @endif
            <p class="mt-1 text-sm text-gray-500">{{ $berita->total() }} berita ditemukan</p>
        </div>
    </div>
</div>
@endsection

@section('container')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Category Info -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Kategori: {{ $category->nama }}</h2>
                        @if($category->deskripsi)
                        <p class="text-gray-600 mt-1">{{ $category->deskripsi }}</p>
                        @endif
                    </div>
                    <a href="{{ route('berita.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Semua Berita
                    </a>
                </div>
            </div>

            <!-- News Grid -->
            @if($berita->count() > 0)
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                @foreach($berita as $item)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    @if($item->gambar)
                    <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" 
                         class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center text-sm text-gray-500">
                                <span>{{ $item->author->name }}</span>
                                <span class="mx-2">•</span>
                                <span>{{ $item->created_at->format('d M Y') }}</span>
                            </div>
                            @if($item->is_featured)
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                Unggulan
                            </span>
                            @endif
                        </div>
                        
                        <h3 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                            <a href="{{ route('berita.show', $item->slug) }}" class="hover:text-blue-600 transition-colors">
                                {{ $item->judul }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($item->isi), 150) }}
                        </p>
                        
                        <div class="flex items-center justify-between">
                            <a href="{{ route('berita.show', $item->slug) }}" 
                               class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>{{ $item->views ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $berita->links() }}
            </div>
            @else
            <!-- No News Found -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada berita dalam kategori ini</h3>
                <p class="text-gray-600 mb-4">Kategori "{{ $category->nama }}" belum memiliki berita yang dipublikasikan.</p>
                <a href="{{ route('berita.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Semua Berita
                </a>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Other Categories -->
            @if(isset($otherCategories) && $otherCategories->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Kategori Lainnya</h3>
                <div class="space-y-2">
                    @foreach($otherCategories as $otherCategory)
                    <a href="{{ route('berita.category', $otherCategory->slug) }}" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors {{ $otherCategory->id == $category->id ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                        {{ $otherCategory->nama }}
                        <span class="text-xs text-gray-500 ml-1">({{ $otherCategory->berita_count ?? 0 }})</span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Featured News from Other Categories -->
            @if(isset($featuredBerita) && $featuredBerita->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Berita Unggulan</h3>
                <div class="space-y-4">
                    @foreach($featuredBerita as $featured)
                    <article class="flex space-x-3">
                        @if($featured->gambar)
                        <img src="{{ Storage::url($featured->gambar) }}" alt="{{ $featured->judul }}" 
                             class="w-16 h-16 object-cover rounded">
                        @else
                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900 line-clamp-2 mb-1">
                                <a href="{{ route('berita.show', $featured->slug) }}" class="hover:text-blue-600">
                                    {{ $featured->judul }}
                                </a>
                            </h4>
                            <p class="text-xs text-gray-500">{{ $featured->created_at->format('d M Y') }}</p>
                            @if($featured->category)
                            <p class="text-xs text-blue-600">{{ $featured->category->nama }}</p>
                            @endif
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recent News -->
            @if(isset($recentBerita) && $recentBerita->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Berita Terbaru</h3>
                <div class="space-y-4">
                    @foreach($recentBerita as $recent)
                    <article class="flex space-x-3">
                        @if($recent->gambar)
                        <img src="{{ Storage::url($recent->gambar) }}" alt="{{ $recent->judul }}" 
                             class="w-16 h-16 object-cover rounded">
                        @else
                        <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900 line-clamp-2 mb-1">
                                <a href="{{ route('berita.show', $recent->slug) }}" class="hover:text-blue-600">
                                    {{ $recent->judul }}
                                </a>
                            </h4>
                            <p class="text-xs text-gray-500">{{ $recent->created_at->format('d M Y') }}</p>
                            @if($recent->category)
                            <p class="text-xs text-blue-600">{{ $recent->category->nama }}</p>
                            @endif
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection