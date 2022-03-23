<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use App\Models\Character;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CharactersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //loop from one to 43
        for ($i = 1; $i <= 43; $i++) {
        //fetch characters from api
        $characters = json_decode(file_get_contents("https://anapioficeandfire.com/api/characters/?page={$i}&pageSize=50"));
        //insert the character into the characters table
        foreach ($characters as $character) {
            Character::create([
                'name' => $character->name,
                'gender' => $character->gender,
                'culture' => $character->culture,
                'url' => $character->url,
                'aliases' => $character->aliases
            ]);
            //get character books
            $books = $character->books;
            foreach ($books as $book){
                //get book id
                $book_id = Book::where('url', $book)->first()->id;
                //get character id
                $character_id = Character::where('url', $character->url)->first()->id;
                //insert into book_character table
                DB::table('book_character')->insert([
                    'book_id' => $book_id,
                    'character_id' => $character_id
                ]);
            }

        }
    }

    }
}
