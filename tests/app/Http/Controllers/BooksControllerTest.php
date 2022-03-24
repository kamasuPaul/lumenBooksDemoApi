<?php

namespace Tests;

use App\Models\Book;
use App\Models\Comment;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BooksControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_index_status_should_be_200()
    {
        $this->get('/books')
            ->seeStatusCode(200);
    }
    public function test_index_should_return_acollection_of_books()
    {
        $this->get('/books')
            ->seeJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'authors',
                        'created_at',
                        'updated_at',
                        'comments_count',
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
    //function to test index returns books with comments count attached to them
    public function test_index_should_return_books_with_comments_count()
    {
        $book = Book::factory()->create();
        $book->comments()->save(Comment::factory()->make());
        $this->get('/books')
            ->seeJson([
                'id' => $book->id,
                'comments_count' => 1
            ]);
    }
    //test books are returned sorted by release_date from earliest to newest
    public function test_index_should_return_books_sorted_by_release_date()
    {
        //insert two books with different release_date
        $book1 = Book::factory()->create(['release_date' => '2017-01-01']);
        $book2 = Book::factory()->create(['release_date' => '2016-01-01']);
        $book3 = Book::factory()->create(['release_date' => '2017-02-01']);

        $this->get('/books');
        //compare release_date of book1 and book2
        $data = json_decode($this->response->getContent(), true)['data'];
        $this->assertEquals($data[0]['release_date'], '2017-02-01');
    }
}
