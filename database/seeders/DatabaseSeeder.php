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
            UserSeeder::class,
            // seeder lain jika ada...
        ]);

    }
}
