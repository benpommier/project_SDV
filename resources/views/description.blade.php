@extends('layouts.app')

@section('content')
    <h1> Description de l'annonce </h1>

    <p> Sous titre : {{ $annonce->subtitle }}</p>
    <p> Contenu : {{ $annonce->content }}</p>


    <hr>
    @foreach($annonce->images as $image)
        <div> {{ $image->path }}</div>
    @endforeach
    <p>Cette annonce a été crée par : {{ $annonce->user->name }}</p>




    <hr>
    <h4>Espace commentaire :</h4>
    @forelse($annonce->comments as $comment)
        <div> {{ $comment->content }} </div>
    @empty
        <span> Aucun commentaire pour ce post. </span>
    @endforelse
    <hr>
@endsection