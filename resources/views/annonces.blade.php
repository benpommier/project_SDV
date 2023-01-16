@extends('layouts.app')

@section('content')
<h1> Toutes les annonces</h1>

    @if ($annonces->count() > 0)
        @foreach($annonces as $annonce)
            <p> <a href="{{ route('annonces.description', ['id' => $annonce->id]) }}"> {{ $annonce->title }} </a></p>
        @endforeach
    @else
        <span> Aucune annonces en base de données </span>
    @endif
@endsection