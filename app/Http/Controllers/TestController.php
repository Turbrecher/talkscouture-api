<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    function hello(){
        return response("This is a test controller response");
    }
}
