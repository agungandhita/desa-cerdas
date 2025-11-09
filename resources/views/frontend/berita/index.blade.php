@extends('frontend.layouts.main')

@section('container')
<!-- Hero Section (match theme from Tentang page) -->
<section class="relative h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px] xl:h-[500px] flex items-center justify-center text-center text-white" style="background-image: url('https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class="relative z-10 p-4">
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight leading-tight mb-2">Berita Desa</h1>
        <p class="text-base sm:text-lg md:text-xl lg:text-2xl font-light max-w-3xl mx-auto">Ikuti berita dan informasi terkini dari desa kami.</p>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid lg:grid-cols-4 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Search and Filter Section -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <form method="GET" action="{{ route('berita.index') }}" class="space-y-4">
                    <div class="grid md:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div class="md:col-span-2">
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Berita</label>
                            <div class="relative">
                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
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
                            <select id="featured" name="featured" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">Semua Berita</option>
                                <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Berita Unggulan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-3 gap-4">
                        <!-- Month Filter -->
                        <div>
                            <label for="bulan" class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                            <select id="bulan" name="bulan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
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
                            <select id="tahun" name="tahun" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                <option value="">Semua Tahun</option>
                                @for($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
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
                <article class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300 ease-in-out group flex flex-col">
                    <div class="relative">
                        <img src="{{ $item->cover ? Storage::url($item->cover) : 'https://images.unsplash.com/photo-1502082553048-f009c37129b9?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3' }}" alt="{{ $item->judul }}"
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-black bg-opacity-20 group-hover:bg-opacity-30 transition-opacity"></div>
                        @if($item->is_featured)
                        <span class="absolute top-4 right-4 bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Unggulan</span>
                        @endif
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>{{ $item->author->name }}</span>
                            <span class="mx-2 text-gray-300">|</span>
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>{{ $item->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="flex-grow">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">
                                <a href="{{ route('berita.show', $item->slug) }}" class="hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $item->judul }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ Str::limit(strip_tags($item->isi), 120) }}
                            </p>
                        </div>

                        <div class="mt-auto pt-4 border-t border-gray-100">
                            <a href="{{ route('berita.show', $item->slug) }}"
                               class="inline-flex items-center justify-center w-full px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-12 pt-8 border-t border-gray-200">
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
        <div class="lg:col-span-1 space-y-8">
            <!-- Categories -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b-2 pb-2">Kategori</h3>
                <ul class="space-y-2">
                    @forelse($categories as $category)
                    <li>
                        <a href="{{ route('berita.index', ['kategori' => $category->slug]) }}"
                           class="flex justify-between items-center text-gray-700 hover:text-blue-600 hover:bg-gray-50 p-2 rounded-lg transition-colors">
                            <span>{{ $category->nama }}</span>
                            <span class="text-sm font-semibold text-gray-500">{{ $category->beritas_count }}</span>
                        </a>
                    </li>
                    @empty
                    <li class="text-gray-500">Tidak ada kategori.</li>
                    @endforelse
                </ul>
            </div>
            <!-- Recent News -->
            @if($recentBerita->count() > 0)
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b-2 pb-2">Berita Terbaru</h3>
                <ul class="space-y-4">
                    @forelse($recentBerita as $recent)
                    <li class="flex items-start space-x-4 hover:bg-gray-50 p-2 rounded-lg transition-colors">
                        <a href="{{ route('berita.show', $recent->slug) }}" class="flex-shrink-0">
                            @if($recent->cover)
                            <img src="{{ Storage::url($recent->cover) }}" alt="{{ $recent->judul }}"
                                 class="w-20 h-20 object-cover rounded-md">
                            @else
                            <img src="https://images.unsplash.com/photo-1495020689067-958852a7765e?q=80&w=800&auto=format&fit=crop&ixlib=rb-4.0.3" alt="Placeholder"
                                 class="w-20 h-20 object-cover rounded-md">
                            @endif
                        </a>
                        <div class="flex-grow">
                            <a href="{{ route('berita.show', $recent->slug) }}" class="text-gray-800 font-semibold hover:text-blue-600 transition-colors block line-clamp-2">
                                {{ $recent->judul }}
                            </a>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $recent->created_at->format('d M Y') }}
                            </p>
                        </div>
                    </li>
                    @empty
                    <li class="text-gray-500">Tidak ada berita terbaru.</li>
                    @endforelse
                </ul>
            </div>
            @endif

            <!-- Tags -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4 border-b-2 pb-2">Tag</h3>
                <div class="flex flex-wrap gap-2">
                    @forelse($tags as $tag)
                    <a href="{{ route('berita.index', ['tag' => $tag->slug]) }}"
                       class="bg-gray-100 text-gray-700 text-sm font-medium px-3 py-1 rounded-full hover:bg-blue-100 hover:text-blue-700 transition-colors">
                        #{{ $tag->nama }}
                    </a>
                    @empty
                    <p class="text-gray-500">Tidak ada tag.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
