<?php

namespace Tests;

use App\Models\Book;
use App\Models\Character;
use Laravel\Lumen\Testing\DatabaseMigrations;

class CharacterControllerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_character_index_status_should_be_200()
    {
        //create book from Factory
        $book = Book::factory()->create();
        //get characters from api
        $this->get("books/{$book->id}/characters")
            ->seeStatusCode(200);
    }
    public function test_character_index_returns_a_collection_of_items()
    {
        //create book from Factory
        $book = Book::factory()->create();
        //create characters from Factory
        $characters = Character::factory()->count(10)->create();
        $book->characters()->syncWithoutDetaching($characters->pluck('id')->toArray());
        //get characters from api
        $this->get("books/{$book->id}/characters")
            ->seeJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'born',
                        'died',
                        'culture',
                        'age'
                    ]
                ],
                'meta' => [
                    'total',
                    'from',
                    'to',
                    'per_page',
                    'current_page',
                    'last_page'
                ]
            ]);
    }

    public function test_character_index_can_sort_by_name()
    {
        $book = Book::factory()->create();
        $ch1 = Character::factory()->create(['name' => 'BAAAA']);
        $ch2 = Character::factory()->create(['name' => 'AAAAA']);
        $ch3 = Character::factory()->create(['name' => 'CDDDD']);
        $ch4 = Character::factory()->create(['name' => 'DDDDD']);
        $book->characters()->syncWithoutDetaching([$ch1->id, $ch2->id, $ch3->id, $ch4->id]);
        $this->get('/books/' . $book->id . '/characters?sort=name');
        $data = json_decode($this->response->getContent(), true);
        $this->assertEquals('AAAAA', $data['data'][0]['name']);
    }
    public function test_character_index_can_sort_by_gender()
    {
        $book = Book::factory()->create();
        $ch1 = Character::factory()->create(['gender' => 'Male']);
        $ch2 = Character::factory()->create(['gender' => 'Female']);
        $ch3 = Character::factory()->create(['gender' => 'Male']);
        $ch4 = Character::factory()->create(['gender' => 'Female']);
        $book->characters()->syncWithoutDetaching([$ch1->id, $ch2->id, $ch3->id, $ch4->id]);
        $this->get('/books/' . $book->id . '/characters?sort=-gender');
        $res = json_decode($this->response->getContent(), true);
        $this->assertEquals('Female', $res['data'][0]['gender']);
        $this->assertEquals('Female', $res['data'][1]['gender']);
    }
    public function test_character_index_can_sort_by_age()
    {
        $book = Book::factory()->create();
        $ch1 = Character::factory()->create(['born' => '2017-01-01']);
        $ch2 = Character::factory()->create(['born' => '2016-01-01']);
        $ch3 = Character::factory()->create(['born' => '2017-02-01']);
        $book->characters()->syncWithoutDetaching([$ch1->id, $ch2->id, $ch3->id]);
        $this->get('/books/' . $book->id . '/characters?sort=age');
        $res = json_decode($this->response->getContent(), true);
        $this->assertEquals('2016-01-01', $res['data'][0]['born']);
    }
    public function test_character_index_returns_meta_data_fields()
    {
        $book = Book::factory()->create();
        $ch1 = Character::factory()->create(['born' => '2017-01-01']);
        $ch2 = Character::factory()->create(['born' => '2016-01-01']);
        $ch3 = Character::factory()->create(['born' => '2018-01-01']);

        //calculate the total age of characters today from born field
        $totalAge = $ch1->age['years'] + $ch2->age['years'] + $ch3->age['years'];
        $book->characters()->syncWithoutDetaching([$ch1->id, $ch2->id, $ch3->id]);
        $this->get('/books/' . $book->id . '/characters?sort=age');
        $this->seeJsonStructure([
            'meta' => [
                'total_age'
            ]
        ]);
        //asert total_age in meta equals $totalAge
        $this->seeJson(
            [
                'total_age' => $totalAge
            ]
        );
    }
}
