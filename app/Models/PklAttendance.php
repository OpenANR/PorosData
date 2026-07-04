<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PklAttendance extends Model
{
    use HasFactory;

    protected $table = 'pkl_attendances';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'status',
        'foto',
        'koordinat',
        'journal_kegiatan',
        'keterangan',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
