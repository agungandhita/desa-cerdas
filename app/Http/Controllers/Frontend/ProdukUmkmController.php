<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProdukUmkm;
use Illuminate\Http\Request;

class ProdukUmkmController extends Controller
{
    /**
     * Display a listing of active UMKM products
     */
    public function index(Request $request)
    {
        $query = ProdukUmkm::where('status', 'aktif')->with('user');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter by category
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Filter by price range
        if ($request->has('harga_min') && $request->harga_min != '') {
            $query->where('harga', '>=', $request->harga_min);
        }

        if ($request->has('harga_max') && $request->harga_max != '') {
            $query->where('harga', '<=', $request->harga_max);
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured == '1') {
            $query->where('is_featured', true);
        }

        // Sorting
        $sortBy = $request->get('sort', 'terbaru');
        switch ($sortBy) {
            case 'harga_terendah':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_tertinggi':
                $query->orderBy('harga', 'desc');
                break;
            case 'nama':
                $query->orderBy('nama', 'asc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('is_featured', 'desc')
                      ->orderBy('created_at', 'desc');
                break;
        }

        $produkUmkm = $query->paginate(12);

        // Get categories for filter
        $categories = ProdukUmkm::where('status', 'aktif')
            ->select('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->sort();

        // Get featured products for sidebar
        $featuredProduk = ProdukUmkm::where('status', 'aktif')
            ->where('is_featured', true)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.umkm.index', compact('produkUmkm', 'categories', 'featuredProduk', 'sortBy'));
    }

    /**
     * Display the specified UMKM product
     */
    public function show($slug)
    {
        $produk = ProdukUmkm::where('slug', $slug)
            ->where('status', 'aktif')
            ->with('user')
            ->firstOrFail();

        // Get related products from same category or same owner
        $relatedProduk = ProdukUmkm::where('status', 'aktif')
            ->where('id', '!=', $produk->id)
            ->where(function($query) use ($produk) {
                $query->where('kategori', $produk->kategori)
                      ->orWhere('user_id', $produk->user_id);
            })
            ->with('user')
            ->latest()
            ->take(4)
            ->get();

        // Get other products from same owner
        $ownerProducts = ProdukUmkm::where('status', 'aktif')
            ->where('user_id', $produk->user_id)
            ->where('id', '!=', $produk->id)
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.umkm.show', compact('produk', 'relatedProduk', 'ownerProducts'));
    }

    /**
     * Display products by category
     */
    public function category(Request $request, $kategori)
    {
        $query = ProdukUmkm::where('status', 'aktif')
            ->where('kategori', $kategori)
            ->with('user');

        // Search within category
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $produkUmkm = $query->orderBy('is_featured', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(12);

        return view('frontend.umkm.category', compact('produkUmkm', 'kategori'));
    }

    /**
     * Display products by owner/seller
     */
    public function seller($userId)
    {
        $seller = \App\Models\User::findOrFail($userId);
        
        $produkUmkm = ProdukUmkm::where('status', 'aktif')
            ->where('user_id', $userId)
            ->with('user')
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('frontend.umkm.seller', compact('produkUmkm', 'seller'));
    }
}