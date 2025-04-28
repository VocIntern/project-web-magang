<?php
// app/Models/Magang.php

namespace App\Models;

use App\Models\Perusahaan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magang extends Model
{
    use HasFactory;
    protected $table = 'magang';

    protected $fillable = [
        'perusahaan_id',
        'judul',
        'deskripsi',
        'lokasi',
        'bidang',
        'tanggal_mulai',
        'tanggal_selesai',
        'kuota',
        'status_aktif'
    ];

    // Tambahkan casting untuk otomatis jadi Carbon instance
    protected $casts = [
        'tanggal_mulai'   => 'date',     // cast menjadi Carbon
        'tanggal_selesai' => 'date',     // cast menjadi Carbon
    ];

    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
}
