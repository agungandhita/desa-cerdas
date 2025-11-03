@extends('layouts.frontend')

@section('title', 'Riwayat Permohonan Layanan')

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
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('layanan.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Layanan Publik</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Riwayat Permohonan</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Permohonan</h3>
                    
                    <form method="GET" action="{{ route('layanan.riwayat') }}" class="space-y-4">
                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <!-- Service Type Filter -->
                        <div>
                            <label for="jenis_layanan" class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan</label>
                            <select name="jenis_layanan" id="jenis_layanan" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Layanan</option>
                                <option value="surat_keterangan_domisili" {{ request('jenis_layanan') == 'surat_keterangan_domisili' ? 'selected' : '' }}>Surat Keterangan Domisili</option>
                                <option value="surat_keterangan_usaha" {{ request('jenis_layanan') == 'surat_keterangan_usaha' ? 'selected' : '' }}>Surat Keterangan Usaha</option>
                                <option value="surat_keterangan_tidak_mampu" {{ request('jenis_layanan') == 'surat_keterangan_tidak_mampu' ? 'selected' : '' }}>Surat Keterangan Tidak Mampu</option>
                                <option value="surat_pengantar_nikah" {{ request('jenis_layanan') == 'surat_pengantar_nikah' ? 'selected' : '' }}>Surat Pengantar Nikah</option>
                                <option value="surat_keterangan_kelahiran" {{ request('jenis_layanan') == 'surat_keterangan_kelahiran' ? 'selected' : '' }}>Surat Keterangan Kelahiran</option>
                                <option value="surat_keterangan_kematian" {{ request('jenis_layanan') == 'surat_keterangan_kematian' ? 'selected' : '' }}>Surat Keterangan Kematian</option>
                            </select>
                        </div>

                        <!-- Date Range -->
                        <div>
                            <label for="tanggal_dari" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Dari</label>
                            <input type="date" name="tanggal_dari" id="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="tanggal_sampai" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Sampai</label>
                            <input type="date" name="tanggal_sampai" id="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Filter
                        </button>

                        @if(request()->hasAny(['status', 'jenis_layanan', 'tanggal_dari', 'tanggal_sampai']))
                            <a href="{{ route('layanan.riwayat') }}" class="w-full bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-300 block text-center">
                                Reset Filter
                            </a>
                        @endif
                    </form>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('layanan.create') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Ajukan Permohonan Baru
                        </a>
                        <a href="{{ route('layanan.index') }}" class="flex items-center text-green-600 hover:text-green-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Lihat Semua Layanan
                        </a>
                        <a href="{{ route('kontak') }}" class="flex items-center text-purple-600 hover:text-purple-800 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Header -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Riwayat Permohonan Layanan</h1>
                            <p class="text-gray-600 mt-1">Kelola dan pantau status permohonan layanan Anda</p>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                                Total: {{ $permohonan->total() }} Permohonan
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Service Requests List -->
                @if($permohonan->count() > 0)
                    <div class="space-y-4">
                        @foreach($permohonan as $item)
                            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-300">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between mb-3">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900">
                                                    {{ ucwords(str_replace('_', ' ', $item->jenis_layanan)) }}
                                                </h3>
                                                <p class="text-sm text-gray-600">No. Permohonan: #{{ $item->id }}</p>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                                @if($item->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($item->status == 'diproses') bg-blue-100 text-blue-800
                                                @elseif($item->status == 'selesai') bg-green-100 text-green-800
                                                @elseif($item->status == 'ditolak') bg-red-100 text-red-800
                                                @endif">
                                                @if($item->status == 'pending') Menunggu
                                                @elseif($item->status == 'diproses') Diproses
                                                @elseif($item->status == 'selesai') Selesai
                                                @elseif($item->status == 'ditolak') Ditolak
                                                @endif
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <p class="text-sm text-gray-600">Tanggal Pengajuan:</p>
                                                <p class="font-medium">{{ $item->created_at->format('d M Y, H:i') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-sm text-gray-600">Keperluan:</p>
                                                <p class="font-medium">{{ Str::limit($item->keperluan, 50) }}</p>
                                            </div>
                                        </div>

                                        @if($item->keterangan_admin)
                                            <div class="bg-gray-50 rounded-lg p-3 mb-4">
                                                <p class="text-sm text-gray-600 mb-1">Keterangan Admin:</p>
                                                <p class="text-sm">{{ $item->keterangan_admin }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-4 lg:mt-0 lg:ml-6 flex flex-col sm:flex-row gap-2">
                                        <a href="{{ route('layanan.show', $item->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition duration-300">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Detail
                                        </a>

                                        @if($item->status == 'selesai' && $item->file_hasil)
                                            <a href="{{ Storage::url($item->file_hasil) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition duration-300">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                Unduh
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $permohonan->appends(request()->query())->links() }}
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Permohonan</h3>
                        <p class="text-gray-600 mb-6">Anda belum pernah mengajukan permohonan layanan.</p>
                        <a href="{{ route('layanan.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Ajukan Permohonan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection