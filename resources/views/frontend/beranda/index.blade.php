@extends('frontend.layouts.main')

@section('hero')
    <!-- Hero Section -->
    <div class="relative h-[50vh] md:h-[60vh] bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1502082553048-f009c37129b9?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center items-center text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-4 animate-fade-in-down">
                Selamat Datang di <span class="text-yellow-300">Desa Cerdas</span>
            </h1>
            <p class="text-lg md:text-xl mb-8 max-w-3xl animate-fade-in-up">
                Inovasi Digital untuk Kesejahteraan Masyarakat Desa
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('layanan.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-semibold text-lg transition-transform transform hover:scale-105 shadow-lg">
                    <i class="fas fa-concierge-bell mr-2"></i>Layanan Publik
                </a>
                <a href="{{ route('tentang') }}" class="border-2 border-white hover:bg-white hover:text-blue-800 px-8 py-3 rounded-full font-semibold text-lg transition-colors shadow-lg">
                    <i class="fas fa-info-circle mr-2"></i>Jelajahi Desa
                </a>
            </div>
        </div>
    </div>
@endsection

@section('container')
    <!-- Statistics Section -->
    <section class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Sekilas Desa</h2>
                <p class="text-gray-600 text-lg">Data dan informasi terkini seputar desa kami.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="flex items-center justify-center bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow transform hover:-translate-y-1">
                    <i class="fas fa-newspaper text-4xl text-blue-500 mr-4"></i>
                    <div>
                        <div class="text-3xl font-bold text-gray-800">{{ $statistics['total_berita'] }}</div>
                        <div class="text-gray-500">Berita</div>
                    </div>
                </div>
                <div class="flex items-center justify-center bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow transform hover:-translate-y-1">
                    <i class="fas fa-store text-4xl text-green-500 mr-4"></i>
                    <div>
                        <div class="text-3xl font-bold text-gray-800">{{ $statistics['total_produk_umkm'] }}</div>
                        <div class="text-gray-500">Produk UMKM</div>
                    </div>
                </div>
                <div class="flex items-center justify-center bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow transform hover:-translate-y-1">
                    <i class="fas fa-comments text-4xl text-purple-500 mr-4"></i>
                    <div>
                        <div class="text-3xl font-bold text-gray-800">{{ $statistics['total_forum'] }}</div>
                        <div class="text-gray-500">Diskusi Forum</div>
                    </div>
                </div>
                <div class="flex items-center justify-center bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition-shadow transform hover:-translate-y-1">
                    <i class="fas fa-map-marked-alt text-4xl text-orange-500 mr-4"></i>
                    <div>
                        <div class="text-3xl font-bold text-gray-800">{{ $statistics['total_lokasi'] }}</div>
                        <div class="text-gray-500">Lokasi Penting</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured News Section -->
    @if($featuredBerita->count() > 0)
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Berita Terkini</h2>
                <p class="text-gray-600 text-lg">Ikuti perkembangan terbaru dari desa kami.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($featuredBerita as $berita)
                <article class="bg-white rounded-xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                    <a href="{{ route('berita.show', $berita->slug) }}">
                        @if($berita->gambar)
                        <img src="{{ Storage::url($berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full h-56 object-cover">
                        @else
                        <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-4xl text-gray-400"></i>
                        </div>
                        @endif
                    </a>
                    <div class="p-6">
                        <div class="flex items-center text-sm text-gray-500 mb-3">
                            <i class="fas fa-user-circle mr-2"></i><span>{{ $berita->author->name }}</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-calendar-alt mr-2"></i><span>{{ $berita->created_at->format('d M Y') }}</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-3 hover:text-blue-600 transition-colors">
                            <a href="{{ route('berita.show', $berita->slug) }}">{{ $berita->judul }}</a>
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($berita->isi), 120) }}
                        </p>
                        <a href="{{ route('berita.show', $berita->slug) }}" class="font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                            Baca Selengkapnya <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </article>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('berita.index') }}" class="bg-gray-800 text-white px-8 py-3 rounded-full font-semibold hover:bg-gray-900 transition-colors">
                    Lihat Semua Berita
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Featured UMKM Products Section -->
    @if($featuredProdukUmkm->count() > 0)
    <section class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Produk Unggulan UMKM</h2>
                <p class="text-gray-600 text-lg">Dukung usaha lokal dengan produk-produk berkualitas.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($featuredProdukUmkm as $produk)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden group transform hover:-translate-y-2 transition-transform duration-300">
                    <a href="{{ route('umkm.index') }}" class="block">
                        <div class="relative">
                            @if($produk->gambar)
                            <img src="{{ Storage::url($produk->gambar) }}" alt="{{ $produk->nama }}" class="w-full h-48 object-cover">
                            @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-box-open text-4xl text-gray-400"></i>
                            </div>
                            @endif
                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <p class="text-white font-bold">Lihat Detail</p>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-800 text-lg mb-1 truncate">{{ $produk->nama }}</h3>
                            <p class="text-sm text-gray-500 mb-2"><i class="fas fa-user-tag mr-1"></i>{{ $produk->user->name }}</p>
                            <p class="text-green-600 font-bold text-xl">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('umkm.index') }}" class="bg-gray-800 text-white px-8 py-3 rounded-full font-semibold hover:bg-gray-900 transition-colors">
                    Jelajahi Semua Produk
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Recent Forum Discussions -->
    @if($recentForum->count() > 0)
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-3">Forum Diskusi Warga</h2>
                <p class="text-gray-600 text-lg">Ruang bagi warga untuk berbagi ide dan informasi.</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <ul class="divide-y divide-gray-200">
                    @foreach($recentForum as $forum)
                    <li class="py-4">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-xl text-blue-600"></i>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-lg font-bold text-gray-800 hover:text-blue-600 transition-colors">
                                    <a href="{{ route('forum.show', $forum->id) }}">{{ $forum->judul }}</a>
                                </h4>
                                <p class="text-gray-600 mt-1 line-clamp-2">
                                    {{ Str::limit(strip_tags($forum->isi), 150) }}
                                </p>
                                <div class="flex items-center text-sm text-gray-500 mt-2">
                                    <span>Oleh: {{ $forum->user->name }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $forum->created_at->diffForHumans() }}</span>
                                    <span class="mx-2">•</span>
                                    <span><i class="fas fa-comment-dots mr-1"></i>{{ $forum->komentars_count ?? 0 }} Komentar</span>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('forum.index') }}" class="bg-gray-800 text-white px-8 py-3 rounded-full font-semibold hover:bg-gray-900 transition-colors">
                    Masuk ke Forum
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Services Quick Access -->
    <section class="py-20 bg-blue-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold mb-3">Akses Layanan Publik</h2>
                <p class="text-blue-200 text-lg max-w-2xl mx-auto">Layanan digital untuk kemudahan administrasi dan informasi desa.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 text-center transform hover:scale-105 transition-transform duration-300 shadow-lg">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-file-alt text-4xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Surat Keterangan</h3>
                    <p class="text-blue-200 mb-6">Ajukan surat keterangan secara online, cepat, dan mudah.</p>
                    <a href="{{ route('layanan.create') }}" class="bg-yellow-400 text-blue-900 px-6 py-2 rounded-full font-semibold hover:bg-yellow-500 transition-colors">
                        Ajukan Sekarang
                    </a>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 text-center transform hover:scale-105 transition-transform duration-300 shadow-lg">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-chart-pie text-4xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Transparansi APBDes</h3>
                    <p class="text-blue-200 mb-6">Pantau alokasi dan realisasi anggaran desa secara transparan.</p>
                    <a href="{{ route('apbdes.index') }}" class="bg-yellow-400 text-blue-900 px-6 py-2 rounded-full font-semibold hover:bg-yellow-500 transition-colors">
                        Lihat Detail
                    </a>
                </div>
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-8 text-center transform hover:scale-105 transition-transform duration-300 shadow-lg">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-4xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold mb-3">Forum Warga</h3>
                    <p class="text-blue-200 mb-6">Berpartisipasi dalam diskusi untuk kemajuan desa.</p>
                    <a href="{{ route('forum.index') }}" class="bg-yellow-400 text-blue-900 px-6 py-2 rounded-full font-semibold hover:bg-yellow-500 transition-colors">
                        Mulai Diskusi
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    @keyframes fade-in-down {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-down {
        animation: fade-in-down 0.8s ease-out forwards;
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.8s ease-out 0.4s forwards;
        opacity: 0;
    }
</style>
@endpush
