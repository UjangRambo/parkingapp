<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KendaraanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'plat_nomor'      => strtoupper($this->faker->bothify('? #### ??')),
            'jenis_kendaraan' => $this->faker->randomElement(['motor', 'mobil', 'lainnya']),
            'warna'           => $this->faker->colorName(),
            'pemilik'         => $this->faker->name(),
        ];
    }
}
