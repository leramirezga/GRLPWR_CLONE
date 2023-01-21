<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker -> text(20),
            'descripcion' => $this->faker -> text(255),
            'imagem' => $this->faker -> text(20),
            'info_adicional' => $this->faker -> text(255),
        ];
    }
}
