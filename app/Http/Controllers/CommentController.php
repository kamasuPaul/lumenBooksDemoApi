<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index(Request $request,$id)
    {
        //make the maxmum perpage 50 and min per page 1
        $per_page = $request->input('per_page', 10);
        $per_page = min(50, $per_page);
        $per_page = max(1, $per_page);

        $book = Book::find($id);
        $comments = $book->comments()->latest('id')->paginate($per_page);
        return $this->respondWithCollection($comments);
    }	

    public function store(Request $request,$id)
    {
        $book = Book::findorFail($id);
        $this->validate($request, [
            'body' => 'required|min:2|max:500',
        ]);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->book_id = $book->id;
        $comment->ip_address = $request->ip();
        $comment->save();

        return response()->json($comment, 201);
    }
}
