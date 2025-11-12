<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PermohonanSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LayananController extends Controller
{
    /**
     * Display available public services
     */
    public function index()
    {
        // Define available services
        $layanan = [
            [
                'nama' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Surat keterangan tempat tinggal/domisili',
                'persyaratan' => ['KTP', 'KK', 'Surat Pengantar RT/RW'],
                'icon' => 'home',
                'jenis' => 'surat_keterangan_domisili'
            ],
            [
                'nama' => 'Surat Keterangan Usaha',
                'deskripsi' => 'Surat keterangan untuk keperluan usaha',
                'persyaratan' => ['KTP', 'KK', 'Surat Keterangan Usaha dari RT/RW'],
                'icon' => 'briefcase',
                'jenis' => 'surat_keterangan_usaha'
            ],
            [
                'nama' => 'Surat Keterangan Tidak Mampu',
                'deskripsi' => 'Surat keterangan untuk keluarga tidak mampu',
                'persyaratan' => ['KTP', 'KK', 'Surat Pengantar RT/RW', 'Surat Keterangan Penghasilan'],
                'icon' => 'heart',
                'jenis' => 'surat_keterangan_tidak_mampu'
            ],
            [
                'nama' => 'Surat Pengantar Nikah',
                'deskripsi' => 'Surat pengantar untuk keperluan pernikahan',
                'persyaratan' => ['KTP', 'KK', 'Akta Kelahiran', 'Surat Pengantar RT/RW'],
                'icon' => 'users',
                'jenis' => 'surat_pengantar_nikah'
            ],
            [
                'nama' => 'Surat Keterangan Kelahiran',
                'deskripsi' => 'Surat keterangan untuk keperluan akta kelahiran',
                'persyaratan' => ['KTP Orang Tua', 'KK', 'Surat Keterangan Lahir dari Bidan/Dokter'],
                'icon' => 'baby',
                'jenis' => 'surat_keterangan_kelahiran'
            ],
            [
                'nama' => 'Surat Keterangan Kematian',
                'deskripsi' => 'Surat keterangan untuk keperluan akta kematian',
                'persyaratan' => ['KTP Pelapor', 'KK', 'Surat Keterangan Kematian dari Dokter/RS'],
                'icon' => 'cross',
                'jenis' => 'surat_keterangan_kematian'
            ]
        ];

        return view('frontend.layanan.index', compact('layanan'));
    }

    /**
     * Show form for creating a new service request
     */
    public function create($jenis = null)
    {
        if (!Auth::check()) {
            Alert::warning('Login Required', 'Silakan login terlebih dahulu untuk mengajukan permohonan surat.');
            return redirect()->route('login');
        }

        // Define service types
        $jenisLayanan = [
            'surat_keterangan_domisili' => 'Surat Keterangan Domisili',
            'surat_keterangan_usaha' => 'Surat Keterangan Usaha',
            'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'surat_pengantar_nikah' => 'Surat Pengantar Nikah',
            'surat_keterangan_kelahiran' => 'Surat Keterangan Kelahiran',
            'surat_keterangan_kematian' => 'Surat Keterangan Kematian'
        ];

        return view('frontend.layanan.create', compact('jenisLayanan', 'jenis'));
    }

    /**
     * Store a newly created service request
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            Alert::error('Error', 'Anda harus login terlebih dahulu.');
            return redirect()->route('login');
        }

        $request->validate([
            'jenis_surat' => 'required|string',
            'keperluan' => 'required|string|max:500',
            'keterangan_tambahan' => 'nullable|string|max:1000',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'user_id' => Auth::id(),
            'jenis_surat' => $request->jenis_surat,
            'keperluan' => $request->keperluan,
            'keterangan_tambahan' => $request->keterangan_tambahan,
            'tanggal_pengajuan' => now(),
            'status' => 'pending'
        ];

        // Handle file upload
        if ($request->hasFile('dokumen_pendukung')) {
            $file = $request->file('dokumen_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('dokumen_pendukung', $filename, 'public');
            $data['dokumen_pendukung'] = $path;
        }

        PermohonanSurat::create($data);

        Alert::success('Berhasil', 'Permohonan surat berhasil diajukan. Silakan tunggu konfirmasi dari petugas desa.');
        return redirect()->route('layanan.riwayat');
    }

    /**
     * Display user's service request history
     */
    public function riwayat()
    {
        if (!Auth::check()) {
            Alert::warning('Login Required', 'Silakan login terlebih dahulu untuk melihat riwayat permohonan.');
            return redirect()->route('login');
        }

        $permohonan = PermohonanSurat::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        // Define service types for filter options in the view
        $jenisLayanan = [
            'surat_keterangan_domisili' => 'Surat Keterangan Domisili',
            'surat_keterangan_usaha' => 'Surat Keterangan Usaha',
            'surat_keterangan_tidak_mampu' => 'Surat Keterangan Tidak Mampu',
            'surat_pengantar_nikah' => 'Surat Pengantar Nikah',
            'surat_keterangan_kelahiran' => 'Surat Keterangan Kelahiran',
            'surat_keterangan_kematian' => 'Surat Keterangan Kematian'
        ];

        return view('frontend.layanan.riwayat', compact('permohonan', 'jenisLayanan'));
    }

    /**
     * Display the specified service request
     */
    public function show($id)
    {
        if (!Auth::check()) {
            Alert::warning('Login Required', 'Silakan login terlebih dahulu.');
            return redirect()->route('login');
        }

        $permohonan = PermohonanSurat::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.layanan.show', compact('permohonan'));
    }

    /**
     * Show service information and requirements
     */
    public function info($jenis)
    {
        $layananInfo = [
            'surat_keterangan_domisili' => [
                'nama' => 'Surat Keterangan Domisili',
                'deskripsi' => 'Surat keterangan tempat tinggal/domisili yang digunakan untuk berbagai keperluan administrasi.',
                'persyaratan' => [
                    'Fotokopi KTP yang masih berlaku',
                    'Fotokopi Kartu Keluarga (KK)',
                    'Surat Pengantar dari RT/RW',
                    'Pas foto 3x4 (2 lembar)'
                ],
                'waktu_proses' => '3-5 hari kerja',
                'biaya' => 'Gratis'
            ],
            'surat_keterangan_usaha' => [
                'nama' => 'Surat Keterangan Usaha',
                'deskripsi' => 'Surat keterangan untuk keperluan usaha, perizinan, atau bantuan modal usaha.',
                'persyaratan' => [
                    'Fotokopi KTP yang masih berlaku',
                    'Fotokopi Kartu Keluarga (KK)',
                    'Surat Keterangan Usaha dari RT/RW',
                    'Foto lokasi usaha',
                    'Pas foto 3x4 (2 lembar)'
                ],
                'waktu_proses' => '3-5 hari kerja',
                'biaya' => 'Gratis'
            ],
            'surat_keterangan_tidak_mampu' => [
                'nama' => 'Surat Keterangan Tidak Mampu',
                'deskripsi' => 'Surat keterangan bagi keluarga/individu yang membutuhkan untuk keperluan bantuan sosial atau administrasi.',
                'persyaratan' => [
                    'Fotokopi KTP yang masih berlaku',
                    'Fotokopi Kartu Keluarga (KK)',
                    'Surat Pengantar dari RT/RW',
                    'Surat Keterangan Penghasilan (jika ada)',
                    'Pas foto 3x4 (2 lembar)'
                ],
                'waktu_proses' => '3-5 hari kerja',
                'biaya' => 'Gratis'
            ],
            'surat_pengantar_nikah' => [
                'nama' => 'Surat Pengantar Nikah',
                'deskripsi' => 'Surat pengantar untuk keperluan pernikahan sesuai ketentuan administrasi.',
                'persyaratan' => [
                    'Fotokopi KTP calon pengantin',
                    'Fotokopi Kartu Keluarga (KK)',
                    'Akta Kelahiran',
                    'Surat Pengantar dari RT/RW',
                    'Surat rekomendasi dari KUA (jika diperlukan)'
                ],
                'waktu_proses' => '3-5 hari kerja',
                'biaya' => 'Gratis'
            ],
            'surat_keterangan_kelahiran' => [
                'nama' => 'Surat Keterangan Kelahiran',
                'deskripsi' => 'Surat keterangan untuk keperluan pembuatan akta kelahiran.',
                'persyaratan' => [
                    'Fotokopi KTP orang tua',
                    'Fotokopi Kartu Keluarga (KK)',
                    'Surat Keterangan Lahir dari Bidan/Dokter',
                    'Pas foto 3x4 (2 lembar)'
                ],
                'waktu_proses' => '3-5 hari kerja',
                'biaya' => 'Gratis'
            ],
            'surat_keterangan_kematian' => [
                'nama' => 'Surat Keterangan Kematian',
                'deskripsi' => 'Surat keterangan untuk keperluan administrasi terkait kematian.',
                'persyaratan' => [
                    'Fotokopi KTP pelapor',
                    'Fotokopi Kartu Keluarga (KK)',
                    'Surat Keterangan Kematian dari Dokter/RS',
                    'Pas foto almarhum/almarhumah (jika diminta)'
                ],
                'waktu_proses' => '3-5 hari kerja',
                'biaya' => 'Gratis'
            ],
        ];

        $info = $layananInfo[$jenis] ?? null;

        if (!$info) {
            abort(404, 'Layanan tidak ditemukan');
        }

        return view('frontend.layanan.info', compact('info', 'jenis'));
    }
}