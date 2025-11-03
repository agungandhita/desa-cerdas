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
                        <span class="ml-4 text-sm font-medium text-gray-500">Berita</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-gray-900">Berita Desa</h1>
            <p class="mt-2 text-gray-600">Informasi terkini dan berita terbaru dari desa</p>
        </div>
    </div>
</div>
@endsection

@section('container')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Search and Filter Section -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <form method="GET" action="{{ route('berita.index') }}" class="space-y-4">
                    <div class="grid md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Berita</label>
                            <div class="relative">
                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Cari berdasarkan judul, isi, atau penulis...">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Featured Filter -->
                        <div>
                            <label for="featured" class="block text-sm font-medium text-gray-700 mb-2">Filter</label>
                            <select id="featured" name="featured" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Berita</option>
                                <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Berita Unggulan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-3 gap-4">
                        <!-- Month Filter -->
                        <div>
                            <label for="bulan" class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                            <select id="bulan" name="bulan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Bulan</option>
                                @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                                @endfor
                            </select>
                        </div>
                        
                        <!-- Year Filter -->
                        <div>
                            <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                            <select id="tahun" name="tahun" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Tahun</option>
                                @for($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
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
                        
                        <a href="{{ route('berita.show', $item->slug) }}" 
                           class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            Baca Selengkapnya
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $berita->appends(request()->query())->links() }}
            </div>
            @else
            <!-- No News Found -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada berita ditemukan</h3>
                <p class="text-gray-600 mb-4">Coba ubah filter pencarian atau kata kunci Anda.</p>
                <a href="{{ route('berita.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Semua Berita
                </a>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Featured News -->
            @if($featuredBerita->count() > 0)
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
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recent News -->
            @if($recentBerita->count() > 0)
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