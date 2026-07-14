<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersetujuanPerubahan extends Model
{
    protected $table = 'persetujuan_perubahans';

    protected $fillable = [
        'siswa_id',
        'user_id',
        'alasan',
        'data_lama',
        'data_baru',
        'status',
    ];

    protected $casts = [
        'data_lama' => 'array',
        'data_baru' => 'array',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
