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
                        <span class="ml-4 text-sm font-medium text-gray-500 truncate">{{ Str::limit($produk->nama, 50) }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection

@section('container')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid lg:grid-cols-2 gap-8 mb-12">
        <!-- Product Images -->
        <div class="space-y-4">
            <div class="aspect-square bg-gray-200 rounded-lg overflow-hidden">
                @if($produk->gambar)
                <img src="{{ Storage::url($produk->gambar) }}" alt="{{ $produk->nama }}" 
                     class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="space-y-6">
            <div>
                <div class="flex items-center space-x-2 mb-2">
                    @if($produk->is_featured)
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">
                        Produk Unggulan
                    </span>
                    @endif
                    @if($produk->kategori)
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                        {{ ucfirst($produk->kategori) }}
                    </span>
                    @endif
                </div>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $produk->nama }}</h1>
                
                <div class="text-3xl font-bold text-green-600 mb-4">
                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                </div>
            </div>

            <!-- Seller Info -->
            <div class="bg-gray-50 rounded-lg p-4">
                <h3 class="text-sm font-medium text-gray-900 mb-2">Penjual</h3>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $produk->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $produk->user->email }}</p>
                    </div>
                    <div class="flex-1"></div>
                    <a href="{{ route('umkm.seller', $produk->user_id) }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        Lihat Toko
                    </a>
                </div>
            </div>

            <!-- Product Details -->
            <div class="space-y-4">
                @if($produk->stok !== null)
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">Stok</span>
                    <span class="font-medium {{ $produk->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $produk->stok > 0 ? $produk->stok . ' tersedia' : 'Habis' }}
                    </span>
                </div>
                @endif
                
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">Status</span>
                    <span class="font-medium text-green-600">{{ ucfirst($produk->status) }}</span>
                </div>
                
                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                    <span class="text-gray-600">Ditambahkan</span>
                    <span class="font-medium text-gray-900">{{ $produk->created_at->format('d F Y') }}</span>
                </div>
            </div>

            <!-- Contact Actions -->
            <div class="space-y-3">
                @if($produk->user->phone)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $produk->user->phone) }}?text=Halo, saya tertarik dengan produk {{ $produk->nama }}" 
                   target="_blank"
                   class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                    </svg>
                    Hubungi via WhatsApp
                </a>
                @endif
                
                <a href="tel:{{ $produk->user->phone ?? '' }}" 
                   class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg flex items-center justify-center transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Telepon Penjual
                </a>
            </div>
        </div>
    </div>

    <!-- Product Description -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Deskripsi Produk</h2>
        <div class="prose max-w-none">
            {!! nl2br(e($produk->deskripsi)) !!}
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProduk->count() > 0)
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Produk Terkait</h2>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProduk as $related)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="relative">
                    @if($related->gambar)
                    <img src="{{ Storage::url($related->gambar) }}" alt="{{ $related->nama }}" 
                         class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                    
                    @if($related->is_featured)
                    <div class="absolute top-2 left-2">
                        <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded">
                            UNGGULAN
                        </span>
                    </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                        <a href="{{ route('umkm.show', $related->slug) }}" class="hover:text-blue-600">
                            {{ $related->nama }}
                        </a>
                    </h3>
                    
                    <div class="text-lg font-bold text-green-600 mb-2">
                        Rp {{ number_format($related->harga, 0, ',', '.') }}
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">{{ $related->user->name }}</span>
                        <a href="{{ route('umkm.show', $related->slug) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Owner's Other Products -->
    @if($ownerProducts->count() > 0)
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Produk Lain dari {{ $produk->user->name }}</h2>
            <a href="{{ route('umkm.seller', $produk->user_id) }}" 
               class="text-blue-600 hover:text-blue-800 font-medium">
                Lihat Semua
            </a>
        </div>
        
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($ownerProducts as $owner)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="relative">
                    @if($owner->gambar)
                    <img src="{{ Storage::url($owner->gambar) }}" alt="{{ $owner->nama }}" 
                         class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    @endif
                    
                    @if($owner->is_featured)
                    <div class="absolute top-2 left-2">
                        <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-2 py-1 rounded">
                            UNGGULAN
                        </span>
                    </div>
                    @endif
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                        <a href="{{ route('umkm.show', $owner->slug) }}" class="hover:text-blue-600">
                            {{ $owner->nama }}
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                        {{ Str::limit(strip_tags($owner->deskripsi), 80) }}
                    </p>
                    
                    <div class="flex items-center justify-between">
                        <div class="text-lg font-bold text-green-600">
                            Rp {{ number_format($owner->harga, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('umkm.show', $owner->slug) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Back Button -->
    <div class="text-center">
        <a href="{{ route('umkm.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Produk
        </a>
    </div>
</div>
@endsection