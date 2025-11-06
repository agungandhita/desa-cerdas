@extends('frontend.layouts.main')

@section('container')
    <div class="container mx-auto py-8">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-4xl font-bold mb-2">Transparansi Anggaran Desa</h1>
            <p class="text-lg">Informasi APBDes (Anggaran Pendapatan dan Belanja Desa) tahun {{ $selectedYear }}.</p>
        </div>

        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 text-sm">Total Anggaran</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($statistics['total_anggaran'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 text-sm">Total Realisasi</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($statistics['total_realisasi'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 text-sm">Persentase Realisasi</p>
                <p class="text-2xl font-bold text-{{ $statistics['persentase_realisasi'] >= 80 ? 'green' : ($statistics['persentase_realisasi'] >= 50 ? 'yellow' : 'red') }}-600">{{ number_format($statistics['persentase_realisasi'], 2, ',', '.') }}%</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <p class="text-gray-600 text-sm">Jumlah Bidang</p>
                <p class="text-2xl font-bold text-gray-800">{{ $statistics['total_bidang'] }}</p>
            </div>
        </div>

        <!-- Filter and Search Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form action="{{ route('apbdes.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <select name="tahun" id="tahun" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" @if($year == $selectedYear) selected @endif>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="bidang" class="block text-sm font-medium text-gray-700">Bidang</label>
                    <select name="bidang" id="bidang" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Semua Bidang</option>
                        @foreach($availableBidang as $bidang)
                            <option value="{{ $bidang }}" @if(request('bidang') == $bidang) selected @endif>{{ $bidang }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-indigo-600 text-white font-semibold px-4 py-2 rounded-lg shadow-md hover:bg-indigo-700 transition-colors">Filter</button>
                </div>
            </form>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Anggaran</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bidang</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Anggaran</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Realisasi</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($apbdes as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->bidang }}</td>
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
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <p class="text-lg font-semibold">Data anggaran tidak ditemukan.</p>
                                    <p class="text-sm">Silakan ubah filter atau coba lagi nanti.</p>
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
