<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function show()
    {
        $annonces = Annonce::all();

        return view('annonces', [
            'annonces' => $annonces
        ]);
    }

    public function description($id)
    {
        $annonce = Annonce::findOrFail($id);

        return view('description', [
            'annonce' => $annonce
        ]);
    }

    
    public function func_deux()
    {
        return view('jerome');
    }
}