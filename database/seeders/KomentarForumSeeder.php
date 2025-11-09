<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forum;
use App\Models\KomentarForum;
use App\Models\User;

class KomentarForumSeeder extends Seeder
{
    public function run(): void
    {
        $warga = User::where('email', 'warga@desacerdas.com')->first() ?? User::first();
        $operator = User::where('email', 'operator@desacerdas.com')->first() ?? User::first();

        $forums = Forum::take(3)->get();
        foreach ($forums as $forum) {
            $komentar1 = KomentarForum::create([
                'forum_id' => $forum->id,
                'user_id' => $warga?->id,
                'isi' => 'Saya setuju dengan topik ini. Terima kasih.',
                'status' => 'active',
            ]);

            KomentarForum::create([
                'forum_id' => $forum->id,
                'user_id' => $operator?->id,
                'isi' => 'Terima kasih atas masukannya, akan kami tindak lanjuti.',
                'parent_id' => $komentar1->id,
                'status' => 'active',
            ]);
        }
    }
}