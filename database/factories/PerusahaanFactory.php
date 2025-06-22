<?php

namespace Database\Factories;

use App\Models\Perusahaan;
use App\Models\User;
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
            'user_id'           => User::factory()->perusahaan(),
            'nama_perusahaan'   => $this->faker->company() . ' ' . $this->faker->randomElement(['PT', 'CV', 'Tbk.']),
            'alamat'            => $this->faker->address(),
            'bidang'            => $this->faker->randomElement(['Teknologi','Perbankan','Manufakturing','Finansial','Otomotif']),
            'nama_pendaftar'    => $this->faker->name(),
            'website'           => $this->faker->url(),
            'logo'              => null,
            'deskripsi'         => $this->faker->paragraph(),
        ];
    }
}
