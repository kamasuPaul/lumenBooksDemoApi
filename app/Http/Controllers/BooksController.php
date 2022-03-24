<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->input('per_page', 10);
        //make the maxmum perpage 50 and min per page 1
        $per_page = min(50, $per_page);
        $per_page = max(1, $per_page);
        $books = QueryBuilder::for(Book::class)
            ->allowedSorts(['name', 'release_date'])
            ->latest('release_date')
            ->paginate($per_page);
        return $this->respondWithCollection($books);
    }
}