<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 'name' => $book->name,
        // 'publisher' => $book->publisher,
        // 'isbn' => $book->isbn,
        // 'country' => $book->country,
        // 'release_date' => $book->released,
        // 'number_of_pages' => $book->numberOfPages,
        // 'url' => $book->url,
        // 'media_type' => $book->mediaType
        return [
            'name' => $this->faker->name,
            'publisher' => $this->faker->name,
            'isbn' => $this->faker->isbn13,
            'country' => $this->faker->country,
            'release_date' => $this->faker->date,
            'number_of_pages' => $this->faker->numberBetween(100, 1000),
            'url' => $this->faker->url,
            'media_type' => $this->faker->randomElement(['Book', 'E-Book', 'Audio Book']),
        ];
    }
}
