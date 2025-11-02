<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message'); // Isi pesan chat
            $table->enum('message_type', ['text', 'image', 'file', 'system'])->default('text');
            $table->string('file_path')->nullable(); // Path file jika ada attachment
            $table->string('file_name')->nullable(); // Nama file original
            $table->bigInteger('file_size')->nullable(); // Ukuran file dalam byte
            $table->boolean('is_edited')->default(false); // Apakah pesan sudah diedit
            $table->timestamp('edited_at')->nullable(); // Waktu edit terakhir
            $table->json('read_by')->nullable(); // User yang sudah baca pesan (untuk read receipt)
            $table->foreignId('reply_to')->nullable()->constrained('chat_messages')->onDelete('set null'); // Reply ke pesan lain
            $table->timestamps();

            $table->index(['chat_room_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('message_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
