<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Apbdes;

class ApbdesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'tahun' => (int) date('Y'),
                'bidang' => 'Pembangunan Infrastruktur',
                'jumlah_anggaran' => 150_000_000,
                'realisasi' => 75_000_000,
                'deskripsi' => 'Pembangunan jalan desa dan drainase.',
                'status' => 'approved',
            ],
            [
                'tahun' => (int) date('Y'),
                'bidang' => 'Kesehatan',
                'jumlah_anggaran' => 80_000_000,
                'realisasi' => 65_000_000,
                'deskripsi' => 'Program posyandu dan pengadaan alat kesehatan.',
                'status' => 'executed',
            ],
            [
                'tahun' => (int) date('Y') - 1,
                'bidang' => 'Pendidikan',
                'jumlah_anggaran' => 100_000_000,
                'realisasi' => 20_000_000,
                'deskripsi' => 'Bantuan operasional sekolah dan pelatihan guru.',
                'status' => 'draft',
            ],
        ];

        foreach ($data as $item) {
            Apbdes::create($item);
        }
    }
}