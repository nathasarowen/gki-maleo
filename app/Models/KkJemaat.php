<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KkJemaat extends Model
{
    use HasFactory;

    protected $table = 'kk_jemaat'; // Nama tabel di database
    protected $primaryKey = 'id_kk_jemaat'; // Primary Key

    public $timestamps = true; // Aktifkan timestamps jika ada created_at dan updated_at

    protected $fillable = [
        'id_group_wilayah',
        'id_jemaat', // Kepala keluarga adalah bagian dari jemaat
        'nama_kepala_keluarga',
        'alamat',
    ];

    // Relasi ke Jemaat (1 kepala keluarga memiliki 1 jemaat sebagai dirinya sendiri)
    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat', 'id_jemaat');
    }

    // Relasi ke Hubungan Keluarga untuk mendapatkan semua anggota keluarga dalam KK ini
    public function anggotaKeluarga()
    {
        return $this->hasMany(HubunganKeluarga::class, 'id_kk_jemaat', 'id_kk_jemaat');
    }

    // Relasi ke Group Wilayah
    public function groupWilayah()
    {
        return $this->belongsTo(GroupWilayah::class, 'id_group_wilayah', 'id_group_wilayah');
    }

    // Relasi untuk mengecek apakah ada anggota keluarga dalam KK ini
    public function hasAnggota()
    {
        return $this->anggotaKeluarga()->exists();
    }

    // Relasi untuk mendapatkan anggota keluarga sebagai array
    public function getAnggota()
    {
        return $this->anggotaKeluarga()->get();
    }
}
