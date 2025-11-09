<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\User;

class ChatSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@desacerdas.com')->first() ?? User::first();
        $operator = User::where('email', 'operator@desacerdas.com')->first() ?? User::first();
        $warga = User::where('email', 'warga@desacerdas.com')->first() ?? User::first();

        $room = ChatRoom::create([
            'created_by' => $operator?->id,
            'name' => 'Diskusi Pembangunan Jalan Desa',
            'description' => 'Ruang diskusi terkait pembangunan infrastruktur jalan desa.',
            'topic' => 'infrastruktur',
            'status' => 'active',
            'is_private' => false,
            'max_participants' => 50,
            'allowed_users' => null,
            'last_activity' => now(),
        ]);

        $system = ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $admin?->id,
            'message' => 'Selamat datang di ruang diskusi pembangunan jalan desa.',
            'message_type' => 'system',
            'is_edited' => false,
            'read_by' => [$admin?->id, $operator?->id, $warga?->id],
        ]);

        $msg1 = ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $warga?->id,
            'message' => 'Jalan di RT 02 sudah rusak parah, mohon perbaikan.',
            'message_type' => 'text',
            'is_edited' => false,
            'read_by' => [$operator?->id],
        ]);

        ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $operator?->id,
            'message' => 'Terima kasih informasinya, akan kami survei besok.',
            'message_type' => 'text',
            'is_edited' => false,
            'read_by' => [$warga?->id],
            'reply_to' => $msg1->id,
        ]);

        ChatMessage::create([
            'chat_room_id' => $room->id,
            'user_id' => $operator?->id,
            'message' => null,
            'message_type' => 'file',
            'file_path' => 'storage/chat/survei-rencana.pdf',
            'file_name' => 'Survei Rencana Perbaikan.pdf',
            'file_size' => 24576,
            'is_edited' => false,
            'read_by' => [$warga?->id],
        ]);
    }
}