<?php

namespace Database\Factories;

use App\Models\Magang;
use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

class MagangFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Magang>
     */
    protected $model = Magang::class;  // Pastikan menunjuk ke model Magang

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate tanggal mulai antara sekarang dan 1 bulan ke depan
        $mulai = $this->faker->dateTimeBetween('now', '+1 month');             
        // Generate tanggal selesai antara tanggal mulai dan +3 bulan
        $selesai = $this->faker->dateTimeBetween($mulai, (clone $mulai)->modify('+3 months')); 

        return [
            'perusahaan_id'   => Perusahaan::factory(),                          // relasi ke Perusahaan :contentReference[oaicite:3]{index=3}
            'judul'           => $this->faker->sentence(),                       // kalimat acak
            'deskripsi'       => $this->faker->paragraph(),                      // paragraf acak
            'lokasi'          => $this->faker->city(),                           // kota acak
            'bidang'          => $this->faker->word(),                           // kata acak
            'tanggal_mulai'   => $mulai->format('Y-m-d'),                        // format Y-m-d :contentReference[oaicite:4]{index=4}
            'tanggal_selesai' => $selesai->format('Y-m-d'),                      // format Y-m-d :contentReference[oaicite:5]{index=5}
            'kuota'           => $this->faker->numberBetween(1, 20),             // integer antara 1–20
            'status_aktif'    => $this->faker->randomElement([0, 1]),             // boolean 0 atau 1 :contentReference[oaicite:6]{index=6}
        ];
    }
}
