<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'mitra_dudi_id',
        'nisn',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mitra()
    {
        return $this->belongsTo(MitraDudi::class, 'mitra_dudi_id');
    }

    public function attendances()
    {
        return $this->hasMany(PklAttendance::class, 'siswa_id');
    }
}
