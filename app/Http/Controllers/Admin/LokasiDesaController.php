<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LokasiDesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class LokasiDesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LokasiDesa::query();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        // Search berdasarkan nama, alamat, atau deskripsi
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('alamat', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        }

        $lokasiDesa = $query->latest('created_at')->paginate(10);

        // Statistics untuk dashboard
        $statistics = [
            'total' => LokasiDesa::count(),
            'active' => LokasiDesa::where('status', 'active')->count(),
            'inactive' => LokasiDesa::where('status', 'inactive')->count(),
            'has_coordinates' => LokasiDesa::whereNotNull('latitude')->whereNotNull('longitude')->count(),
        ];

        // Data untuk filter
        $kategoris = [
            'fasilitas_umum' => 'Fasilitas Umum',
            'wisata' => 'Wisata',
            'pemerintahan' => 'Pemerintahan',
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'ibadah' => 'Tempat Ibadah',
            'olahraga' => 'Olahraga',
            'ekonomi' => 'Ekonomi',
            'lainnya' => 'Lainnya',
        ];

        return view('admin.lokasi-desa.index', compact('lokasiDesa', 'statistics', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = [
            'fasilitas_umum' => 'Fasilitas Umum',
            'wisata' => 'Wisata',
            'pemerintahan' => 'Pemerintahan',
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'ibadah' => 'Tempat Ibadah',
            'olahraga' => 'Olahraga',
            'ekonomi' => 'Ekonomi',
            'lainnya' => 'Lainnya',
        ];

        return view('admin.lokasi-desa.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'alamat' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'deskripsi' => 'nullable|string',
            'kontak' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle multiple file uploads
        if ($request->hasFile('foto')) {
            $fotoPaths = [];
            foreach ($request->file('foto') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('lokasi-desa', $filename, 'public');
                $fotoPaths[] = $path;
            }
            $data['foto'] = $fotoPaths;
        }

        LokasiDesa::create($data);

        Alert::success('Berhasil', 'Lokasi desa berhasil ditambahkan');
        return redirect()->route('admin.lokasi-desa.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(LokasiDesa $lokasiDesa)
    {
        return view('admin.lokasi-desa.show', compact('lokasiDesa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LokasiDesa $lokasiDesa)
    {
        $kategoris = [
            'fasilitas_umum' => 'Fasilitas Umum',
            'wisata' => 'Wisata',
            'pemerintahan' => 'Pemerintahan',
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'ibadah' => 'Tempat Ibadah',
            'olahraga' => 'Olahraga',
            'ekonomi' => 'Ekonomi',
            'lainnya' => 'Lainnya',
        ];

        return view('admin.lokasi-desa.edit', compact('lokasiDesa', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LokasiDesa $lokasiDesa)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'alamat' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'deskripsi' => 'nullable|string',
            'kontak' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Handle multiple file uploads
        if ($request->hasFile('foto')) {
            // Delete old photos if exists
            if ($lokasiDesa->foto && is_array($lokasiDesa->foto)) {
                foreach ($lokasiDesa->foto as $oldPhoto) {
                    if (Storage::disk('public')->exists($oldPhoto)) {
                        Storage::disk('public')->delete($oldPhoto);
                    }
                }
            }

            $fotoPaths = [];
            foreach ($request->file('foto') as $file) {
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('lokasi-desa', $filename, 'public');
                $fotoPaths[] = $path;
            }
            $data['foto'] = $fotoPaths;
        } else {
            // Keep existing photos if no new photos uploaded
            unset($data['foto']);
        }

        $lokasiDesa->update($data);

        Alert::success('Berhasil', 'Lokasi desa berhasil diperbarui');
        return redirect()->route('admin.lokasi-desa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LokasiDesa $lokasiDesa)
    {
        // Delete associated photos
        if ($lokasiDesa->foto && is_array($lokasiDesa->foto)) {
            foreach ($lokasiDesa->foto as $photo) {
                if (Storage::disk('public')->exists($photo)) {
                    Storage::disk('public')->delete($photo);
                }
            }
        }

        $lokasiDesa->delete();

        Alert::success('Berhasil', 'Lokasi desa berhasil dihapus');
        return redirect()->route('admin.lokasi-desa.index');
    }

    /**
     * Update status of the specified resource.
     */
    public function updateStatus(Request $request, LokasiDesa $lokasiDesa)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $lokasiDesa->update(['status' => $request->status]);

        Alert::success('Berhasil', 'Status lokasi desa berhasil diperbarui');
        return redirect()->back();
    }

    /**
     * Delete specific photo from lokasi desa
     */
    public function deletePhoto(Request $request, LokasiDesa $lokasiDesa)
    {
        $request->validate([
            'photo_index' => 'required|integer|min:0'
        ]);

        $photoIndex = $request->photo_index;
        $photos = $lokasiDesa->foto;

        if (is_array($photos) && isset($photos[$photoIndex])) {
            // Delete file from storage
            if (Storage::disk('public')->exists($photos[$photoIndex])) {
                Storage::disk('public')->delete($photos[$photoIndex]);
            }

            // Remove from array
            unset($photos[$photoIndex]);
            $photos = array_values($photos); // Re-index array

            $lokasiDesa->update(['foto' => $photos]);

            Alert::success('Berhasil', 'Foto berhasil dihapus');
        } else {
            Alert::error('Error', 'Foto tidak ditemukan');
        }

        return redirect()->back();
    }
}