<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::findOrFail(1);
        return view('index')->with('comments', $comments);
    }

    public function comment($id)
    {
        $comment = Comment::where('id', $id)->get();
        return view('index')->with('comment', $comment);
    }
}
