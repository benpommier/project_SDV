<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{

    public function home()
    {
        return view('welcome');
    }

    // Page des annonces
    public function annonces()
    {
        $annonces = Annonce::orderBy('id')->get();
        return view('annonces', [
            'annonces' => $annonces
        ]);
    }

    // Page de détails des annonces
    public function more($id)
    {
        $annonce = Annonce::findOrFail($id);
        
        return view('annonce-more', [
            'annonce' => $annonce
        ]);
    }
    
    // Page de création des annonces
    public function creation()
    {
        if (!Gate::allows('annonce-creation-access')) {
            abort('403');
        }
        return view('annonce-creation');
    }

    // Création des annonces
    public function store(Request $request)
    {
        Storage::disk('public')->put('Images', $request->images);
        
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
        ]);

        $annonce = Annonce::create([
            'title' => $request->title,
            'address' => $request->address,
            'price' => $request->price,
            'content' => $request->content,
            'user_id' => $request->user()->id,
            'localisation_id' => $request->localisation_id,
        ]);
        
        event(new Registered($annonce));
        return redirect()->route('annonces');
    }

    // Destroy des annonces
    public function destroy(Request $request, $id): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $annonce = Annonce::findOrFail($id);

        $annonce->delete();
        return redirect()->route('annonces');
    }
}
