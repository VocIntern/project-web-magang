<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'perusahaan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'alamat',
        'nama_pendaftar',
        'bidang',
        'website',
        'logo',
        'deskripsi',
    ];

    /**
     * Get the user that owns the perusahaan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the magang offerings for the perusahaan.
     */
    public function magang()
    {
        return $this->hasMany(Magang::class);
    }

    /**
     * Get logo URL attribute
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }

        // return asset('images/default-company.png');
    }
}
