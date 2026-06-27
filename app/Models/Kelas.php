<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $guarded = ['id'];

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    // Kelas ini diampu oleh siapa? (Wali Kelas)
    public function wali_kelas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
