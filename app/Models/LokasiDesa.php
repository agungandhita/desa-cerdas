<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiDesa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'kategori',
        'alamat',
        'latitude',
        'longitude',
        'deskripsi',
        'foto',
        'kontak',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'foto' => 'array',
    ];

    /**
     * Scope untuk lokasi aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk pencarian berdasarkan nama atau alamat
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('alamat', 'like', "%{$search}%")
              ->orWhere('deskripsi', 'like', "%{$search}%");
        });
    }

    /**
     * Scope untuk lokasi yang memiliki koordinat
     */
    public function scopeHasCoordinates($query)
    {
        return $query->whereNotNull('latitude')->whereNotNull('longitude');
    }

    /**
     * Check apakah lokasi memiliki koordinat
     */
    public function hasCoordinates()
    {
        return !is_null($this->latitude) && !is_null($this->longitude);
    }

    /**
     * Accessor untuk foto utama
     */
    public function getFotoUtamaAttribute()
    {
        if (is_array($this->foto) && count($this->foto) > 0) {
            return $this->foto[0];
        }
        return null;
    }

    /**
     * Accessor untuk koordinat dalam format array
     */
    public function getKoordinatAttribute()
    {
        if ($this->hasCoordinates()) {
            return [
                'lat' => (float) $this->latitude,
                'lng' => (float) $this->longitude,
            ];
        }
        return null;
    }

    /**
     * Method untuk menghitung jarak ke koordinat lain (dalam km)
     * Menggunakan formula Haversine
     */
    public function distanceTo($latitude, $longitude)
    {
        if (!$this->hasCoordinates()) {
            return null;
        }

        $earthRadius = 6371; // Radius bumi dalam km

        $latFrom = deg2rad($this->latitude);
        $lonFrom = deg2rad($this->longitude);
        $latTo = deg2rad($latitude);
        $lonTo = deg2rad($longitude);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
