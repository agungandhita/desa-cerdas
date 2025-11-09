<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forum;
use App\Models\User;

class ForumSeeder extends Seeder
{
    public function run(): void
    {
        $warga = User::where('email', 'warga@desacerdas.com')->first() ?? User::first();
        $operator = User::where('email', 'operator@desacerdas.com')->first() ?? User::first();

        $items = [
            [
                'user_id' => $warga?->id,
                'judul' => 'Usulan Perbaikan Jalan Dusun A',
                'isi' => 'Mohon dipertimbangkan perbaikan jalan yang rusak parah.',
                'kategori' => 'infrastruktur',
                'status' => 'active',
                'views' => 23,
                'is_pinned' => false,
            ],
            [
                'user_id' => $operator?->id,
                'judul' => 'Sosialisasi Program Vaksinasi',
                'isi' => 'Jadwal vaksinasi di balai desa pada hari Jumat.',
                'kategori' => 'kesehatan',
                'status' => 'active',
                'views' => 64,
                'is_pinned' => true,
            ],
            [
                'user_id' => $warga?->id,
                'judul' => 'Ide Festival Desa Akhir Tahun',
                'isi' => 'Mari kumpulkan ide dan relawan untuk festival desa.',
                'kategori' => 'umum',
                'status' => 'closed',
                'views' => 120,
                'is_pinned' => false,
            ],
        ];

        foreach ($items as $item) {
            Forum::create($item);
        }
    }
}