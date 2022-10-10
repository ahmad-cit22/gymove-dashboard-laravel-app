<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class frontendController extends Controller
{
    function blog()
    {
        return view('blog');
    }
    function services()
    {
        return view('services');
    }
}
