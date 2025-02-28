<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jemaat extends Model
{
    use HasFactory;

    protected $table = 'jemaat'; // Nama tabel di database
    protected $primaryKey = 'id_jemaat'; // Primary Key

    public $timestamps = true; // Aktifkan timestamps jika ada created_at dan updated_at

    protected $fillable = [
        'no_anggota', 
        'nama_jemaat', 
        'gender', 
        'nomor_hp', 
        'asal_gereja',
        'tanggal_terdaftar', 
        'tempat_lahir', 
        'tanggal_lahir', 
        'tanggal_baptis',
        'tanggal_sidi', 
        'tanggal_nikah', 
        'status_aktif', 
        'status_menikah'
    ];

    /**
     * Relasi ke tabel Hubungan Keluarga
     * Menggunakan hasOne karena satu jemaat hanya bisa memiliki satu hubungan keluarga
     */
    public function hubunganKeluarga()
    {
        return $this->hasOne(HubunganKeluarga::class, 'id_jemaat', 'id_jemaat');
    }

    /**
     * Relasi ke tabel Kepala Keluarga (KK_Jemaat)
     * Untuk mengecek apakah jemaat ini adalah kepala keluarga dalam tabel KK_Jemaat
     */
    public function kepalaKeluarga()
    {
        return $this->hasOne(KkJemaat::class, 'id_jemaat', 'id_jemaat');
    }

    /**
     * Mendapatkan kepala keluarga dari anggota keluarga ini jika dia adalah anggota
     * Melalui hubungan_keluarga, kita bisa mendapatkan siapa kepala keluarganya
     */
    public function kepalaKeluargaDariHubungan()
    {
        return $this->belongsTo(KkJemaat::class, 'id_kk_jemaat', 'id_kk_jemaat')
            ->via(HubunganKeluarga::class);
    }
}
