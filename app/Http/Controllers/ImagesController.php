<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Any;
use Intervention\Image\Facades\Image;


class ImagesController extends Controller
{
    function uploadImage(Request $request)
    {

        try {

            $img =  $request->file("img");
            Storage::put('images/' . $img->hashName(), $img);


            return response()->json([
                'title' => $request->input("title"),
                'aa' => $request->input("aa"),
                'bb' => $request->input("bb"),
                'img' => $request->file("img")->getClientOriginalName(),
            ]);
        } catch (Any $e) {
            return response()->json([
                'err' => "error"
            ]);
        }
    }


    function getImage(Request $request, string $name)
    {

        try {

            $img =  $request->file("img");
            $file = Storage::get('articles/' . $name);

            return response($file);
        } catch (Any $e) {
            return response()->json([
                'err' => "error"
            ]);
        }
    }
}
