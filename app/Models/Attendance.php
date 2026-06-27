<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';
    protected $guarded = ['id'];

    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
