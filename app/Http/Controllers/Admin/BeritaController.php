<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Berita::with('author');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
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

        // Search berdasarkan judul atau isi
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

        $berita = $query->latest('created_at')->paginate(10);

        // Statistics untuk dashboard
        $statistics = [
            'total' => Berita::count(),
            'published' => Berita::where('status', 'published')->count(),
            'draft' => Berita::where('status', 'draft')->count(),
            'featured' => Berita::where('is_featured', true)->count(),
        ];

        return view('admin.berita.index', compact('berita', 'statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['author_id'] = Auth::id();
        $data['is_featured'] = $request->has('is_featured');

        // Handle cover image upload
        if ($request->hasFile('cover')) {
            $file = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['cover'] = $file->storeAs('berita/covers', $filename, 'public');
        }

        // Set published_at jika status published
        if ($request->status == 'published' && !$request->published_at) {
            $data['published_at'] = now();
        }

        Berita::create($data);

        Alert::success('Berhasil', 'Berita berhasil ditambahkan');
        return redirect()->route('admin.berita.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Berita $berita)
    {
        $berita->load('author');
        return view('admin.berita.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Berita $berita)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['is_featured'] = $request->has('is_featured');

        // Handle cover image upload
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($berita->cover && Storage::disk('public')->exists($berita->cover)) {
                Storage::disk('public')->delete($berita->cover);
            }

            $file = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['cover'] = $file->storeAs('berita/covers', $filename, 'public');
        }

        // Set published_at jika status berubah ke published
        if ($request->status == 'published' && $berita->status != 'published') {
            $data['published_at'] = $request->published_at ?: now();
        }

        $berita->update($data);

        Alert::success('Berhasil', 'Berita berhasil diperbarui');
        return redirect()->route('admin.berita.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Berita $berita)
    {
        // Delete cover image if exists
        if ($berita->cover && Storage::disk('public')->exists($berita->cover)) {
            Storage::disk('public')->delete($berita->cover);
        }

        $berita->delete();

        Alert::success('Berhasil', 'Berita berhasil dihapus');
        return redirect()->route('admin.berita.index');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Berita $berita)
    {
        $berita->update([
            'is_featured' => !$berita->is_featured
        ]);

        $status = $berita->is_featured ? 'ditampilkan' : 'tidak ditampilkan';
        Alert::success('Berhasil', "Berita berhasil {$status} sebagai featured");
        return back();
    }

    /**
     * Update status berita
     */
    public function updateStatus(Request $request, Berita $berita)
    {
        $request->validate([
            'status' => 'required|in:draft,published',
        ]);

        $data = [
            'status' => $request->status,
        ];

        // Set published_at jika status berubah ke published
        if ($request->status == 'published' && $berita->status != 'published') {
            $data['published_at'] = now();
        }

        $berita->update($data);

        Alert::success('Berhasil', 'Status berita berhasil diperbarui');
        return back();
    }

    /**
     * Upload image for Froala editor
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);

        try {
            $file = $request->file('file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('berita/images', $filename, 'public');
            
            return response()->json([
                'link' => Storage::url($path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload file for Froala editor
     */
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB
        ]);

        try {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('berita/files', $filename, 'public');
            
            return response()->json([
                'link' => Storage::url($path)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}