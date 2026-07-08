<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalNilaiNilai extends Model
{
    use HasFactory;

    protected $table = 'portal_nilai_nilai';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'mapel_id',
        'siswa_id',
        'tugas_1',
        'tugas_2',
        'asts',
        'tugas_4',
        'tugas_5',
        'mode_asas',
        'pg_asas',
        'essai_asas',
        'murni_asas',
        'perbaikan',
        'ketuntasan',
        'nilai_akhir',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
