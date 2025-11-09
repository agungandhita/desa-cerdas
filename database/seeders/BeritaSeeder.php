<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Berita;
use App\Models\User;

class BeritaSeeder extends Seeder
{
    public function run(): void
    {
        $author = User::where('email', 'operator@desacerdas.com')->first() ?? User::where('email', 'admin@desacerdas.com')->first() ?? User::first();

        $items = [
            [
                'judul' => 'Launching Program Desa Cerdas',
                'isi' => 'Program Desa Cerdas resmi diluncurkan untuk meningkatkan layanan digital desa.',
                'cover' => 'images/berita/cover-launching.jpg',
                'status' => 'published',
                'is_featured' => true,
                'views' => 1250,
                'published_at' => now(),
            ],
            [
                'judul' => 'Pelatihan UMKM Go Digital',
                'isi' => 'Pelatihan bagi pelaku UMKM untuk memanfaatkan platform digital.',
                'cover' => 'images/berita/cover-umkm.jpg',
                'status' => 'published',
                'is_featured' => false,
                'views' => 560,
                'published_at' => now()->subDays(2),
            ],
            [
                'judul' => 'Rencana Pembangunan Jalan Tahun Depan',
                'isi' => 'Rencana pembangunan jalan penghubung dusun A dan B.',
                'cover' => null,
                'status' => 'draft',
                'is_featured' => false,
                'views' => 0,
                'published_at' => null,
            ],
        ];

        foreach ($items as $item) {
            $slugBase = Str::slug($item['judul']);
            $slug = $slugBase;
            $counter = 1;
            while (Berita::where('slug', $slug)->exists()) {
                $slug = $slugBase.'-'.$counter++;
            }

            Berita::create(array_merge($item, [
                'slug' => $slug,
                'author_id' => $author?->id,
            ]));
        }
    }
}