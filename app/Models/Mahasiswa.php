<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mahasiswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama',
        'nim',
        'jurusan',
        'semester',
        'bio',
        'foto',
    ];

    /**
     * Get the user that owns the mahasiswa.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pendaftaran magang for the mahasiswa.
     */
    public function pendaftaranMagang()
    {
        return $this->hasMany(PendaftaranMagang::class);
    }

    /**
     * Get foto URL attribute
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }

        return asset('images/default-profile.png');
    }
}
