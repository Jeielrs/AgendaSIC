<?php

namespace Database\Factories;

use App\Models\Padrao;
use Illuminate\Database\Eloquent\Factories\Factory;

class PadraoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Padrao::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tag' => $this->faker->userName(),
            'description' => $this->faker->text(),
            'expiration' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
