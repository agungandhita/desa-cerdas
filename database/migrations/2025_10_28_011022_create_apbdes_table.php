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
        Schema::create('apbdes', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('bidang');
            $table->decimal('jumlah_anggaran', 15, 2);
            $table->decimal('realisasi', 15, 2)->default(0);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['draft', 'approved', 'executed'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apbdes');
    }
};
