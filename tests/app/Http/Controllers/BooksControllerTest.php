<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class BooksControllerTest extends TestCase
{

    public function test_index_status_should_be_200()
    {
        $this->get('/books')
            ->seeStatusCode(200);
    }
    public function test_index_should_return_acollection_of_books()
    {
        $this->get('/books')
            ->seeJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'authors',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }
}
