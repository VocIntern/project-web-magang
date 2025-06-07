<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileUpdateRequest extends Model
{
    use HasFactory;

    // Pilih salah satu: 'mahasiswa' (singular) atau 'mahasiswas' (plural)
    // Saya sarankan gunakan plural sesuai konvensi Laravel
    protected $table = 'mahasiswas'; // atau tetap 'mahasiswa' jika tabel DB sudah ada

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
        // 'email', // HAPUS - email sudah ada di tabel users
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
            'semester' => 'integer', // Tambahkan cast untuk semester
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

    /**
     * Get email from related user (since email is in users table)
     */
    public function getEmailAttribute()
    {
        return $this->user ? $this->user->email : null;
    }

    /**
     * Scope untuk pencarian berdasarkan nama atau NIM
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('nim', 'like', "%{$search}%");
    }

    /**
     * Scope untuk filter berdasarkan jurusan
     */
    public function scopeByJurusan($query, $jurusan)
    {
        return $query->where('jurusan', $jurusan);
    }
}