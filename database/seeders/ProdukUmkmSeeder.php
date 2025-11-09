<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProdukUmkm;
use App\Models\User;

class ProdukUmkmSeeder extends Seeder
{
    public function run(): void
    {
        $pemilik = User::where('email', 'warga@desacerdas.com')->first() ?? User::first();

        $items = [
            [
                'nama' => 'Kopi Robusta Desa',
                'deskripsi' => 'Kopi robusta hasil kebun warga dengan cita rasa khas.',
                'harga' => 45000,
                'foto' => ['images/umkm/kopi-1.jpg', 'images/umkm/kopi-2.jpg'],
                'kontak' => '081234567892',
                'status' => 'active',
                'kategori' => 'makanan-minuman',
                'stok' => 120,
                'is_featured' => true,
            ],
            [
                'nama' => 'Kerajinan Bambu',
                'deskripsi' => 'Produk kerajinan tangan dari bambu lokal.',
                'harga' => 125000,
                'foto' => ['images/umkm/bambu-1.jpg'],
                'kontak' => '081234567892',
                'status' => 'active',
                'kategori' => 'kerajinan',
                'stok' => 35,
                'is_featured' => false,
            ],
            [
                'nama' => 'Pupuk Organik Desa',
                'deskripsi' => 'Pupuk organik ramah lingkungan untuk pertanian.',
                'harga' => 80000,
                'foto' => null,
                'kontak' => '081234567892',
                'status' => 'pending',
                'kategori' => 'pertanian',
                'stok' => 50,
                'is_featured' => false,
            ],
        ];

        foreach ($items as $item) {
            ProdukUmkm::create(array_merge($item, [
                'user_id' => $pemilik?->id,
            ]));
        }
    }
}