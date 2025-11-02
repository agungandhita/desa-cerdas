<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermohonanSurat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PermohonanSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PermohonanSurat::with('user');

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan jenis surat
        if ($request->has('jenis_surat') && $request->jenis_surat != '') {
            $query->where('jenis_surat', 'like', '%' . $request->jenis_surat . '%');
        }

        // Filter berdasarkan tanggal
        if ($request->has('tanggal_dari') && $request->tanggal_dari != '') {
            $query->whereDate('tanggal_pengajuan', '>=', $request->tanggal_dari);
        }

        if ($request->has('tanggal_sampai') && $request->tanggal_sampai != '') {
            $query->whereDate('tanggal_pengajuan', '<=', $request->tanggal_sampai);
        }

        // Search berdasarkan nama user atau keperluan
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keperluan', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $permohonanSurat = $query->latest('tanggal_pengajuan')->paginate(10);

        // Statistics untuk dashboard
        $statistics = [
            'total' => PermohonanSurat::count(),
            'pending' => PermohonanSurat::where('status', 'pending')->count(),
            'diproses' => PermohonanSurat::where('status', 'diproses')->count(),
            'selesai' => PermohonanSurat::where('status', 'selesai')->count(),
            'ditolak' => PermohonanSurat::where('status', 'ditolak')->count(),
        ];

        return view('admin.permohonan-surat.index', compact('permohonanSurat', 'statistics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        $jenisSurat = [
            'Surat Keterangan Domisili',
            'Surat Keterangan Tidak Mampu',
            'Surat Keterangan Usaha',
            'Surat Pengantar KTP',
            'Surat Pengantar KK',
            'Surat Keterangan Kelahiran',
            'Surat Keterangan Kematian',
            'Surat Keterangan Pindah',
            'Surat Keterangan Nikah',
            'Surat Keterangan Belum Menikah',
            'Lainnya'
        ];

        return view('admin.permohonan-surat.create', compact('users', 'jenisSurat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_surat' => 'required|string|max:255',
            'keperluan' => 'required|string',
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'tanggal_selesai' => 'nullable|date',
        ]);

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('file_pdf')) {
            $file = $request->file('file_pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['file_pdf'] = $file->storeAs('permohonan-surat', $filename, 'public');
        }

        // Set tanggal_pengajuan jika belum ada
        if (!isset($data['tanggal_pengajuan'])) {
            $data['tanggal_pengajuan'] = now();
        }

        PermohonanSurat::create($data);

        Alert::success('Berhasil', 'Permohonan surat berhasil ditambahkan');
        return redirect()->route('admin.permohonan-surat.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PermohonanSurat $permohonanSurat)
    {
        $permohonanSurat->load('user');
        return view('admin.permohonan-surat.show', compact('permohonanSurat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PermohonanSurat $permohonanSurat)
    {
        $users = User::orderBy('name')->get();
        $jenisSurat = [
            'Surat Keterangan Domisili',
            'Surat Keterangan Tidak Mampu',
            'Surat Keterangan Usaha',
            'Surat Pengantar KTP',
            'Surat Pengantar KK',
            'Surat Keterangan Kelahiran',
            'Surat Keterangan Kematian',
            'Surat Keterangan Pindah',
            'Surat Keterangan Nikah',
            'Surat Keterangan Belum Menikah',
            'Lainnya'
        ];

        return view('admin.permohonan-surat.edit', compact('permohonanSurat', 'users', 'jenisSurat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PermohonanSurat $permohonanSurat)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_surat' => 'required|string|max:255',
            'keperluan' => 'required|string',
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'tanggal_selesai' => 'nullable|date',
        ]);

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('file_pdf')) {
            // Delete old file if exists
            if ($permohonanSurat->file_pdf && Storage::disk('public')->exists($permohonanSurat->file_pdf)) {
                Storage::disk('public')->delete($permohonanSurat->file_pdf);
            }

            $file = $request->file('file_pdf');
            $filename = time() . '_' . $file->getClientOriginalName();
            $data['file_pdf'] = $file->storeAs('permohonan-surat', $filename, 'public');
        }

        // Set tanggal_selesai otomatis jika status berubah ke selesai
        if ($request->status == 'selesai' && $permohonanSurat->status != 'selesai') {
            $data['tanggal_selesai'] = now();
        }

        $permohonanSurat->update($data);

        Alert::success('Berhasil', 'Permohonan surat berhasil diperbarui');
        return redirect()->route('admin.permohonan-surat.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PermohonanSurat $permohonanSurat)
    {
        // Delete file if exists
        if ($permohonanSurat->file_pdf && Storage::disk('public')->exists($permohonanSurat->file_pdf)) {
            Storage::disk('public')->delete($permohonanSurat->file_pdf);
        }

        $permohonanSurat->delete();

        Alert::success('Berhasil', 'Permohonan surat berhasil dihapus');
        return redirect()->route('admin.permohonan-surat.index');
    }

    /**
     * Update status permohonan surat
     */
    public function updateStatus(Request $request, PermohonanSurat $permohonanSurat)
    {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $data = [
            'status' => $request->status,
            'catatan' => $request->catatan,
        ];

        // Set tanggal_selesai jika status berubah ke selesai
        if ($request->status == 'selesai' && $permohonanSurat->status != 'selesai') {
            $data['tanggal_selesai'] = now();
        }

        $permohonanSurat->update($data);

        Alert::success('Berhasil', 'Status permohonan surat berhasil diperbarui');
        return back();
    }

    /**
     * Download file PDF
     */
    public function downloadPdf(PermohonanSurat $permohonanSurat)
    {
        if (!$permohonanSurat->file_pdf || !Storage::disk('public')->exists($permohonanSurat->file_pdf)) {
            Alert::error('Error', 'File tidak ditemukan');
            return back();
        }

        $filePath = storage_path('app/public/' . $permohonanSurat->file_pdf);
        return response()->download($filePath);
    }

    /**
     * Export data to Excel/CSV
     */
    public function export(Request $request)
    {
        // This can be implemented later with Laravel Excel package
        Alert::info('Info', 'Fitur export akan segera tersedia');
        return back();
    }
}