<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProdukUmkm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukUmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProdukUmkm::with('user');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Filter berdasarkan featured
        if ($request->has('is_featured') && $request->is_featured != '') {
            $query->where('is_featured', $request->is_featured == '1');
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        // Search berdasarkan nama produk atau pemilik
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

        $produkUmkm = $query->orderBy('created_at', 'desc')->paginate(10);

        // Data untuk filter
        $kategoris = ProdukUmkm::distinct()->pluck('kategori')->filter();
        $users = User::orderBy('name')->get();

        return view('admin.produk-umkm.index', compact('produkUmkm', 'kategoris', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.produk-umkm.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'kontak' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,pending',
            'is_featured' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');

        // Handle multiple photo uploads
        if ($request->hasFile('foto')) {
            $fotoPaths = [];
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('produk-umkm', 'public');
                $fotoPaths[] = $path;
            }
            $data['foto'] = $fotoPaths;
        }

        ProdukUmkm::create($data);

        Alert::success('Berhasil', 'Produk UMKM berhasil ditambahkan');
        return redirect()->route('admin.produk-umkm.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProdukUmkm $produkUmkm)
    {
        $produkUmkm->load('user');
        return view('admin.produk-umkm.show', compact('produkUmkm'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProdukUmkm $produkUmkm)
    {
        $users = User::orderBy('name')->get();
        return view('admin.produk-umkm.edit', compact('produkUmkm', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProdukUmkm $produkUmkm)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'kontak' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,pending',
            'is_featured' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');

        // Handle multiple photo uploads
        if ($request->hasFile('foto')) {
            // Delete old photos
            if ($produkUmkm->foto) {
                foreach ($produkUmkm->foto as $oldFoto) {
                    Storage::disk('public')->delete($oldFoto);
                }
            }

            $fotoPaths = [];
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('produk-umkm', 'public');
                $fotoPaths[] = $path;
            }
            $data['foto'] = $fotoPaths;
        }

        $produkUmkm->update($data);

        Alert::success('Berhasil', 'Produk UMKM berhasil diperbarui');
        return redirect()->route('admin.produk-umkm.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProdukUmkm $produkUmkm)
    {
        // Delete photos
        if ($produkUmkm->foto) {
            foreach ($produkUmkm->foto as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        $produkUmkm->delete();

        Alert::success('Berhasil', 'Produk UMKM berhasil dihapus');
        return redirect()->route('admin.produk-umkm.index');
    }

    /**
     * Update status of the specified resource.
     */
    public function updateStatus(Request $request, ProdukUmkm $produkUmkm)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,pending'
        ]);

        $produkUmkm->update(['status' => $request->status]);

        Alert::success('Berhasil', 'Status produk berhasil diperbarui');
        return redirect()->back();
    }

    /**
     * Toggle featured status of the specified resource.
     */
    public function toggleFeatured(ProdukUmkm $produkUmkm)
    {
        $produkUmkm->update(['is_featured' => !$produkUmkm->is_featured]);

        $message = $produkUmkm->is_featured ? 'Produk berhasil ditandai sebagai unggulan' : 'Produk berhasil dihapus dari unggulan';
        Alert::success('Berhasil', $message);
        return redirect()->back();
    }

    /**
     * Upload image for Froala editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $path = $request->file('file')->store('produk-umkm/editor', 'public');
        
        return response()->json([
            'link' => Storage::url($path)
        ]);
    }

    /**
     * Upload file for Froala editor
     */
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240' // 10MB max
        ]);

        $path = $request->file('file')->store('produk-umkm/files', 'public');
        
        return response()->json([
            'link' => Storage::url($path)
        ]);
    }
}