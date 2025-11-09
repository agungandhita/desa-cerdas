<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PermohonanSurat;
use App\Models\User;

class PermohonanSuratSeeder extends Seeder
{
    public function run(): void
    {
        $pemohon = User::where('email', 'warga@desacerdas.com')->first() ?? User::first();

        $items = [
            [
                'user_id' => $pemohon?->id,
                'jenis_surat' => 'Surat Keterangan Domisili',
                'keperluan' => 'Keperluan administrasi bank',
                'status' => 'pending',
                'file_pdf' => null,
                'catatan' => null,
                'tanggal_pengajuan' => now()->subDays(1),
                'tanggal_selesai' => null,
            ],
            [
                'user_id' => $pemohon?->id,
                'jenis_surat' => 'Surat Keterangan Usaha',
                'keperluan' => 'Keperluan pendaftaran izin usaha',
                'status' => 'diproses',
                'file_pdf' => null,
                'catatan' => 'Sedang dalam verifikasi',
                'tanggal_pengajuan' => now()->subDays(3),
                'tanggal_selesai' => null,
            ],
            [
                'user_id' => $pemohon?->id,
                'jenis_surat' => 'Surat Keterangan Tidak Mampu',
                'keperluan' => 'Keperluan bantuan pendidikan',
                'status' => 'selesai',
                'file_pdf' => 'storage/surat/sktm-001.pdf',
                'catatan' => 'Disetujui oleh operator',
                'tanggal_pengajuan' => now()->subDays(7),
                'tanggal_selesai' => now()->subDays(2),
            ],
        ];

        foreach ($items as $item) {
            PermohonanSurat::create($item);
        }
    }
}