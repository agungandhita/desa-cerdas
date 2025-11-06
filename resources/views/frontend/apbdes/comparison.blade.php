@extends('frontend.layouts.main')

@section('container')
    <div class="container mx-auto py-8">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-500 to-teal-400 text-white rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-4xl font-bold mb-2">Perbandingan Anggaran Desa</h1>
            <p class="text-lg">Analisis perbandingan anggaran antara tahun {{ $year1 }} dan {{ $year2 }}.</p>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <form action="{{ route('apbdes.comparison') }}" method="GET" class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                <div class="flex-1">
                    <label for="tahun1" class="block text-sm font-medium text-gray-700 mb-1">Tahun 1</label>
                    <select name="tahun1" id="tahun1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" @if($year == $year1) selected @endif>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1">
                    <label for="tahun2" class="block text-sm font-medium text-gray-700 mb-1">Tahun 2</label>
                    <select name="tahun2" id="tahun2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @foreach($availableYears as $year)
                            <option value="{{ $year }}" @if($year == $year2) selected @endif>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="pt-5">
                    <button type="submit" class="w-full md:w-auto bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                        Bandingkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Comparison Table -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bidang</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Anggaran {{ $year1 }}</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Realisasi {{ $year1 }}</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Anggaran {{ $year2 }}</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Realisasi {{ $year2 }}</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Selisih Anggaran</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Perubahan (%)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($comparison as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item['bidang'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-right">Rp {{ number_format($item['anggaran_' . $year1], 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-right">Rp {{ number_format($item['realisasi_' . $year1], 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-right">Rp {{ number_format($item['anggaran_' . $year2], 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-right">Rp {{ number_format($item['realisasi_' . $year2], 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                    <span class="{{ $item['selisih_anggaran'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($item['selisih_anggaran'], 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                    <span class="{{ $item['persentase_perubahan'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($item['persentase_perubahan'], 2, ',', '.') }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m-9 8h12a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        <p class="text-lg font-semibold">Data perbandingan tidak ditemukan.</p>
                                        <p class="text-sm">Silakan pilih tahun yang berbeda untuk perbandingan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
