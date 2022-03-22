<?php

namespace Tests;

use App\Models\Book;
use App\Models\Comment;
use Database\Factories\BookFactory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class CommentControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function test_index_status_should_be_200()
    {
        //make book from factory
        $book = Book::factory()->create();
        //make comments from factory
        $this->get("books/{$book->id}/comments")
            ->seeStatusCode(200);
    }

    public function test_index_returns_comments_in_reverse_chronological_order(){
        $book = Book::factory()->create();
        $comments = Comment::factory()->count(3)->create([
            'book_id' => $book->id,
        ]);
        //get comments from api
        $response = $this->get("books/{$book->id}/comments");
        $resultComments = json_decode($this->response->getContent(), true);
        //check that comments are in reverse chronological order
        $this->assertEquals($resultComments[0]['id'], $comments[2]['id']);
        $this->assertEquals($resultComments[1]['id'], $comments[1]['id']);
    }
    public function test_index_should_return_acollection_of_comments()
    {
        $book = Book::factory()->create();
        $comments = Comment::factory()->count(3)->create([
            'book_id' => $book->id,
        ]);
        $this->get("books/{$book->id}/comments")
            ->seeJsonStructure([
                '*' => [
                    'id',
                    'body',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }
    public function test_store_should_save_comment(){
        //make book from factory
        $book = Book::factory()->create();
        //make comments from factory
        $this->post("books/{$book->id}/comments", [
            'body' => 'test comment',
        ])->seeStatusCode(201);
        //check that comment is in database
        $this->seeInDatabase('comments', [
            'body' => 'test comment',
            'book_id' => $book->id,
        ]);
    }
    public function test_store_returns_404_for_an_invalid_book(){
        $this->post('books/999/comments', [
            'body' => 'test comment',
        ])->seeStatusCode(404);
    }
    public function test_comment_length_should_be_lessthan_500(){
        $book = Book::factory()->create();
        //generate a comment of morethan 500 characters
        $comment = str_repeat('a', 501);
        $this->post("books/{$book->id}/comments", [
            'body' => $comment,
        ])->seeStatusCode(422)
            ->seeJson([
                'body' => ['The body must not be greater than 500 characters.'],
            ]);
    }
}