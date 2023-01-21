<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventDate>
 */
class SesionEventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'evento_id' => random_int(DB::table('events')->min('id'), DB::table('events')->max('id')),
            'fecha_inicio' => $this->faker ->dateTime('2022-01-25'),
            'fecha_fin' => $this->faker ->dateTime('2022-01-25'),
            'lugar' => $this->faker -> text(20),
            'cupos' => $this->faker -> randomNumber(3),
            'precio' => $this->faker -> randomFloat(2, 1, 100000),
            'descuento' => $this->faker -> randomFloat(2, 1, 100000),

        ];
    }
}
