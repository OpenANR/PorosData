<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    protected $table = 'instansi';
    protected $guarded = ['id'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function kelas() {
        return $this->hasMany(Kelas::class);
    }

    public function jurusans() {
        return $this->hasMany(Jurusan::class);
    }
}
