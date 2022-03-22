<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //fetch books from https://anapioficeandfire.com/api/books?pageSize=50
        $books = json_decode(file_get_contents('https://anapioficeandfire.com/api/books?pageSize=50'));
        //insert the book into books table
        foreach ($books as $book) {
            $bookModel = Book::create([
                'name' => $book->name,
                'publisher' => $book->publisher,
                'isbn' => $book->isbn,
                'country' => $book->country,
                'release_date' => $book->released,
                'number_of_pages' => $book->numberOfPages,
                'url' => $book->url,
                'media_type' => $book->mediaType
            ]);
            //insert author into authors table
            foreach ($book->authors as $author) {
                Author::create([
                    'name' => $author,
                    'book_id' => $bookModel->id
                ]);
            }
        }

    }
}
