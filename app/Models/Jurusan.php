<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $fillable = ['instansi_id', 'nama_jurusan'];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
}
