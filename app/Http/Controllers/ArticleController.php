<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Exception;

class ArticleController extends Controller
{


    function getAllArticles()
    {
        $articles = Article::all();
        //load writer subobject
        foreach ($articles as $article) {
            $article->writer;
        }

        //return articles.
        return response()->json(
            $articles,
            200
        );
    }

    //Method that retrieves all users of db.
    function getArticles(Request $request)
    {
        $articles = Article::paginate(6);
        //load writer subobject
        foreach ($articles as $article) {
            $article->writer;
        }


        if ($_GET == null) {
            //return articles.
            return response()->json(
                $articles,
                200
            );
        }


        //Filtering articles based on its section:
        if ($request->input('section') === 'The Thought') {
            $articles = Article::where('section', '=', "The Thought")->paginate(15);
        }

        if ($request->input('section') === 'Dear Fashion') {
            $articles = Article::where('section', '=', "Dear Fashion")->paginate(15);
        }

        if ($request->input('section') === 'Mucho más que anuncios') {
            $articles = Article::where('section', '=', "Mucho más que anuncios")->paginate(15);
        }


        //return articles.
        return response()->json(
            $articles,
            200
        );
    }


    //Method that retrieves all users of db.
    function getWriterArticles(Request $request)
    {
        $id = $request->user()->id;
        $articles = Article::where("writer_id", $id)->get();
        //load writer subobject
        foreach ($articles as $article) {
            $article->writer;
        }


        return response()->json(
            $articles,
            200
        );
    }

    //Method that retrieves a certain user of db.
    function getArticle(int $id)
    {

        try {
            $article = Article::find($id);

            //load subobjects
            $article->writer;
            $article->comments;
            foreach ($article->comments as $comment) {
                $comment->user;
            }

            if ($article == null) {
                return response()->json(
                    ["error" => "The article you are looking for doesn't exist"],
                    404
                );
            }


            return response()->json(

                $article,
                200
            );
        } catch (Exception $e) {
        }
    }


    //Method that creates a new user on db.
    function createArticle(Request $request)
    {
        if ($request->user()->hasRole('user')) {
            return response()->json(
                ["message" => "You are not allowed to create an article"],
                401
            );
        }


        $validated = $request->validate([
            "title" => ["required", "max:100"],
            "subtitle" => ["required", "max:50"],
            "content" => ["required", "max:10000"]
        ]);


        $article = new Article();
        $article->title = $request['title'];
        $article->subtitle = $request['subtitle'];
        $article->content = $request['content'];
        $article->writer_id = $request->user()->id;
        $article->date = date("m-d-Y");
        $article->time = date("H:i");


        if ($request->photo != "") {
            $article->photo = $request['photo'];
        }

        $article->save();

        return response()->json(
            [
                "article_id" => $article->id,
                "article" => $article,
                "message" => "Article succesfully created"
            ],
            200
        );
    }



    function deleteArticle(Request $request, int $id)
    {

        if ($request->user()->hasRole('user')) {
            return response()->json(
                ["message" => "You are not allowed to edit this article"],
                401
            );
        }


        $article = Article::find($id);



        //If writer user tries to delete another person's article.
        if ($request->user()->hasRole('writer')) {
            $NOT_MY_ARTICLE = $request->user()->id != $article->writer_id;
            if ($NOT_MY_ARTICLE) {
                return response()->json(
                    ["message" => "You are not allowed to edit this article"],
                    401
                );
            }
        }


        $article->delete();


        return response()->json(
            [
                "article_id" => $article->id,
                "article" => $article,
                "message" => "Article succesfully deleted"
            ],
            200
        );
    }

    //Method that edits an existing user of db.
    function editArticle(Request $request, int $id)
    {
        if ($request->user()->hasRole('user')) {
            return response()->json(
                ["message" => "You are not allowed to edit this article"],
                401
            );
        }


        $validated = $request->validate([
            "title" => ["required", "max:100"],
            "subtitle" => ["required", "max:50"],
            "content" => ["required", "max:10000"],
            "photo" => [""]
        ]);

        $article = Article::find($id);

        //If writer user tries to edit another person's article.
        if ($request->user()->hasRole('writer')) {
            $NOT_MY_ARTICLE = $request->user()->id != $article->writer_id;
            if ($NOT_MY_ARTICLE) {
                return response()->json(
                    ["message" => "You are not allowed to edit this article"],
                    401
                );
            }
        }


        $article->title = $request['title'];
        $article->subtitle = $request['subtitle'];
        $article->content = $request['content'];


        if ($request->photo != "" && $request->photo != $article->photo) {
            $article->photo = $request['photo'];
        }

        $article->save();

        return response()->json(
            [
                "article_id" => $article->id,
                "article" => $article,
                "message" => "Article succesfully edited"
            ],
            200
        );
    }
}
