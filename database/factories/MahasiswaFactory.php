<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->mahasiswa(), // Auto-create User
            'nama' => $this->faker->name(),
            'nim' => $this->faker->unique()->numerify('#########'), // NIM 9 digit unik
            'jurusan' => $this->faker->randomElement([
                'Teknik Informatika',
                'Sistem Informasi',
                'Teknik Elektro',
                'Manajemen',
                'Mesin'
            ]),
            'semester' => $this->faker->numberBetween(1, 8),
            'bio' => $this->faker->sentence(),
            'foto' => $this->faker->optional()->imageUrl(200, 200, 'people'), // Foto opsional
        ];
    }
}
