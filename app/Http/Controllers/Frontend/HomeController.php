<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\ProdukUmkm;
use App\Models\LokasiDesa;
use App\Models\Forum;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Get featured content for homepage
        $featuredBerita = Berita::where('status', 'published')
            ->where('is_featured', true)
            ->with('author')
            ->latest()
            ->take(3)
            ->get();

        $featuredProdukUmkm = ProdukUmkm::where('status', 'aktif')
            ->where('is_featured', true)
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

        $recentBerita = Berita::where('status', 'published')
            ->with('author')
            ->latest()
            ->take(6)
            ->get();

        $recentForum = Forum::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Statistics for public display
        $statistics = [
            'total_berita' => Berita::where('status', 'published')->count(),
            'total_produk_umkm' => ProdukUmkm::where('status', 'aktif')->count(),
            'total_forum' => Forum::count(),
            'total_lokasi' => LokasiDesa::count(),
        ];

        return view('frontend.beranda.index', compact(
            'featuredBerita',
            'featuredProdukUmkm', 
            'recentBerita',
            'recentForum',
            'statistics'
        ));
    }

    /**
     * Display about page
     */
    public function about()
    {
        $lokasiDesa = LokasiDesa::first();
        
        return view('frontend.tentang.index', compact('lokasiDesa'));
    }

    /**
     * Display contact page
     */
    public function contact()
    {
        $lokasiDesa = LokasiDesa::first();
        
        return view('frontend.kontak.index', compact('lokasiDesa'));
    }
}