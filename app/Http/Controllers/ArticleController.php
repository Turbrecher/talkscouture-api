<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Any;

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
        $articles = Article::orderBy('date','desc')->orderBy('time','desc')->paginate(6);
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
            $articles = Article::where('section', '=', "The Thought")->orderBy('date','desc')->orderBy('time','desc')->paginate(15);
        }

        if ($request->input('section') === 'Dear Fashion') {
            $articles = Article::where('section', '=', "Dear Fashion")->orderBy('date','desc')->orderBy('time','desc')->paginate(15);
        }

        if ($request->input('section') === 'Mucho más que anuncios') {
            $articles = Article::where('section', '=', "Mucho más que anuncios")->orderBy('date','desc')->orderBy('time','desc')->paginate(15);
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
        $articles = Article::where("writer_id", $id)->orderBy('date','desc')->orderBy('time','desc')->get();
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
            print($e);
        }
    }


    //Method that creates a new user on db.
    function createArticle(Request $request)
    {

        try {

            if ($request->user()->hasRole('user')) {
                return response()->json(
                    ["message" => "You are not allowed to create an article"],
                    401
                );
            }


            $validated = $request->validate([
                "title" => ["required", "max:100"],
                "description" => ["required", "max:500"],
                "content" => ["required"],
                "readTime" => ["required", "max:2"],
                "section" => ["required"],

            ]);

            $article = new Article();
            $article->title = $request->input('title');
            $article->description = $request->input('description');
            $article->content = $request->input('content');
            $article->readTime = $request->input('readTime');
            $article->section = $request->input('section');
            $article->writer_id = $request->user()->id;
            $article->date = date("Y.m.d");
            $article->time = date("H:i");


            if ($request->file('photo')) {
                $photo = $request->file('photo');
                $name = $request->file('photo')->hashName();
                Storage::put('articles/' . $name, file_get_contents($photo));
                $article->photo = $name;
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
        } catch (Exception $e) {
            return response()->json(
                [
                    "error" => $e,

                ],
                400
            );
        }
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
    function editArticle(Request $request)
    {
        try {

            if ($request->user()->hasRole('user')) {
                return response()->json(
                    ["message" => "You are not allowed to edit this article"],
                    401
                );
            }


            $validated = $request->validate([
                "id" => ['required'],
                "title" => ["required", "max:100"],
                "description" => ["required", "max:500"],
                "content" => ["required"],
                "readTime" => ["required"],
                "section" => ["required"]

            ]);

            $article = Article::find($request->input('id'));

            

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


            $article->title = $request->input('title');
            $article->description = $request->input('description');
            $article->content = $request->input('content');
            $article->readTime = $request->input('readTime');
            $article->section = $request->input('section');

            if ($request->file('photo')) {
                $photo = $request->file('photo');
                $name = $request->file('photo')->hashName();
                Storage::put('articles/' . $name, file_get_contents($photo));
                $article->photo =  $name;
            }


            $article->save();

            return response()->json(
                [
                    "article_id" => $article->id,
                    "article" => $article,
                    "message" => "Article succesfully edited",
                ],
                200
            );
        } catch (Exception $e) {
            return response()->json(
                [
                    "error" => $e
                ],
                400
            );
        }
    }
}
