<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Seeders\MagangSeeder;
use Database\Seeders\MahasiswaSeeder;
use Database\Seeders\PerusahaanSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create();
        $this->call([
            MagangSeeder::class,
            PerusahaanSeeder::class,
            MahasiswaSeeder::class,
            // seeder lain jika ada...
        ]);


        // Buat 5 admin
        for ($i = 1; $i <= 5; $i++) {
            User::factory()->create([
                'email' => 'admin' . $i . '@admin.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]);
        }

        // Buat 5 mahasiswa
        for ($i = 1; $i <= 5; $i++) {
            User::factory()->create([
                'email' => 'mahasiswa' . $i . '@mahasiswa.com',
                'password' => Hash::make('mahasiswa123'),
                'role' => 'mahasiswa',
            ]);
        }

        // Buat 5 perusahaan
        for ($i = 1; $i <= 5; $i++) {
            User::factory()->create([
                'email' => 'perusahaan' . $i . '@perusahaan.com',
                'password' => Hash::make('perusahaan123'),
                'role' => 'perusahaan',
            ]);
        }
    }
}
