@extends('frontend.layouts.main')

@section('container')
    <div class="container mx-auto py-8">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-green-500 to-emerald-400 text-white rounded-lg shadow-lg p-8 mb-8">
            <h1 class="text-4xl font-bold mb-2">Ringkasan Anggaran Desa</h1>
            <p class="text-lg">Ringkasan umum anggaran desa selama beberapa tahun terakhir.</p>
        </div>

        <!-- Overall Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                <div class="bg-blue-100 text-blue-600 p-4 rounded-full mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Tahun Anggaran</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $overallStats['total_years'] }}</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                <div class="bg-green-100 text-green-600 p-4 rounded-full mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Bidang</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $overallStats['total_sectors'] }}</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                <div class="bg-yellow-100 text-yellow-600 p-4 rounded-full mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Program</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $overallStats['total_programs'] }}</p>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6 flex items-center">
                <div class="bg-purple-100 text-purple-600 p-4 rounded-full mr-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Anggaran {{ $currentYear }}</p>
                    <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($overallStats['current_year_budget'], 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Yearly Summary -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Ringkasan Tahunan (5 Tahun Terakhir)</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Anggaran</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Realisasi</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Persentase</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($yearlySummary as $summary)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $summary->tahun }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 text-right">Rp {{ number_format($summary->total_anggaran, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 text-right">Rp {{ number_format($summary->total_realisasi, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-right">
                                        @php
                                            $percentage = $summary->total_anggaran > 0 ? ($summary->total_realisasi / $summary->total_anggaran) * 100 : 0;
                                        @endphp
                                        <span class="font-semibold {{ $percentage >= 80 ? 'text-green-600' : ($percentage >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ number_format($percentage, 2, ',', '.') }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">Data ringkasan tahunan tidak tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sector Summary for Current Year -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Ringkasan per Bidang ({{ $currentYear }})</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bidang</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Anggaran</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Jumlah Program</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($sectorSummary as $summary)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $summary->bidang }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 text-right">Rp {{ number_format($summary->total_anggaran, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 text-right">{{ $summary->jumlah_program }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">Data ringkasan bidang tidak tersedia untuk tahun ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
