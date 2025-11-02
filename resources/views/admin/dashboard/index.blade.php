@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header Dashboard -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Dashboard Desa Cerdas</h1>
        <p class="text-slate-600 mt-1">Selamat datang di panel admin Desa Cerdas</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Pengguna</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalUsers }}</p>
                    <p class="text-xs text-slate-500 mt-2">Warga terdaftar</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Permohonan Surat</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalPermohonanSurat }}</p>
                    <div class="flex gap-2 mt-2">
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded">Pending: {{ $permohonanStats['pending'] }}</span>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">Diproses: {{ $permohonanStats['diproses'] }}</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Berita & Forum</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalBerita + $totalForum }}</p>
                    <div class="flex gap-2 mt-2">
                        <span class="text-xs px-2 py-1 bg-emerald-100 text-emerald-800 rounded">Berita: {{ $totalBerita }}</span>
                        <span class="text-xs px-2 py-1 bg-teal-100 text-teal-800 rounded">Forum: {{ $totalForum }}</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-newspaper text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">UMKM & Lokasi</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalProdukUmkm + $totalLokasiDesa }}</p>
                    <div class="flex gap-2 mt-2">
                        <span class="text-xs px-2 py-1 bg-orange-100 text-orange-800 rounded">UMKM: {{ $totalProdukUmkm }}</span>
                        <span class="text-xs px-2 py-1 bg-red-100 text-red-800 rounded">Lokasi: {{ $totalLokasiDesa }}</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-store text-yellow-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Permohonan Surat Terbaru</h3>
            <div class="space-y-4">
                @forelse($recentPermohonanSurat as $permohonan)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <p class="font-medium text-slate-900">#{{ $permohonan->id }}</p>
                        <p class="text-sm text-slate-600">{{ $permohonan->user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $permohonan->jenis_surat }}</p>
                    </div>
                    <div class="text-right">
                        @if($permohonan->status == 'pending')
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                        @elseif($permohonan->status == 'diproses')
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Diproses</span>
                        @elseif($permohonan->status == 'selesai')
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Selesai</span>
                        @else
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Ditolak</span>
                        @endif
                        <p class="text-xs text-slate-500 mt-1">{{ $permohonan->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-slate-500">Belum ada permohonan surat</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Berita Terbaru</h3>
            <div class="space-y-4">
                @forelse($recentBerita as $berita)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <p class="font-medium text-slate-900">{{ Str::limit($berita->judul, 30) }}</p>
                        <p class="text-sm text-slate-600">{{ $berita->author->name }}</p>
                        <p class="text-xs text-slate-500">{{ $berita->kategori }}</p>
                    </div>
                    <div class="text-right">
                        @if($berita->status == 'published')
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Published</span>
                        @else
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Draft</span>
                        @endif
                        <p class="text-xs text-slate-500 mt-1">{{ $berita->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-slate-500">Belum ada berita</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Monthly Statistics -->
    <div class="mt-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Statistik Bulanan</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $permohonanBulanIni }}</div>
                    <div class="text-sm text-slate-600">Permohonan Surat Bulan Ini</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $beritaBulanIni }}</div>
                    <div class="text-sm text-slate-600">Berita Bulan Ini</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">{{ $forumBulanIni }}</div>
                    <div class="text-sm text-slate-600">Diskusi Forum Bulan Ini</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
