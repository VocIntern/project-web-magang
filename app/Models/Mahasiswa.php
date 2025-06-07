<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

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
        'no_telepon',
        'alamat',
        'email',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nim' => 'integer',
        ];
    }

    /**
     * Get the user that owns the mahasiswa profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all pendaftaran magang for this mahasiswa.
     */
    public function pendaftaranMagang()
    {
        return $this->hasMany(PendaftaranMagang::class);
    }

    /**
     * Get profile completion percentage
     */
    public function getProfileCompletionAttribute()
    {
        $fields = ['nama', 'nim', 'jurusan', 'semester', 'no_telepon', 'alamat', 'bio', 'foto'];
        $filledFields = 0;

        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filledFields++;
            }
        }

        return round(($filledFields / count($fields)) * 100);
    }

    /**
     * Get the mahasiswa's full name with NIM
     */
    public function getFullIdentityAttribute()
    {
        return $this->nama . ' (' . $this->nim . ')';
    }
}