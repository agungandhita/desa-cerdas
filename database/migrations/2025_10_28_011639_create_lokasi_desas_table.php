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
        Schema::create('lokasi_desas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori'); // fasilitas_umum, wisata, pemerintahan, kesehatan, pendidikan, dll
            $table->text('alamat');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('deskripsi')->nullable();
            $table->json('foto')->nullable(); // array foto paths
            $table->string('kontak')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_desas');
    }
};
