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
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->string('name'); // Nama room chat (misal: "Pembangunan Jalan Desa")
            $table->text('description')->nullable(); // Deskripsi room
            $table->string('topic')->nullable(); // Topik diskusi
            $table->enum('status', ['active', 'closed', 'archived'])->default('active');
            $table->boolean('is_private')->default(false); // Room private atau public
            $table->integer('max_participants')->nullable(); // Batas maksimal peserta
            $table->json('allowed_users')->nullable(); // User yang diizinkan join (untuk private room)
            $table->timestamp('last_activity')->nullable(); // Waktu aktivitas terakhir
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index('last_activity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_rooms');
    }
};
