<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use App\Models\Magang;
use Illuminate\Database\Eloquent\Factories\Factory;

class PendaftaranMagangFactory extends Factory
{
    public function definition(): array
    {
        // Ambil mahasiswa dan magang secara acak yang sudah ada di database
        $mahasiswa = Mahasiswa::inRandomOrder()->first();
        $magang = Magang::inRandomOrder()->first();

        // Jika tidak ada mahasiswa atau magang, buat baru
        if (!$mahasiswa) {
            $mahasiswa = Mahasiswa::factory()->create();
        }
        if (!$magang) {
            $magang = Magang::factory()->create();
        }

        return [
            'mahasiswa_id' => $mahasiswa->id,
            'magang_id' => $magang->id,
            'cv' => 'path/to/dummy-cv.pdf', // Path contoh
            'surat_pengantar' => 'path/to/dummy-surat.pdf', // Path contoh
            'status' => $this->faker->randomElement(['menunggu', 'diterima', 'ditolak']),
            'catatan' => $this->faker->optional()->sentence(),
        ];
    }
}
