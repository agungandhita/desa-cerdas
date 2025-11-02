<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Forum extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'judul',
        'isi',
        'kategori',
        'status',
        'views',
        'is_pinned',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'views' => 'integer',
        'is_pinned' => 'boolean',
    ];

    /**
     * Relasi dengan User (pembuat forum)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan KomentarForum
     */
    public function komentarForum()
    {
        return $this->hasMany(KomentarForum::class);
    }

    /**
     * Relasi dengan komentar aktif saja
     */
    public function komentarAktif()
    {
        return $this->hasMany(KomentarForum::class)->where('status', 'active');
    }

    /**
     * Scope untuk forum aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk forum yang di-pin
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope untuk filter berdasarkan kategori
     */
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope untuk forum terpopuler (berdasarkan views)
     */
    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

    /**
     * Scope untuk forum terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Method untuk increment views
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Accessor untuk jumlah komentar
     */
    public function getJumlahKomentarAttribute()
    {
        return $this->komentarAktif()->count();
    }

    /**
     * Accessor untuk excerpt isi forum
     */
    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->isi), 150);
    }
}
