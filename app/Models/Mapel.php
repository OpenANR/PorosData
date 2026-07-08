<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $table = 'mapel';

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'kategori_mapel_id',
        'instansi_id',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriMapel::class, 'kategori_mapel_id');
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
