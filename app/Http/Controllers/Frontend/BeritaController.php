<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Display a listing of published news
     */
    public function index(Request $request)
    {
        $query = Berita::where('status', 'published')->with('author');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('isi', 'like', '%' . $search . '%')
                  ->orWhereHas('author', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured == '1') {
            $query->where('is_featured', true);
        }

        // Filter by date range
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('created_at', $request->tahun);
        }

        $berita = $query->orderBy('is_featured', 'desc')
                       ->orderBy('created_at', 'desc')
                       ->paginate(12);

        // Get featured news for sidebar
        $featuredBerita = Berita::where('status', 'published')
            ->where('is_featured', true)
            ->with('author')
            ->latest()
            ->take(5)
            ->get();

        // Get recent news for sidebar
        $recentBerita = Berita::where('status', 'published')
            ->with('author')
            ->latest()
            ->take(5)
            ->get();

        // Categories and tags are not implemented in the current schema.
        // Pass empty collections to avoid undefined variable errors in the view.
        $categories = collect();
        $tags = collect();

        return view('frontend.berita.index', compact('berita', 'featuredBerita', 'recentBerita', 'categories', 'tags'));
    }

    /**
     * Display the specified news article
     */
    public function show($slug)
    {
        $berita = Berita::where('slug', $slug)
            ->where('status', 'published')
            ->with('author')
            ->firstOrFail();

        // Get related news
        $relatedBerita = Berita::where('status', 'published')
            ->where('id', '!=', $berita->id)
            ->with('author')
            ->latest()
            ->take(4)
            ->get();

        // Get recent news for sidebar
        $recentBerita = Berita::where('status', 'published')
            ->where('id', '!=', $berita->id)
            ->with('author')
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.berita.show', compact('berita', 'relatedBerita', 'recentBerita'));
    }

    /**
     * Get news by category or tag (if implemented)
     */
    public function category(Request $request, $category = null)
    {
        $query = Berita::where('status', 'published')->with('author');

        if ($category) {
            // Assuming you have a category field or relationship
            // NOTE: No kategori field exists currently; this is a placeholder.
            // $query->where('kategori', $category);
        }

        $berita = $query->orderBy('is_featured', 'desc')
                       ->orderBy('created_at', 'desc')
                       ->paginate(12);

        return view('frontend.berita.category', compact('berita', 'category'));
    }
}