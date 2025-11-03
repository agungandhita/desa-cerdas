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
                        <a href="{{ route('umkm.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">UMKM</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-4 text-sm font-medium text-gray-500">{{ ucfirst($kategori) }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-gray-900">Kategori: {{ ucfirst($kategori) }}</h1>
            <p class="mt-2 text-gray-600">Produk UMKM dalam kategori {{ ucfirst($kategori) }}</p>
            <p class="mt-1 text-sm text-gray-500">{{ $produkUmkm->total() }} produk ditemukan</p>
        </div>
    </div>
</div>
@endsection

@section('container')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Search within Category -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Cari dalam Kategori</h3>
                <form method="GET" action="{{ route('umkm.category', $kategori) }}" class="space-y-4">
                    <div>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Cari produk...">
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                </form>
            </div>

            <!-- Navigation -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Navigasi</h3>
                <div class="space-y-2">
                    <a href="{{ route('umkm.index') }}" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Semua Produk
                    </a>
                    <a href="{{ route('umkm.index', ['featured' => '1']) }}" 
                       class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        Produk Unggulan
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-3">
            <!-- Category Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Kategori: {{ ucfirst($kategori) }}</h2>
                        <p class="text-gray-600 mt-1">Menampilkan {{ $produkUmkm->count() }} dari {{ $produkUmkm->total() }} produk</p>
                    </div>
                    <a href="{{ route('umkm.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Semua Kategori
                    </a>
                </div>
            </div>

            <!-- Products Grid -->
            @if($produkUmkm->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($produkUmkm as $produk)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow group">
                    <div class="relative">
                        @if($produk->gambar)
                        <img src="{{ Storage::url($produk->gambar) }}" alt="{{ $produk->nama }}" 
                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                        
                        @if($produk->is_featured)
                        <div class="absolute top-2 left-2">
                            <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded">
                                UNGGULAN
                            </span>
                        </div>
                        @endif
                        
                        <div class="absolute top-2 right-2">
                            <span class="bg-blue-600 text-white text-xs font-medium px-2 py-1 rounded">
                                {{ ucfirst($produk->kategori) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                            <a href="{{ route('umkm.show', $produk->slug) }}" class="hover:text-blue-600 transition-colors">
                                {{ $produk->nama }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                            {{ Str::limit(strip_tags($produk->deskripsi), 80) }}
                        </p>
                        
                        <div class="flex items-center justify-between mb-3">
                            <div class="text-xl font-bold text-green-600">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </div>
                            @if($produk->stok !== null)
                            <div class="text-sm text-gray-500">
                                Stok: {{ $produk->stok }}
                            </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <a href="{{ route('umkm.seller', $produk->user_id) }}" class="hover:text-blue-600">
                                    {{ $produk->user->name }}
                                </a>
                            </div>
                            
                            <a href="{{ route('umkm.show', $produk->slug) }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded transition-colors">
                                Lihat Detail
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                {{ $produkUmkm->appends(request()->query())->links() }}
            </div>
            @else
            <!-- No Products Found -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada produk dalam kategori ini</h3>
                <p class="text-gray-600 mb-4">Kategori "{{ ucfirst($kategori) }}" belum memiliki produk yang tersedia.</p>
                <div class="space-x-4">
                    <a href="{{ route('umkm.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        Lihat Semua Produk
                    </a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('umkm.index', ['featured' => '1']) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                        Produk Unggulan
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection