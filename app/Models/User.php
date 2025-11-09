<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nik',
        'alamat',
        'no_hp',
        'tanggal_lahir',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi dengan permohonan surat
     */
    public function permohonanSurat()
    {
        return $this->hasMany(PermohonanSurat::class);
    }

    /**
     * Relasi dengan berita sebagai author
     */
    public function berita()
    {
        return $this->hasMany(Berita::class, 'author_id');
    }

    /**
     * Relasi dengan produk UMKM
     */
    public function produkUmkm()
    {
        return $this->hasMany(ProdukUmkm::class);
    }

    /**
     * Relasi dengan forum
     */
    public function forum()
    {
        return $this->hasMany(Forum::class);
    }

    /**
     * Alias: relasi dengan forum (dipakai oleh view sebagai 'forums')
     */
    public function forums()
    {
        return $this->hasMany(Forum::class);
    }

    /**
     * Relasi dengan komentar forum
     */
    public function komentarForum()
    {
        return $this->hasMany(KomentarForum::class);
    }
}
