<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function annonces()
    {
        return view('annonces');
    }
}
