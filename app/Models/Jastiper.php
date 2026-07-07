<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Jastiper extends Model
{
    use SoftDeletes, Notifiable;

    protected $fillable = [
        'user_id',
        'nama_toko',
        'no_hp',
        'kota_toko',
        'alamat_toko',
        'jangkauan',      
        'rating',
        'tanggal_daftar',
        'rekening_id',    
        'profile_toko',
        'deskripsi_toko',
        'foto_cover'
    ];

    protected $withCount = ['followers'];
    protected $appends = ['is_followed'];

    protected $casts = [
        'rating' => 'decimal:1',
        'tanggal_daftar' => 'datetime',
    ];

    public function getProfileTokoAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function getFotoCoverAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function getIsFollowedAttribute()
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->followers()->where('user_id', auth()->id())->exists();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }

    public function rekening()
    {
        return $this->belongsTo(Rekening::class, 'rekening_id');
    }
    
    public function followers()
    {
        return $this->hasMany(JastiperFollower::class);
    }

    public function ulasans()
    {
        return $this->hasMany(Ulasan::class);
    }




}
