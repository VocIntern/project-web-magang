<?php

namespace Database\Factories;

use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerusahaanFactory extends Factory
{
    /**  
     * Model yang diasosiasikan  
     *  
     * @var class-string<\Illuminate\Database\Eloquent\Model>  
     */
    protected $model = Perusahaan::class;

    /**  
     * Definisi atribut default  
     */
    public function definition(): array
    {
        return [
            'user_id'           => \App\Models\User::factory(),
            'nama_perusahaan'   => $this->faker->company(),
            'alamat'            => $this->faker->address(),
            'bidang'            => $this->faker->word(),
            'nama_pendaftar'    => $this->faker->name(),
            'website'           => $this->faker->url(),
            'logo'              => null,
            'deskripsi'         => $this->faker->paragraph(),
        ];
    }
}
