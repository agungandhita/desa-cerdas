@extends('frontend.layouts.main')

@section('container')
<div class="bg-gray-50 font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">Riwayat Permohonan Anda</h1>
            <p class="mt-4 text-lg text-gray-600 max-w-2xl mx-auto">Lacak dan kelola semua permohonan surat yang pernah Anda ajukan dengan mudah.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Sidebar with Filters -->
            <aside class="lg:col-span-3">
                <div class="sticky top-24">
                    <div class="bg-white rounded-2xl shadow-lg p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-5 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10zM15 10a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1h-2a1 1 0 01-1-1v-4z"></path></svg>
                            Filter Pencarian
                        </h3>
                        
                        <form method="GET" action="{{ route('layanan.riwayat') }}" class="space-y-6">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" id="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">Semua Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                            </div>

                            <div>
                                <label for="jenis_layanan" class="block text-sm font-medium text-gray-700 mb-1">Jenis Layanan</label>
                                <select name="jenis_layanan" id="jenis_layanan" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                    <option value="">Semua Layanan</option>
                                    @foreach($jenisLayanan as $key => $nama)
                                    <option value="{{ $key }}" {{ request('jenis_layanan') == $key ? 'selected' : '' }}>{{ $nama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="tanggal_dari" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                                <input type="date" name="tanggal_dari" id="tanggal_dari" value="{{ request('tanggal_dari') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>

                            <div>
                                <label for="tanggal_sampai" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                                <input type="date" name="tanggal_sampai" id="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                            </div>

                            <div class="flex flex-col space-y-3 pt-2">
                                <button type="submit" class="w-full flex items-center justify-center bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition-transform transform hover:scale-105 shadow-md">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    Terapkan Filter
                                </button>
                                @if(request()->hasAny(['status', 'jenis_layanan', 'tanggal_dari', 'tanggal_sampai']))
                                    <a href="{{ route('layanan.riwayat') }}" class="w-full text-center bg-gray-200 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-300 transition">
                                        Reset Filter
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="lg:col-span-9">
                <div class="flex justify-between items-center mb-6 bg-white p-4 rounded-xl shadow-sm">
                    <h2 class="text-xl font-semibold text-gray-800">Menampilkan {{ $permohonan->count() }} dari {{ $permohonan->total() }} permohonan</h2>
                    <a href="{{ route('layanan.create') }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 shadow-md hover:shadow-lg transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Buat Permohonan Baru
                    </a>
                </div>

                @if($permohonan->count() > 0)
                    <div class="space-y-5">
                        @foreach($permohonan as $item)
                            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-1 transition-all duration-300">
                                <div class="p-6">
                                    <div class="flex flex-col sm:flex-row justify-between items-start">
                                        <div class="flex-1 mb-4 sm:mb-0">
                                            <div class="flex items-center mb-2">
                                                @php
                                                    $status_config = [
                                                        'pending' => ['color' => 'yellow', 'label' => 'Menunggu', 'icon' => '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.414-1.414L11 7.586V6z" clip-rule="evenodd"></path></svg>'],
                                                        'diproses' => ['color' => 'blue', 'label' => 'Diproses', 'icon' => '<svg class="w-5 h-5 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>'],
                                                        'selesai' => ['color' => 'green', 'label' => 'Selesai', 'icon' => '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>'],
                                                        'ditolak' => ['color' => 'red', 'label' => 'Ditolak', 'icon' => '<svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>'],
                                                    ];
                                                    $current_status = $status_config[$item->status] ?? ['color' => 'gray', 'label' => 'Tidak Diketahui', 'icon' => ''];
                                                @endphp
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold leading-5 bg-{{ $current_status['color'] }}-100 text-{{ $current_status['color'] }}-800">
                                                    {!! $current_status['icon'] !!}
                                                    {{ $current_status['label'] }}
                                                </span>
                                            </div>
                                            <h3 class="text-xl font-bold text-gray-800 hover:text-blue-600 transition">
                                                <a href="{{ route('layanan.show', $item->id) }}">{{ $jenisLayanan[$item->jenis_surat] ?? ucwords(str_replace('_', ' ', $item->jenis_surat)) }}</a>
                                            </h3>
                                            <p class="text-sm text-gray-500 mt-1">No. #{{ $item->id }} &bull; Diajukan pada {{ $item->created_at->isoFormat('dddd, D MMMM YYYY') }}</p>
                                        </div>
                                        <div class="flex-shrink-0 flex flex-col sm:flex-row sm:items-center sm:space-x-3 mt-4 sm:mt-0">
                                            <a href="{{ route('layanan.show', $item->id) }}" class="w-full sm:w-auto mb-2 sm:mb-0 inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Lihat Detail
                                            </a>
                                            @if($item->status == 'selesai' && $item->file_hasil)
                                                <a href="{{ Storage::url($item->file_hasil) }}" target="_blank" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 shadow-sm transition">
                                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                    Unduh Surat
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    @if($item->keterangan_admin)
                                        <div class="mt-4 pt-4 border-t border-gray-200">
                                            <p class="text-sm font-medium text-gray-600">Catatan dari Admin:</p>
                                            <p class="text-sm text-gray-800 bg-gray-100 p-3 rounded-lg mt-1">{{ $item->keterangan_admin }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-10">
                        {{ $permohonan->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center bg-white rounded-2xl shadow-lg p-12">
                        <img src="{{ asset('img/empty-state.svg') }}" alt="Tidak ada data" class="w-48 mx-auto mb-6">
                        <h3 class="text-2xl font-bold text-gray-800">Belum Ada Permohonan</h3>
                        <p class="text-gray-600 mt-2 mb-6 max-w-md mx-auto">Sepertinya Anda belum mengajukan permohonan apapun, atau tidak ada hasil yang cocok dengan filter Anda.</p>
                        <a href="{{ route('layanan.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Ajukan Permohonan Pertama Anda
                        </a>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
@endsection