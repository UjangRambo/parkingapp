<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TarifFactory extends Factory
{
    public function definition(): array
    {
        return [
            'jenis_kendaraan' => $this->faker->randomElement(['motor', 'mobil', 'lainnya']),
            'tarif_per_jam'   => $this->faker->randomElement([2000, 3000, 5000]),
        ];
    }
}
