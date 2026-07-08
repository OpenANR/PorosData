<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalNilaiSetting extends Model
{
    use HasFactory;

    protected $table = 'portal_nilai_settings';

    protected $fillable = [
        'instansi_id',
        'tugas_buka',
        'tugas_tutup',
        'asas_buka',
        'asas_tutup',
    ];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }
}
