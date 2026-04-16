<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AreaParkirFactory extends Factory
{
    public function definition(): array
    {
        $kapasitas = $this->faker->numberBetween(20, 200);
        $terisi    = $this->faker->numberBetween(0, $kapasitas);

        return [
            'nama_area' => 'Lantai '.$this->faker->numberBetween(1, 4).' - Blok '.$this->faker->randomLetter(),
            'kapasitas' => $kapasitas,
            'terisi'    => $terisi,
        ];
    }
}
