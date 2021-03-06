<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Character;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class CharacterController extends Controller
{
    public function index($id)
    {
        //make the maxmum perpage 50 and min per page 1
        $per_page = request()->input('per_page', 10);
        $per_page = min(50, $per_page);
        $per_page = max(1, $per_page);
        
        $book = Book::findOrFail($id);
        $query = $book->characters();
        $characters = QueryBuilder::for($query)
            ->allowedFilters(['name', 'gender'])
            ->allowedSorts(['name', 'gender',AllowedSort::field('age','born')])
            ->latest()
            ->paginate($per_page);

        //get years field from $characters data and sum them
        $totalAge = $characters->sum(function ($character) {
            return $character->age['years'];
        });
        $meta = [
            'total_age'=>$totalAge,
        ];
        return $this->respondWithCollection($characters,$meta);
    }
}