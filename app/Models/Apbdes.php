<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apbdes extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tahun',
        'bidang',
        'jumlah_anggaran',
        'realisasi',
        'deskripsi',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jumlah_anggaran' => 'decimal:2',
        'realisasi' => 'decimal:2',
        'tahun' => 'integer',
    ];

    /**
     * Scope untuk filter berdasarkan tahun
     */
    public function scopeByYear($query, $year)
    {
        return $query->where('tahun', $year);
    }

    /**
     * Scope untuk filter berdasarkan bidang
     */
    public function scopeByBidang($query, $bidang)
    {
        return $query->where('bidang', $bidang);
    }

    /**
     * Accessor untuk persentase realisasi
     */
    public function getPersentaseRealisasiAttribute()
    {
        if ($this->jumlah_anggaran > 0) {
            return round(($this->realisasi / $this->jumlah_anggaran) * 100, 2);
        }
        return 0;
    }
}
