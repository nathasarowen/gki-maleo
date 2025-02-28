<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupWilayah extends Model
{
    use HasFactory;

    protected $table = 'group_wilayah';
    protected $primaryKey = 'id_group_wilayah';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_group_wilayah',
        'nama_group_wilayah',
        'kelurahan',
        'kecamatan',
        'koor_group_wilayah'
    ];
}
