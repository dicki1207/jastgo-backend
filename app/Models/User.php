<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'nama_lengkap',
        'jenis_kelamin',
        'username',
        'email',
        'password',
        'no_hp',
        'alamat',
        'role',
        'tanggal_daftar',
        'is_banned',
        'avatar',
        'google_id',
        'otp_code',
        'otp_expires_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'tanggal_daftar'    => 'datetime',
        'otp_expires_at'    => 'datetime',
        'password'          => 'hashed',
    ];

    public function getAvatarAttribute($value)
    {
        if (!$value) {
            return null;
        }
        
        // Jika value sudah berupa URL penuh (misalnya dari Google Login)
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }

        // Jika value berupa nama file lokal (hilangkan prefiks avatars/ jika tersimpan dobel)
        $value = str_replace('avatars/', '', $value);
        return asset('storage/avatars/' . $value);
    }

    // contoh relasi umum
    public function jastiper()
    {
        return $this->hasOne(Jastiper::class);
    }

    public function pesanans()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function rekenings()
    {
        return $this->hasMany(Rekening::class);
    }

    public function followedJastipers()
    {
        return $this->hasMany(JastiperFollower::class);
    }

    public function laporans()
    {
        return $this->hasMany(Laporan::class, 'pelapor_id');
    }
    
}
