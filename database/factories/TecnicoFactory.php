<?php

namespace Database\Factories;

use App\Models\Tecnico;
use Illuminate\Database\Eloquent\Factories\Factory;

class TecnicoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tecnico::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'birth' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'rg' => $this->faker->buildingnumber,
            'cpf' => $this->faker->buildingnumber,
            'ctps' => $this->faker->buildingnumber,
            'cnh' => $this->faker->buildingnumber,
            'phone' => $this->faker->buildingnumber,
        ];
    }
}
