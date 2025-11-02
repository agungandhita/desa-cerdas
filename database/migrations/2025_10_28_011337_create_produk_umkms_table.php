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
        Schema::create('produk_umkms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama');
            $table->text('deskripsi');
            $table->decimal('harga', 12, 2);
            $table->json('foto')->nullable(); // Array of photo paths
            $table->string('kontak');
            $table->enum('status', ['active', 'inactive', 'pending'])->default('pending');
            $table->string('kategori')->nullable();
            $table->integer('stok')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_umkms');
    }
};
