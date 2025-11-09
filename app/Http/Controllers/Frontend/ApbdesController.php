<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Apbdes;
use Illuminate\Http\Request;

class ApbdesController extends Controller
{
    /**
     * Display village budget information (APBDes)
     */
    public function index(Request $request)
    {
        $query = Apbdes::whereIn('status', ['approved', 'executed']);

        // Filter by year
        $selectedYear = $request->get('tahun', date('Y'));
        $query->where('tahun', $selectedYear);

        // Filter by bidang/sector
        if ($request->has('bidang') && $request->bidang != '') {
            $query->where('bidang', 'like', '%' . $request->bidang . '%');
        }

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('bidang', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $apbdes = $query->orderBy('bidang', 'asc')
                       ->orderBy('jumlah_anggaran', 'desc')
                       ->paginate(15);

        // Get available years
        $availableYears = Apbdes::whereIn('status', ['approved', 'executed'])
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        // Get available sectors/bidang
        $availableBidang = Apbdes::whereIn('status', ['approved', 'executed'])
            ->where('tahun', $selectedYear)
            ->select('bidang')
            ->distinct()
            ->orderBy('bidang', 'asc')
            ->pluck('bidang');

        // Calculate statistics for selected year
        $statistics = [
            'total_anggaran' => Apbdes::whereIn('status', ['approved', 'executed'])
                ->where('tahun', $selectedYear)
                ->sum('jumlah_anggaran'),
            'total_realisasi' => Apbdes::whereIn('status', ['approved', 'executed'])
                ->where('tahun', $selectedYear)
                ->sum('realisasi'),
            'total_bidang' => Apbdes::whereIn('status', ['approved', 'executed'])
                ->where('tahun', $selectedYear)
                ->distinct('bidang')
                ->count('bidang'),
            'persentase_realisasi' => 0
        ];

        // Calculate realization percentage
        if ($statistics['total_anggaran'] > 0) {
            $statistics['persentase_realisasi'] = round(
                ($statistics['total_realisasi'] / $statistics['total_anggaran']) * 100, 
                2
            );
        }

        // Get budget by sector for chart
        $budgetBySector = Apbdes::whereIn('status', ['approved', 'executed'])
            ->where('tahun', $selectedYear)
            ->selectRaw('bidang, SUM(jumlah_anggaran) as total_anggaran, SUM(realisasi) as total_realisasi')
            ->groupBy('bidang')
            ->orderBy('total_anggaran', 'desc')
            ->get();

        return view('frontend.apbdes.index', compact(
            'apbdes',
            'availableYears',
            'availableBidang',
            'selectedYear',
            'statistics',
            'budgetBySector'
        ));
    }

    /**
     * Display detailed budget information by sector
     */
    public function sector(Request $request, $bidang)
    {
        $selectedYear = $request->get('tahun', date('Y'));
        
        $apbdes = Apbdes::whereIn('status', ['approved', 'executed'])
            ->where('tahun', $selectedYear)
            ->where('bidang', $bidang)
            ->orderBy('jumlah_anggaran', 'desc')
            ->paginate(10);

        // Calculate sector statistics
        $sectorStats = [
            'total_anggaran' => Apbdes::whereIn('status', ['approved', 'executed'])
                ->where('tahun', $selectedYear)
                ->where('bidang', $bidang)
                ->sum('jumlah_anggaran'),
            'total_realisasi' => Apbdes::whereIn('status', ['approved', 'executed'])
                ->where('tahun', $selectedYear)
                ->where('bidang', $bidang)
                ->sum('realisasi'),
            'jumlah_program' => Apbdes::whereIn('status', ['approved', 'executed'])
                ->where('tahun', $selectedYear)
                ->where('bidang', $bidang)
                ->count()
        ];

        $sectorStats['persentase_realisasi'] = $sectorStats['total_anggaran'] > 0 
            ? round(($sectorStats['total_realisasi'] / $sectorStats['total_anggaran']) * 100, 2)
            : 0;

        // Get available years for this sector
        $availableYears = Apbdes::whereIn('status', ['approved', 'executed'])
            ->where('bidang', $bidang)
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('frontend.apbdes.sector', compact(
            'apbdes',
            'bidang',
            'selectedYear',
            'sectorStats',
            'availableYears'
        ));
    }

    /**
     * Display budget comparison between years
     */
    public function comparison(Request $request)
    {
        $year1 = $request->get('tahun1', date('Y') - 1);
        $year2 = $request->get('tahun2', date('Y'));

        // Get budget data for both years grouped by sector
        $budgetYear1 = Apbdes::whereIn('status', ['approved', 'executed'])
            ->where('tahun', $year1)
            ->selectRaw('bidang, SUM(jumlah_anggaran) as total_anggaran, SUM(realisasi) as total_realisasi')
            ->groupBy('bidang')
            ->get()
            ->keyBy('bidang');

        $budgetYear2 = Apbdes::whereIn('status', ['approved', 'executed'])
            ->where('tahun', $year2)
            ->selectRaw('bidang, SUM(jumlah_anggaran) as total_anggaran, SUM(realisasi) as total_realisasi')
            ->groupBy('bidang')
            ->get()
            ->keyBy('bidang');

        // Combine and calculate differences
        $allSectors = collect($budgetYear1->keys())
            ->merge($budgetYear2->keys())
            ->unique()
            ->sort();

        $comparison = [];
        foreach ($allSectors as $sector) {
            $budget1 = $budgetYear1->get($sector);
            $budget2 = $budgetYear2->get($sector);

            $anggaran1 = $budget1 ? $budget1->total_anggaran : 0;
            $anggaran2 = $budget2 ? $budget2->total_anggaran : 0;
            $realisasi1 = $budget1 ? $budget1->total_realisasi : 0;
            $realisasi2 = $budget2 ? $budget2->total_realisasi : 0;

            $comparison[] = [
                'bidang' => $sector,
                'anggaran_' . $year1 => $anggaran1,
                'anggaran_' . $year2 => $anggaran2,
                'realisasi_' . $year1 => $realisasi1,
                'realisasi_' . $year2 => $realisasi2,
                'selisih_anggaran' => $anggaran2 - $anggaran1,
                'persentase_perubahan' => $anggaran1 > 0 ? round((($anggaran2 - $anggaran1) / $anggaran1) * 100, 2) : 0
            ];
        }

        // Get available years
        $availableYears = Apbdes::whereIn('status', ['approved', 'executed'])
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('frontend.apbdes.comparison', compact(
            'comparison',
            'year1',
            'year2',
            'availableYears'
        ));
    }

    /**
     * Display budget summary and statistics
     */
    public function summary()
    {
        $currentYear = date('Y');
        
        // Get yearly summary
        $yearlySummary = Apbdes::whereIn('status', ['approved', 'executed'])
            ->selectRaw('tahun, SUM(jumlah_anggaran) as total_anggaran, SUM(realisasi) as total_realisasi')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->take(5)
            ->get();

        // Get current year sector summary
        $sectorSummary = Apbdes::whereIn('status', ['approved', 'executed'])
            ->where('tahun', $currentYear)
            ->selectRaw('bidang, SUM(jumlah_anggaran) as total_anggaran, SUM(realisasi) as total_realisasi, COUNT(*) as jumlah_program')
            ->groupBy('bidang')
            ->orderBy('total_anggaran', 'desc')
            ->get();

        // Overall statistics
        $overallStats = [
            'total_years' => Apbdes::whereIn('status', ['approved', 'executed'])->distinct('tahun')->count('tahun'),
            'total_sectors' => Apbdes::whereIn('status', ['approved', 'executed'])->distinct('bidang')->count('bidang'),
            'total_programs' => Apbdes::whereIn('status', ['approved', 'executed'])->count(),
            'current_year_budget' => Apbdes::whereIn('status', ['approved', 'executed'])->where('tahun', $currentYear)->sum('jumlah_anggaran')
        ];

        return view('frontend.apbdes.summary', compact(
            'yearlySummary',
            'sectorSummary',
            'overallStats',
            'currentYear'
        ));
    }
}