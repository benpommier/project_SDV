<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Annonce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    public function annonces(Request $request)
    {
        $annonces = Annonce::query();

        if ($request->input('localisation_id') && !empty($request->localisation_id) && $request->localisation_id !== '0') {
            $annonces->where('localisation_id', $request->input('localisation_id'));
        }

        if ($request->input('prix_min') && !empty($request->prix_min)) {
            $annonces->where('price', '>=', $request->input('prix_min'));
        }
    
        if ($request->input('prix_max') && !empty($request->prix_max)) {
            $annonces->where('price', '<=', $request->input('prix_max'));
        }

        if ($request->input('nb_coloc') && !empty($request->nb_coloc) && $request->nb_coloc !== '1') {
            $annonces->where('nb_coloc', '=', $request->input('nb_coloc'));
        }

        $annonces = $annonces->orderBy('id')->get();
        return view('annonce/annonces', [
            'annonces' => $annonces
        ]);
    }

    // Page de détails des annonces
    public function more($id)
    {
        $annonce = Annonce::findOrFail($id);
        $images = $annonce->images;
        
        return view('annonce/annonce-more', [
            'annonce' => $annonce,
            'images' => $images
        ]);
    }
    
    // Page de création des annonces
    public function creation()
    {
        $tags = Tag::orderBy('id')->get();
        
        if (!Gate::allows('annonce-access')) {
            abort('403');
        }
        return view('annonce/annonce-creation', [
            'tags' => $tags
        ]);
    }

    // Création des annonces
    public function store(Request $request)
    {
        // Valide toutes les données du formulaire
        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        // Récupère toutes les données du formulaire
        $annonce = Annonce::create([
            'title' => $request->title,
            'address' => $request->address,
            'price' => $request->price,
            'content' => $request->content,
            'nb_coloc' => $request->nb_coloc,
            'user_id' => $request->user()->id,
            'localisation_id' => $request->localisation_id,
        ]);
        
        // Récupère les fichiers images téléchargées
        $images = $request->file('images');

        // Vérifie s'il y a des images téléchargées
        if ($images) {
            foreach ($images as $image) {
                // Enregistre l'image dans le système de fichiers
                $path = $image->store('public/images');

                // Transforme le chemin en une URL relative
                $relativePath = str_replace('public/', '', $path);

                // Crée une nouvelle photo reliée à l'annonce créée
                $annonce->images()->create([
                    'path' => $relativePath
                ]);
            }
        }

        // Ajouts des tags dans une annonce
        $tags = $request->input('tags');
        $annonce->tags()->sync($tags);
        
        event(new Registered($annonce));
        return redirect()->route('annonces');
    }

    // Inscription des users à une annonce
    public function subscribe($id)
    {
        $annonce = Annonce::findOrFail($id);
        $user = Auth::user();

        // Vérifier que l'utilisateur n'est pas déjà inscrit à une annonce
        if ($user->annonces()->count() > 0) {
            return redirect()->back()->with('error', 'Vous êtes déjà inscrit à une annonce.');
        }

        // Créer la relation annonce_user
        $annonce->users()->attach($user);

        return back()->with('success', 'Inscription réussie !');
    }

    public function unsubscribe(Request $request, Annonce $annonce)
    {
        $user = Auth::user();
        
        // Vérifier si l'utilisateur est inscrit à l'annonce
        if ($annonce->users()->where('user_id', $user->id)->exists()) {
            
            // Supprimer la relation
            $annonce->users()->detach($user->id);
            
            // Rediriger l'utilisateur vers la page de l'annonce
            return back()->with('success', 'Désinscription réussie !');
        } else {
            // Si l'utilisateur n'est pas inscrit, rediriger vers la page de l'annonce avec un message d'erreur
            return redirect()->back()->with('error', 'Vous n\'étiez pas inscrit à l\'annonce');
        }
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
