<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImagesController extends Controller
{
    function profileImage(Request $request, string $id)
    {

        if ($id == 0) {
            return response()->file(resource_path() . "/images/account.png");
        }


        return response()->file(resource_path() . "/images/" . $id . ".png");
    }
}
