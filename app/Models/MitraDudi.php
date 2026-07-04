<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['nama_perusahaan', 'alamat', 'koordinat'])]
class MitraDudi extends Model
{
    use HasFactory;

    protected $table = 'mitra_dudi';

    public function pembimbings()
    {
        return $this->belongsToMany(User::class, 'pembimbing_mitra_dudi', 'mitra_dudi_id', 'pembimbing_id');
    }
}
