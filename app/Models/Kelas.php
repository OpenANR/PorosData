<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $guarded = ['id'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    // Kelas ini diampu oleh siapa? (Wali Kelas)
    public function wali_kelas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gurus()
    {
        return $this->belongsToMany(User::class, 'guru_kelas', 'kelas_id', 'user_id');
    }
}
