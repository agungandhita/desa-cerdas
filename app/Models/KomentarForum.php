<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomentarForum extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'forum_id',
        'user_id',
        'isi',
        'parent_id',
        'status',
    ];

    /**
     * Relasi dengan Forum
     */
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    /**
     * Relasi dengan User (pembuat komentar)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi dengan parent comment (untuk nested comments)
     */
    public function parent()
    {
        return $this->belongsTo(KomentarForum::class, 'parent_id');
    }

    /**
     * Relasi dengan child comments (balasan)
     */
    public function replies()
    {
        return $this->hasMany(KomentarForum::class, 'parent_id');
    }

    /**
     * Relasi dengan balasan aktif saja
     */
    public function repliesAktif()
    {
        return $this->hasMany(KomentarForum::class, 'parent_id')->where('status', 'active');
    }

    /**
     * Scope untuk komentar aktif
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope untuk komentar utama (bukan balasan)
     */
    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope untuk balasan (child comments)
     */
    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * Scope untuk komentar terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope untuk komentar terlama
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    /**
     * Check apakah komentar ini adalah balasan
     */
    public function isReply()
    {
        return !is_null($this->parent_id);
    }

    /**
     * Accessor untuk jumlah balasan
     */
    public function getJumlahRepliesAttribute()
    {
        return $this->repliesAktif()->count();
    }
}
