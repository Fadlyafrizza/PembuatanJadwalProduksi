<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mesin>
 */
class MesinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $status = ['aktif', 'nonaktif', 'perawatan'];

        return [
            'nama' => fake()->text(10),
            'tipe' => fake()->text(10),
            'kapasitas' => fake()->numberBetween(1, 100),
            'status' => $status[array_rand($status)],
        ];
    }
}
