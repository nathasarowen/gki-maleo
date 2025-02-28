<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HubunganKeluarga extends Model
{
    use HasFactory;

    protected $table = 'hubungan_keluarga'; // Nama tabel

    protected $primaryKey = 'id_hub_kel'; // Primary key

    public $timestamps = false; // Tidak menggunakan created_at dan updated_at

    protected $fillable = [
        'id_kk_jemaat',
        'id_jemaat',
        'hubungan_keluarga',
    ];

    // Relasi ke Kepala Keluarga
    public function kkJemaat()
    {
        return $this->belongsTo(KkJemaat::class, 'id_kk_jemaat', 'id_kk_jemaat');
    }

    // Relasi ke Jemaat sebagai anggota keluarga
    public function jemaat()
    {
        return $this->belongsTo(Jemaat::class, 'id_jemaat', 'id_jemaat');
    }
}
