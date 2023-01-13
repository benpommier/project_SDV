<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function func_un()
    {
        return view('ben');
    }

    public function func_deux()
    {
        return view('jerome');
    }
}