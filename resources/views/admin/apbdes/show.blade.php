@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.apbdes.index') }}" 
                   class="text-slate-600 hover:text-slate-800 transition-colors duration-200">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Detail APB Desa</h1>
                    <p class="text-slate-600 mt-1">Informasi lengkap anggaran pendapatan dan belanja desa</p>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.apbdes.edit', $apbdes) }}" 
                   class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                <form action="{{ route('admin.apbdes.destroy', $apbdes) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <i class="fas fa-trash"></i>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">Informasi Utama</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Tahun -->
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Tahun</label>
                            <p class="text-lg font-semibold text-slate-900">{{ $apbdes->tahun }}</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Status</label>
                            <div>
                                @if($apbdes->status == 'draft')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-edit mr-2"></i>
                                        Draft
                                    </span>
                                @elseif($apbdes->status == 'approved')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-slate-100 text-slate-800">
                                        <i class="fas fa-flag-checkered mr-2"></i>
                                        Executed
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Bidang -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Bidang</label>
                            <p class="text-lg font-semibold text-slate-900">{{ $apbdes->bidang }}</p>
                        </div>

                        <!-- Deskripsi -->
                        @if($apbdes->deskripsi)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-600 mb-1">Deskripsi</label>
                            <p class="text-slate-700 leading-relaxed">{{ $apbdes->deskripsi }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Financial Details -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200 mt-6">
                <div class="p-6 border-b border-slate-200">
                    <h2 class="text-lg font-semibold text-slate-800">Detail Keuangan</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jumlah Anggaran -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-blue-600">Jumlah Anggaran</p>
                                    <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($apbdes->jumlah_anggaran, 0, ',', '.') }}</p>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-money-bill-wave text-blue-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Realisasi -->
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-green-600">Realisasi</p>
                                    <p class="text-2xl font-bold text-green-900">Rp {{ number_format($apbdes->realisasi ?? 0, 0, ',', '.') }}</p>
                                </div>
                                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-chart-line text-green-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Sisa Anggaran -->
                        @php
                            $sisaAnggaran = $apbdes->jumlah_anggaran - ($apbdes->realisasi ?? 0);
                        @endphp
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-purple-600">Sisa Anggaran</p>
                                    <p class="text-2xl font-bold text-purple-900">Rp {{ number_format($sisaAnggaran, 0, ',', '.') }}</p>
                                </div>
                                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-wallet text-purple-600 text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Persentase Realisasi -->
                        @php
                            $percentage = $apbdes->jumlah_anggaran > 0 ? ($apbdes->realisasi / $apbdes->jumlah_anggaran) * 100 : 0;
                        @endphp
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-orange-600">Persentase Realisasi</p>
                                    <p class="text-2xl font-bold text-orange-900">{{ number_format($percentage, 1) }}%</p>
                                </div>
                                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-percentage text-orange-600 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mt-6">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-slate-700">Progress Realisasi</span>
                            <span class="text-sm text-slate-500">{{ number_format($percentage, 1) }}%</span>
                        </div>
                        <div class="w-full bg-slate-200 rounded-full h-3">
                            <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-300" 
                                 style="width: {{ min($percentage, 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Information -->
        <div class="space-y-6">
            <!-- Metadata -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800">Metadata</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Dibuat</label>
                        <p class="text-sm text-slate-900">{{ $apbdes->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Terakhir Diupdate</label>
                        <p class="text-sm text-slate-900">{{ $apbdes->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800">Aksi Cepat</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.apbdes.edit', $apbdes) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2 justify-center">
                        <i class="fas fa-edit"></i>
                        Edit Data
                    </a>
                    <button class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2 justify-center">
                        <i class="fas fa-download"></i>
                        Export PDF
                    </button>
                    <button class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2 justify-center">
                        <i class="fas fa-share"></i>
                        Bagikan
                    </button>
                </div>
            </div>

            <!-- Status Information -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="p-6 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800">Informasi Status</h3>
                </div>
                <div class="p-6">
                    @if($apbdes->status == 'draft')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-yellow-600 mt-1 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-yellow-800">Status Draft</h4>
                                    <p class="text-sm text-yellow-700 mt-1">Data masih dalam tahap penyusunan dan belum final.</p>
                                </div>
                            </div>
                        </div>
                    @elseif($apbdes->status == 'approved')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mt-1 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-green-800">Status Approved</h4>
                                    <p class="text-sm text-green-700 mt-1">Anggaran telah disetujui dan dapat direalisasikan.</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                            <div class="flex items-start">
                                <i class="fas fa-flag-checkered text-slate-600 mt-1 mr-3"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-slate-800">Status Executed</h4>
                                    <p class="text-sm text-slate-700 mt-1">Anggaran telah selesai dilaksanakan.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection