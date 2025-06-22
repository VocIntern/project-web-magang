<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranMagang extends Model
{
    use HasFactory;

    // Explicitly set the table name to match your database
    protected $table = 'pendaftaran_magang';

    protected $fillable = [
        'mahasiswa_id',
        'magang_id',
        'cv',
        'surat_pengantar',
        'status',
        'catatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_magang'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function magang()
    {
        return $this->belongsTo(Magang::class);
    }


}
