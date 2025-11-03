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
                        <span class="ml-4 text-sm font-medium text-gray-500">{{ $seller->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="mt-4">
            <h1 class="text-3xl font-bold text-gray-900">Produk dari {{ $seller->name }}</h1>
            <p class="mt-2 text-gray-600">Semua produk UMKM yang dijual oleh {{ $seller->name }}</p>
            <p class="mt-1 text-sm text-gray-500">{{ $produkUmkm->total() }} produk tersedia</p>
        </div>
    </div>
</div>
@endsection

@section('container')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Seller Profile -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="text-center">
                    @if($seller->avatar)
                    <img src="{{ Storage::url($seller->avatar) }}" alt="{{ $seller->name }}" 
                         class="w-20 h-20 rounded-full mx-auto mb-4 object-cover">
                    @else
                    <div class="w-20 h-20 rounded-full bg-gray-200 mx-auto mb-4 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $seller->name }}</h3>
                    
                    @if($seller->email)
                    <p class="text-sm text-gray-600 mb-2">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        {{ $seller->email }}
                    </p>
                    @endif
                    
                    @if($seller->phone)
                    <p class="text-sm text-gray-600 mb-4">
                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        {{ $seller->phone }}
                    </p>
                    @endif
                    
                    <div class="text-sm text-gray-500">
                        <p>Bergabung {{ $seller->created_at->format('M Y') }}</p>
                        <p class="mt-1">{{ $produkUmkm->total() }} produk</p>
                    </div>
                </div>
            </div>

            <!-- Contact Seller -->
            @if($seller->phone || $seller->whatsapp)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Hubungi Penjual</h3>
                <div class="space-y-3">
                    @if($seller->whatsapp)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $seller->whatsapp) }}" 
                       target="_blank"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        WhatsApp
                    </a>
                    @endif
                    
                    @if($seller->phone)
                    <a href="tel:{{ $seller->phone }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Telepon
                    </a>
                    @endif
                </div>
            </div>
            @endif

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
            <!-- Seller Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Produk dari {{ $seller->name }}</h2>
                        <p class="text-gray-600 mt-1">Menampilkan {{ $produkUmkm->count() }} dari {{ $produkUmkm->total() }} produk</p>
                    </div>
                    <a href="{{ route('umkm.index') }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Semua Penjual
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
                            <div class="text-sm text-gray-500">
                                <span class="inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $produk->created_at->diffForHumans() }}
                                </span>
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
                {{ $produkUmkm->links() }}
            </div>
            @else
            <!-- No Products Found -->
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada produk</h3>
                <p class="text-gray-600 mb-4">{{ $seller->name }} belum memiliki produk yang tersedia.</p>
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