<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apbdes;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ApbdesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Apbdes::query();

        // Filter berdasarkan tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        // Filter berdasarkan bidang
        if ($request->has('bidang') && $request->bidang != '') {
            $query->where('bidang', 'like', '%' . $request->bidang . '%');
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search berdasarkan bidang atau deskripsi
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('bidang', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $apbdes = $query->orderBy('tahun', 'desc')
                       ->orderBy('bidang', 'asc')
                       ->paginate(10);

        // Statistics
        $statistics = [
            'total' => Apbdes::count(),
            'total_anggaran' => Apbdes::sum('jumlah_anggaran'),
            'total_realisasi' => Apbdes::sum('realisasi'),
            'tahun_aktif' => Apbdes::distinct('tahun')->count(),
        ];

        // Get available years for filter
        $availableYears = Apbdes::distinct('tahun')
                                ->orderBy('tahun', 'desc')
                                ->pluck('tahun');

        // Get available bidang for filter
        $availableBidang = Apbdes::distinct('bidang')
                                 ->orderBy('bidang', 'asc')
                                 ->pluck('bidang');

        return view('admin.apbdes.index', compact('apbdes', 'statistics', 'availableYears', 'availableBidang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.apbdes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2020|max:2030',
            'bidang' => 'required|string|max:255',
            'jumlah_anggaran' => 'required|numeric|min:0',
            'realisasi' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:draft,aktif,selesai',
        ]);

        try {
            Apbdes::create($validated);
            Alert::success('Berhasil', 'Data APB Desa berhasil ditambahkan');
            return redirect()->route('admin.apbdes.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menyimpan data');
            return back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Apbdes $apbdes)
    {
        return view('admin.apbdes.show', compact('apbdes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apbdes $apbdes)
    {
        return view('admin.apbdes.edit', compact('apbdes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apbdes $apbdes)
    {
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2020|max:2030',
            'bidang' => 'required|string|max:255',
            'jumlah_anggaran' => 'required|numeric|min:0',
            'realisasi' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:draft,aktif,selesai',
        ]);

        try {
            $apbdes->update($validated);
            Alert::success('Berhasil', 'Data APB Desa berhasil diperbarui');
            return redirect()->route('admin.apbdes.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat memperbarui data');
            return back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apbdes $apbdes)
    {
        try {
            $apbdes->delete();
            Alert::success('Berhasil', 'Data APB Desa berhasil dihapus');
            return redirect()->route('admin.apbdes.index');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus data');
            return back();
        }
    }

    /**
     * Export APB Desa data to Excel
     */
    public function export(Request $request)
    {
        // This method can be implemented later with Excel export functionality
        Alert::info('Info', 'Fitur export akan segera tersedia');
        return back();
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics()
    {
        $currentYear = date('Y');
        
        $statistics = [
            'total_anggaran_tahun_ini' => Apbdes::where('tahun', $currentYear)->sum('jumlah_anggaran'),
            'total_realisasi_tahun_ini' => Apbdes::where('tahun', $currentYear)->sum('realisasi'),
            'persentase_realisasi' => 0,
            'jumlah_bidang' => Apbdes::where('tahun', $currentYear)->distinct('bidang')->count(),
        ];

        if ($statistics['total_anggaran_tahun_ini'] > 0) {
            $statistics['persentase_realisasi'] = ($statistics['total_realisasi_tahun_ini'] / $statistics['total_anggaran_tahun_ini']) * 100;
        }

        return response()->json($statistics);
    }
}