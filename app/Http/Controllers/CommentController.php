<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index(Request $request,$id)
    {
        $book = Book::find($id);
        $comments = $book->comments()->latest('id')->get();
        return response()->json($comments,200);
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
