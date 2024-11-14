<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    //Method that retrieves all users of db.
    function getComments()
    {
        $comments = Comment::all();
        
        foreach($comments as $comment){
            $comment->user;
            $comment->article;
        }


        return response()->json(
            $comments,
            200
        );
    }

    //Method that retrieves a certain user of db.
    function getComment(int $id)
    {

        try {
            $comment = Comment::find($id);
            $comment->user;
            $comment->article;

            if ($comment == null) {
                return response()->json(
                    ["error" => "The article you are looking for doesn't exist"],
                    404
                );
            }


            return response()->json(
                $comment,
                200
            );
        } catch (Exception $e) {
        }
    }


    //Method that creates a new user on db.
    function createComment(Request $request)
    {
        $validated = $request->validate([
            "content" => ["required", "max:2048"],
            "article_id" => ["required", "integer"]
        ]);


        $comment = new Comment();
        $comment->content = $request['content'];
        $comment->date = date("m-d-Y");
        $comment->time = date("H:i");
        $comment->user_id = $request->user()->id;
        $comment->article_id = $request['article_id'];

        $comment->save();

        return response()->json(
            [
                "comment_id" => $comment->id,
                "message" => "Comment succesfully created"
            ],
            200
        );
    }

    //Method that edits an existing user of db.
    function editComment(Request $request, int $id)
    {
        $validated = $request->validate([
            "content" => ["required", "max:2048"]
        ]);


        $comment = Comment::find($id);

        if ($request->user()->hasRole(['user', 'writer'])) {
            if ($comment->user_id != $request->user()->id) {
                return response()->json(
                    ["message" => "You are not allowed to edit this comment"],
                    401
                );
            }
        }

        if ($request->content) {
            $comment->content = $request['content'];
        }


        if ($request->user_id) {
            $comment->user_id = $request['user_id'];
        }

        if ($request->article_id) {
            $comment->article_id = $request['article_id'];
        }

        if ($request->date) {
            $comment->date = date("m-d-Y");
        }

        if ($request->time) {
            $comment->time = date("H:i");
        }

        $comment->save();

        return response()->json(
            [
                "comment_id" => $comment->id,
                "comment" => $comment,
                "message" => "Article succesfully edited"
            ],
            200
        );


        return response()->json($request->user(), 200);
    }
}
