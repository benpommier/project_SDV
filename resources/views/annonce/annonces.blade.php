<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Toutes les annonces') }}
        </h2>
    </x-slot>
    <br>

    <!-- Va falloir créer la barre de recherche des annonces -->
    
    <!-- Toutes les annonces actuellement en ligne -->
    @if ($annonces->count() > 0)
        <div class="row">
        @foreach($annonces as $annonce)
            <div class="column">
                <div class="card">
                    @if($annonce->images->count() > 0)
                        <img src="{{ asset('storage/' . $annonce->images->first()->path) }}" alt="Mon image" width="50%" class="mx-auto">
                    @else
                        <div class="col-md-12">
                            <img src="{{ asset('storage/images/' . 'default.png') }}" alt="Image par défaut" width="20%" class="mx-auto">
                        </div>
                    @endif
                    <div class="container">
                        <h2>{{ $annonce->title }}</h2>
                        <p class="title">{{ $annonce->subtitle }}</p>
                        <p>{{ $annonce->short_content }}</p>
                        <p>{{ $annonce->price }} €</p>
                        <p><a class="detail-button" href="{{ route('annonce.more', ['id' => $annonce->id]) }}">Détails</a></p>
                        <br>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    @else
        <span> Aucune annonce disponible dans votre secteur </span>
    @endif
</x-app-layout>