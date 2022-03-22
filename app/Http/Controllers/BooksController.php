<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Spatie\QueryBuilder\QueryBuilder;

class BooksController extends Controller
{
    public function index()
    {
        $books = QueryBuilder::for(Book::class)
            ->allowedSorts(['name', 'release_date'])
            ->latest('release_date')
            ->get();
        return response()->json($books,200);
    }
}