<?php

namespace Database\Seeders;

use App\Models\Magang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MagangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Magang::factory()
            ->count(50)   // membuat 50 record dummy
            ->create();
    }
}
