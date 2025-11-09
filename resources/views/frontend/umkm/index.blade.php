@extends('frontend.layouts.main')

@section('hero')
    <section class="relative h-[300px] sm:h-[350px] md:h-[400px] lg:h-[450px] xl:h-[500px] flex items-center justify-center text-center text-white" style="background-image: url('https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=2232&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 p-4">
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight leading-tight mb-2">
                Produk UMKM Desa
            </h1>
            <p class="text-base sm:text-lg md:text-xl lg:text-2xl font-light max-w-3xl mx-auto">
                Temukan berbagai produk unggulan dari UMKM lokal desa.
            </p>
        </div>
    </section>
@endsection

@section('container')
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid lg:grid-cols-4 gap-12 items-start">
        <!-- Sidebar Filters -->
        <aside class="lg:col-span-1">
            <!-- Search and Filter Form -->
            <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-5">Filter Produk</h3>
                <form method="GET" action="{{ route('umkm.index') }}" class="space-y-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Produk</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Nama produk, deskripsi...">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select id="kategori" name="kategori" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('kategori') == $category ? 'selected' : '' }}>
                                {{ ucfirst($category) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Harga</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="number" name="harga_min" value="{{ request('harga_min') }}"
                                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Min">
                            <input type="number" name="harga_max" value="{{ request('harga_max') }}"
                                   class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Max">
                        </div>
                    </div>

                    <!-- Featured Filter -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="featured" value="1" {{ request('featured') == '1' ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Produk Unggulan</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari Produk
                    </button>
                </form>
            </div>

            <!-- Featured Products -->
            @if($featuredProduk->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Produk Unggulan</h3>
                <div class="space-y-4">
                    @foreach($featuredProduk as $featured)
                    <div class="flex space-x-3">
                        @if($featured->gambar)
                        <img src="{{ Storage::url($featured->gambar) }}" alt="{{ $featured->nama }}" 
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
                                <a href="{{ route('umkm.show', $featured->slug) }}" class="hover:text-blue-600">
                                    {{ $featured->nama }}
                                </a>
                            </h4>
                            <p class="text-sm font-semibold text-green-600">Rp {{ number_format($featured->harga, 0, ',', '.') }}</p>
                            <p class="text-xs text-gray-500">{{ $featured->user->name }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </aside>

        <!-- Main Content -->
        <section class="lg:col-span-3">
            <!-- Sort and Results Info -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                <div class="mb-4 sm:mb-0">
                    <p class="text-sm text-gray-700">
                        Menampilkan {{ $produkUmkm->firstItem() ?? 0 }} - {{ $produkUmkm->lastItem() ?? 0 }} 
                        dari {{ $produkUmkm->total() }} produk
                    </p>
                </div>
                
                <form method="GET" action="{{ route('umkm.index') }}" class="flex items-center space-x-2">
                    @foreach(request()->except('sort') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    
                    <label for="sort" class="text-sm font-medium text-gray-700">Urutkan:</label>
                    <select id="sort" name="sort" onchange="this.form.submit()" 
                            class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="terbaru" {{ $sortBy == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="nama" {{ $sortBy == 'nama' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="harga_terendah" {{ $sortBy == 'harga_terendah' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="harga_tertinggi" {{ $sortBy == 'harga_tertinggi' ? 'selected' : '' }}>Harga Tertinggi</option>
                    </select>
                </form>
            </div>

            <!-- Products Grid -->
            @if($produkUmkm->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
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
                        
                        @if($produk->kategori)
                        <div class="absolute top-2 right-2">
                            <span class="bg-blue-600 text-white text-xs font-medium px-2 py-1 rounded">
                                {{ ucfirst($produk->kategori) }}
                            </span>
                        </div>
                        @endif
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
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada produk ditemukan</h3>
                <p class="text-gray-600 mb-4">Coba ubah filter pencarian atau kata kunci Anda.</p>
                <a href="{{ route('umkm.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                    Lihat Semua Produk
                </a>
            </div>
            @endif
        </section>
    </div>
    </div>
</section>
@endsection