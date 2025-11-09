<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LokasiDesa;

class LokasiDesaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nama' => 'Balai Desa Cerdas',
                'kategori' => 'pemerintahan',
                'alamat' => 'Jl. Raya Desa Cerdas No. 1',
                'latitude' => -7.000123,
                'longitude' => 110.401234,
                'deskripsi' => 'Pusat administrasi pemerintahan desa.',
                'foto' => ['images/lokasi/balai-1.jpg'],
                'kontak' => '0291-555000',
                'status' => 'active',
            ],
            [
                'nama' => 'Puskesmas Desa',
                'kategori' => 'kesehatan',
                'alamat' => 'Jl. Sehat No. 5',
                'latitude' => -7.010123,
                'longitude' => 110.411234,
                'deskripsi' => 'Layanan kesehatan masyarakat desa.',
                'foto' => ['images/lokasi/puskesmas-1.jpg', 'images/lokasi/puskesmas-2.jpg'],
                'kontak' => '0291-555100',
                'status' => 'active',
            ],
            [
                'nama' => 'Bukit Wisata Harapan',
                'kategori' => 'wisata',
                'alamat' => 'Dusun Harapan',
                'latitude' => -7.020123,
                'longitude' => 110.421234,
                'deskripsi' => 'Tempat wisata alam dengan pemandangan indah.',
                'foto' => null,
                'kontak' => '081234567800',
                'status' => 'active',
            ],
        ];

        foreach ($items as $item) {
            LokasiDesa::create($item);
        }
    }
}