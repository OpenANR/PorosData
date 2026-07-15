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
        'angkatan',
        'jurusan',
        'nama_panggilan',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'agama',
        'kewarganegaraan',
        'alamat_lengkap',
        'nomor_telepon',
        'tinggi_badan',
        'berat_badan',
        'anak_ke',
        'jumlah_saudara_kandung',
        'status_yatim_piatu',
        'tinggal_dengan',
        'nama_ayah',
        'pekerjaan_ayah',
        'nomor_hp_ayah',
        'nama_ibu',
        'pekerjaan_ibu',
        'nomor_hp_ibu',
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
