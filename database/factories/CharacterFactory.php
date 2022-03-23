<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Character;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Character::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'gender' =>$this->faker->randomElement(['Male','Female']),
            'culture' =>$this->faker->randomElement(['Braavosi','Peatwa']),
            'url' =>$this->faker->url,
            'aliases' => [],
            'born' => $this->faker->date,
            'died' => $this->faker->date,
        ];
    }
}
