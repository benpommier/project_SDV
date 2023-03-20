<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Toutes les annonces') }}
        </h2>
    </x-slot>
    <br>

    <!-- Va falloir créer la barre de recherche des annonces -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg w-full">
                <form method="GET" action="{{ route('annonces') }}">
                    <div class="form-row">
                        <div class="w-1/4">
                            <label for="prix_min" class="box-title">Prix minimum :</label>
                            <input type="number" name="prix_min" id="prix_min" value="{{ $prix_min ?? '' }}" min ="0" class="form-control block mt-1 w-2/3">
                        </div>

                        <div class="w-1/4">
                            <label for="prix_max" class="box-title">Prix maximum :</label>
                            <input type="number" name="prix_max" id="prix_max" value="{{ $prix_max ?? '' }}" min ="0" class="form-control block mt-1 w-2/3">
                        </div>

                        <div class="w-1/4">
                            <label for="localisation_id" class="box-title">Localisation :</label>
                            <select id="localisation_id" class="form-input block mt-1 w-2/3" name="localisation_id" required>
                                <option value="{{ 0 }}"> Partout </option>
                                @foreach (\App\Models\Localisation::all() as $localisation)
                                <option value="{{ $localisation->id }}">{{ $localisation->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-1/4">
                            <label for="nb_coloc" class="box-title">Nombre de colocataires :</label>
                            <select id="nb_coloc" class="form-input block mt-1 w-2/3" name="nb_coloc">
                                <option value="{{ 1 }}">Tout</option>
                                @for ($i = 2; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Rechercher') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toutes les annonces actuellement en ligne -->
    @if ($annonces->count() > 0)
        <div class="flex flex-wrap justify-center">
            @foreach($annonces as $annonce)
                <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 p-4">
                    <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl">
                        @if($annonce->images->count() > 0)
                            <img src="{{ asset('storage/' . $annonce->images->first()->path) }}" alt="Mon image" class="w-full h-64 object-cover">
                        @else
                            <img src="{{ asset('storage/images/' . 'default.png') }}" alt="Image par défaut" class="w-full h-64 object-cover">
                        @endif
                        <div class="px-4 py-2">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $annonce->title }}</h2>
                            <p class="text-gray-600 text-base">{{ $annonce->subtitle }}</p>
                            <p class="text-gray-700 text-base">{{ $annonce->short_content }}</p>
                            <p class="text-xl font-bold text-gray-900">{{ $annonce->price }} € / mois</p>
                            <a href="{{ route('annonce.more', ['id' => $annonce->id]) }}" class="btn btn-primary font-bold py-2 px-4 rounded mt-4 w-full">Détails</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <span class="grid place-items-center"> Aucune annonce disponible dans votre secteur ou avec les paramètres sélectionnés.</span>
    @endif
</x-app-layout>