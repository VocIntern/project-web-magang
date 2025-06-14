<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all pendaftaran magang for this mahasiswa.
     */
    public function pendaftaranMagang(): HasMany
    {
        return $this->hasMany(PendaftaranMagang::class);
    }

    /**
     * Get profile completion percentage
     */
    public function getProfileCompletionAttribute(): int
    {
        $fields = ['nama', 'nim', 'jurusan', 'semester', 'bio', 'foto'];
        $filledFields = 0;

        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filledFields++;
            }
        }

        return round(($filledFields / count($fields)) * 100);
    }

    // /**
    //  * Get the mahasiswa's full name with NIM
    //  */
    // public function getFullIdentityAttribute()
    // {
    //     return $this->nama . ' (' . $this->nim . ')';
    // }

    // public function getRouteKeyName(): string
    // {
    //     return 'nim'; // <-- Anda mungkin telah menambahkan ini
    // }
}
