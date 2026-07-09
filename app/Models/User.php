<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'password', 'password_plain', 'role', 'instansi_id', 'id_pembimbing', 'duk'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function instansi(){
        return $this->belongsTo(Instansi::class);
    }

    public function kelas(){
        return $this->hasOne(Kelas::class, 'user_id');
    }

    public function classes(){
        return $this->hasMany(Kelas::class, 'user_id');
    }

    public function siswa(){
        return $this->hasOne(Siswa::class, 'user_id');
    }

    public function mitras()
    {
        return $this->belongsToMany(MitraDudi::class, 'pembimbing_mitra_dudi', 'pembimbing_id', 'mitra_dudi_id');
    }

    public function guru_kelas()
    {
        return $this->belongsToMany(Kelas::class, 'guru_kelas', 'user_id', 'kelas_id');
    }

    public function guru_mapel()
    {
        return $this->belongsToMany(Mapel::class, 'guru_mapel', 'user_id', 'mapel_id');
    }
}
