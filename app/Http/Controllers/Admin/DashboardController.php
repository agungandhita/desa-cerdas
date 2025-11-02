<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PermohonanSurat;
use App\Models\Berita;
use App\Models\Forum;
use App\Models\ProdukUmkm;
use App\Models\LokasiDesa;
use App\Models\Apbdes;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics for Desa Cerdas
        $totalUsers = User::count();
        $totalPermohonanSurat = PermohonanSurat::count();
        $totalBerita = Berita::count();
        $totalForum = Forum::count();
        $totalProdukUmkm = ProdukUmkm::count();
        $totalLokasiDesa = LokasiDesa::count();
        
        // Recent data
        $recentPermohonanSurat = PermohonanSurat::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        $recentBerita = Berita::with('author')
            ->latest()
            ->take(5)
            ->get();
            
        $recentForum = Forum::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        // Statistics by status
        $permohonanStats = [
            'pending' => PermohonanSurat::where('status', 'pending')->count(),
            'diproses' => PermohonanSurat::where('status', 'diproses')->count(),
            'selesai' => PermohonanSurat::where('status', 'selesai')->count(),
            'ditolak' => PermohonanSurat::where('status', 'ditolak')->count(),
        ];
        
        // Pending count for sidebar
        $pendingCount = PermohonanSurat::where('status', 'pending')->count();
        
        $beritaStats = [
            'published' => Berita::where('status', 'published')->count(),
            'draft' => Berita::where('status', 'draft')->count(),
        ];
        
        // Monthly statistics
        $permohonanBulanIni = PermohonanSurat::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $beritaBulanIni = Berita::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $forumBulanIni = Forum::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalPermohonanSurat',
            'totalBerita',
            'totalForum',
            'totalProdukUmkm',
            'totalLokasiDesa',
            'recentPermohonanSurat',
            'recentBerita',
            'recentForum',
            'permohonanStats',
            'beritaStats',
            'permohonanBulanIni',
            'beritaBulanIni',
            'forumBulanIni',
            'pendingCount'
        ));
    }
}
