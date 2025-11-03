@extends('layouts.frontend')

@section('title', 'Forum Diskusi')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-3a1 1 0 011-1h2a1 1 0 011 1v3a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Forum Diskusi</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Search & Filter -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Cari Diskusi</h3>
                    
                    <form method="GET" action="{{ route('forum.index') }}" class="space-y-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Kata Kunci</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                   placeholder="Cari judul, isi, atau penulis..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="kategori" id="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Kategori</option>
                                <option value="umum" {{ request('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                                <option value="pembangunan" {{ request('kategori') == 'pembangunan' ? 'selected' : '' }}>Pembangunan</option>
                                <option value="ekonomi" {{ request('kategori') == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                <option value="sosial" {{ request('kategori') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                                <option value="budaya" {{ request('kategori') == 'budaya' ? 'selected' : '' }}>Budaya</option>
                                <option value="lingkungan" {{ request('kategori') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                                <option value="kesehatan" {{ request('kategori') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                <option value="pendidikan" {{ request('kategori') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                            </select>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
                            <select name="sort" id="sort" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="terbaru" {{ $sortBy == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                <option value="terlama" {{ $sortBy == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                <option value="populer" {{ $sortBy == 'populer' ? 'selected' : '' }}>Terpopuler</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari
                        </button>

                        @if(request()->hasAny(['search', 'kategori', 'sort']))
                            <a href="{{ route('forum.index') }}" class="w-full bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300 block text-center">
                                Reset Filter
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Popular Discussions -->
                @if($popularForums->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Diskusi Populer</h3>
                        <div class="space-y-3">
                            @foreach($popularForums as $popular)
                                <div class="border-b border-gray-200 pb-3 last:border-b-0 last:pb-0">
                                    <a href="{{ route('forum.show', $popular->id) }}" class="block hover:text-blue-600 transition duration-300">
                                        <h4 class="text-sm font-medium text-gray-900 mb-1 line-clamp-2">{{ $popular->judul }}</h4>
                                        <div class="flex items-center text-xs text-gray-500 space-x-3">
                                            <span>{{ $popular->komentars_count }} komentar</span>
                                            <span>{{ $popular->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Recent Discussions -->
                @if($recentForums->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Diskusi Terbaru</h3>
                        <div class="space-y-3">
                            @foreach($recentForums as $recent)
                                <div class="border-b border-gray-200 pb-3 last:border-b-0 last:pb-0">
                                    <a href="{{ route('forum.show', $recent->id) }}" class="block hover:text-blue-600 transition duration-300">
                                        <h4 class="text-sm font-medium text-gray-900 mb-1 line-clamp-2">{{ $recent->judul }}</h4>
                                        <div class="flex items-center text-xs text-gray-500 space-x-3">
                                            <span>{{ $recent->user->name }}</span>
                                            <span>{{ $recent->created_at->diffForHumans() }}</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Header -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Forum Diskusi</h1>
                            <p class="text-gray-600 mt-1">Diskusikan berbagai topik dengan warga desa</p>
                        </div>
                        <div class="mt-4 sm:mt-0 flex flex-col sm:flex-row gap-3">
                            @auth
                                <a href="{{ route('forum.my-discussions') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-md hover:bg-gray-700 transition duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Diskusi Saya
                                </a>
                                <a href="{{ route('forum.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Buat Diskusi
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                    </svg>
                                    Login untuk Diskusi
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Forum Discussions -->
                @if($forums->count() > 0)
                    <div class="space-y-4">
                        @foreach($forums as $forum)
                            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            @if($forum->kategori)
                                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full mr-2">
                                                    {{ ucfirst($forum->kategori) }}
                                                </span>
                                            @endif
                                            <span class="text-sm text-gray-500">{{ $forum->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <h2 class="text-xl font-semibold text-gray-900 mb-2">
                                            <a href="{{ route('forum.show', $forum->id) }}" class="hover:text-blue-600 transition duration-300">
                                                {{ $forum->judul }}
                                            </a>
                                        </h2>
                                        
                                        <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit(strip_tags($forum->isi), 200) }}</p>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                    </svg>
                                                    {{ $forum->user->name }}
                                                </div>
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                                    </svg>
                                                    {{ $forum->komentars_count ?? 0 }} komentar
                                                </div>
                                                @if(isset($forum->views))
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                        </svg>
                                                        {{ $forum->views }} views
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <a href="{{ route('forum.show', $forum->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition duration-300">
                                                Baca Selengkapnya
                                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $forums->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Diskusi</h3>
                        <p class="text-gray-600 mb-6">
                            @if(request()->hasAny(['search', 'kategori']))
                                Tidak ada diskusi yang sesuai dengan filter Anda.
                            @else
                                Belum ada diskusi yang dibuat. Jadilah yang pertama memulai diskusi!
                            @endif
                        </p>
                        @auth
                            <a href="{{ route('forum.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Buat Diskusi Pertama
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013 3v1"></path>
                                </svg>
                                Login untuk Berdiskusi
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection