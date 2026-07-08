<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriMapel extends Model
{
    use HasFactory;

    protected $table = 'kategori_mapel';

    protected $fillable = [
        'nama_kategori',
        'instansi_id',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function mapels()
    {
        return $this->hasMany(Mapel::class, 'kategori_mapel_id');
    }
}
