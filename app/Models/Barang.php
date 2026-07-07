<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Barang extends Model {
    use SoftDeletes;
    protected $fillable = ['jastiper_id','kategori_id','admin_id','nama_barang','deskripsi','harga','stok','is_available','foto_barang','foto_barang_2','foto_barang_3','tanggal_input'];
    protected $casts = ['harga'=>'decimal:2','stok'=>'integer','tanggal_input'=>'datetime'];
    protected $appends = ['gambar', 'foto_url'];

    public function getGambarAttribute()
    {
        return $this->foto_barang ? asset('storage/' . $this->foto_barang) : null;
    }

    public function getFotoUrlAttribute()
    {
        return $this->getGambarAttribute();
    }
    public function jastiper(){ return $this->belongsTo(Jastiper::class); }
    public function kategori(){ return $this->belongsTo(Kategori::class); }
    public function admin(){ return $this->belongsTo(User::class,'admin_id'); }
    public function detailPesanans(){ return $this->hasMany(DetailPesanan::class); }
    // public function laporanPenjualans(){ return $this->hasMany(LaporanPenjualan::class); }
}
