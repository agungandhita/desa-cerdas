@extends('frontend.layouts.main')

@section('hero')
<div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Selamat Datang di <span class="text-yellow-300">Desa Cerdas</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto">
                Sistem Informasi Desa yang Modern, Transparan, dan Melayani Masyarakat
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('layanan.index') }}" 
                   class="bg-yellow-400 hover:bg-yellow-500 text-blue-900 px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                    Layanan Publik
                </a>
                <a href="{{ route('tentang') }}" 
                   class="border-2 border-white hover:bg-white hover:text-blue-800 px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                    Tentang Desa
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('container')
<!-- Statistics Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Statistik Desa</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Data terkini mengenai berbagai aspek kehidupan desa</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-blue-600 mb-2">{{ $statistics['total_berita'] }}</div>
                <div class="text-gray-600">Berita</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-green-600 mb-2">{{ $statistics['total_produk_umkm'] }}</div>
                <div class="text-gray-600">Produk UMKM</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-purple-600 mb-2">{{ $statistics['total_forum'] }}</div>
                <div class="text-gray-600">Diskusi Forum</div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-3xl font-bold text-orange-600 mb-2">{{ $statistics['total_lokasi'] }}</div>
                <div class="text-gray-600">Lokasi Wisata</div>
            </div>
        </div>
    </div>
</section>

<!-- Featured News Section -->
@if($featuredBerita->count() > 0)
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Berita Unggulan</h2>
                <p class="text-gray-600">Berita terbaru dan terpenting dari desa</p>
            </div>
            <a href="{{ route('berita.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Lihat Semua →
            </a>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($featuredBerita as $berita)
            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($berita->gambar)
                <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}" 
                     class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
                
                <div class="p-6">
                    <div class="flex items-center text-sm text-gray-500 mb-2">
                        <span>{{ $berita->author->name }}</span>
                        <span class="mx-2">•</span>
                        <span>{{ $berita->created_at->format('d M Y') }}</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3 line-clamp-2">
                        {{ $berita->judul }}
                    </h3>
                    <p class="text-gray-600 mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($berita->isi), 150) }}
                    </p>
                    <a href="{{ route('berita.show', $berita->slug) }}" 
                       class="text-blue-600 hover:text-blue-800 font-semibold">
                        Baca Selengkapnya →
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Featured UMKM Products Section -->
@if($featuredProdukUmkm->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Produk UMKM Unggulan</h2>
                <p class="text-gray-600">Produk terbaik dari UMKM lokal desa</p>
            </div>
            <a href="{{ route('umkm.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Lihat Semua →
            </a>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($featuredProdukUmkm as $produk)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                @if($produk->gambar)
                <img src="{{ Storage::url($produk->gambar) }}" alt="{{ $produk->nama }}" 
                     class="w-full h-32 object-cover">
                @else
                <div class="w-full h-32 bg-gray-200 flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                @endif
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-1 text-sm line-clamp-2">
                        {{ $produk->nama }}
                    </h3>
                    <p class="text-xs text-gray-500 mb-2">{{ $produk->user->name }}</p>
                    <p class="text-green-600 font-bold text-sm">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Recent Forum Discussions -->
@if($recentForum->count() > 0)
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-12">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Diskusi Forum Terbaru</h2>
                <p class="text-gray-600">Diskusi dan pertanyaan terbaru dari warga</p>
            </div>
            <a href="{{ route('forum.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                Lihat Semua →
            </a>
        </div>
        
        <div class="bg-white rounded-lg shadow-md">
            @foreach($recentForum as $forum)
            <div class="p-6 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-semibold text-sm">
                                {{ substr($forum->user->name, 0, 1) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2 mb-2">
                            <h3 class="text-lg font-semibold text-gray-900">
                                <a href="{{ route('forum.show', $forum->id) }}" class="hover:text-blue-600">
                                    {{ $forum->judul }}
                                </a>
                            </h3>
                        </div>
                        <p class="text-gray-600 mb-2 line-clamp-2">
                            {{ Str::limit(strip_tags($forum->isi), 200) }}
                        </p>
                        <div class="flex items-center text-sm text-gray-500">
                            <span>{{ $forum->user->name }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $forum->created_at->diffForHumans() }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $forum->komentars_count ?? 0 }} komentar</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Services Quick Access -->
<section class="py-16 bg-blue-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-white mb-4">Layanan Publik</h2>
            <p class="text-blue-100 max-w-2xl mx-auto">Akses mudah ke berbagai layanan administrasi desa</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Surat Keterangan</h3>
                <p class="text-gray-600 mb-4">Ajukan permohonan surat keterangan online</p>
                <a href="{{ route('layanan.create') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Ajukan Sekarang →
                </a>
            </div>
            
            <div class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">APBDes</h3>
                <p class="text-gray-600 mb-4">Lihat transparansi anggaran desa</p>
                <a href="{{ route('apbdes.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Lihat Detail →
                </a>
            </div>
            
            <div class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Forum Diskusi</h3>
                <p class="text-gray-600 mb-4">Diskusi dan tanya jawab dengan warga</p>
                <a href="{{ route('forum.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Mulai Diskusi →
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
