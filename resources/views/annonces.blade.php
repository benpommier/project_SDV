@extends('layouts.app')

@section('content')
<h1> Toutes les annonces</h1>
    
    @if ($annonces->count() > 0)
        <div class="row">
        @foreach($annonces as $annonce)
        
            <div class="column">
                <div class="card">
                    <img src="img1.jpg" alt="Jane" style="width:100%">
                    <div class="container">
                        <h2>{{ $annonce->title }}</h2>
                        <p class="title">{{ $annonce->title }}</p>
                        <p>{{ $annonce->short_content }}</p>
                        <p>{{ $annonce->price }} €</p>
                        <p><a class="test" href="{{ route('annonces.description', ['id' => $annonce->id]) }}">Détails</a></p>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    @else
        <span> Aucune annonces en base de données </span>
    @endif
@endsection