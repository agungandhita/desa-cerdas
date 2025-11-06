@extends('frontend.layouts.main')

@section('container')
    <div class="container mx-auto py-8">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-4xl font-bold mb-2">Detail Anggaran Bidang: {{ $bidang }}</h1>
            <p class="text-lg">Informasi rinci mengenai anggaran dan realisasi untuk bidang {{ $bidang }} pada tahun {{ $selectedYear }}.</p>
        </div>

        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 text-sm">Total Anggaran</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($sectorStats['total_anggaran'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 text-sm">Total Realisasi</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($sectorStats['total_realisasi'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 text-sm">Persentase Realisasi</p>
                <p class="text-2xl font-bold text-{{ $sectorStats['persentase_realisasi'] >= 80 ? 'green' : ($sectorStats['persentase_realisasi'] >= 50 ? 'yellow' : 'red') }}-600">{{ number_format($sectorStats['persentase_realisasi'], 2, ',', '.') }}%</p>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8 flex justify-between items-center">
            <a href="{{ route('apbdes.index') }}" class="text-blue-600 hover:underline">&larr; Kembali ke Semua Bidang</a>
            <form action="{{ route('apbdes.sector', ['bidang' => $bidang]) }}" method="GET">
                <div class="flex items-center space-x-4">
                    <div>
                        <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                        <select name="tahun" id="tahun" onchange="this.form.submit()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" @if($year == $selectedYear) selected @endif>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Program/Kegiatan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Anggaran</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Realisasi</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($apbdes as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-normal text-sm text-gray-700">{{ $item->deskripsi ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-right">Rp {{ number_format($item->jumlah_anggaran, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-right">Rp {{ number_format($item->realisasi, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $item->status == 'approved' ? 'green' : ($item->status == 'executed' ? 'blue' : 'yellow') }}-100 text-{{ $item->status == 'approved' ? 'green' : ($item->status == 'executed' ? 'blue' : 'yellow') }}-800">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <p class="text-lg font-semibold">Data untuk bidang ini tidak ditemukan.</p>
                                    <p class="text-sm">Silakan pilih tahun yang berbeda atau coba lagi nanti.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $apbdes->links() }}
            </div>
        </div>
    </div>
@endsection
