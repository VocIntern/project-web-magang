<?php

namespace Database\Seeders;

use App\Models\PendaftaranMagang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendaftaranMagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PendaftaranMagang::factory()->count(20)->create();
    }
}
