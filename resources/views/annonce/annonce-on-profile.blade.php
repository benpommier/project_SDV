<x-app-layout>
    
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vos annonces') }}
        </h2>
    </x-slot>
    </br>
    
    <!-- On présente toutes les annonces que possède une personne -->
    @if ($annonces->count() > 0)
    <div class="center">
    <table class="tableAnnonce table-auto w-full border-collapse bg-white">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Adresse</th>
                <th>Localisation</th>
                <th>Prix</th>
                <th>Colocataires</th>
                <th>Description</th>
                <th>URL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($annonces as $annonce)
                <tr>
                    <td data-label="Nom" class="text-left">{{ $annonce->title }}</td>
                    <td data-label="Adresse">{{ $annonce->address }}</td>
                    <td data-label="Localisation">{{ $annonce->localisation->name }}</td>
                    <td data-label="Prix" class="text-right">{{ $annonce->price }} €</td>
                    <td data-label="Colocataires" class="text-center">
                        @foreach ($annonce->users as $user)
                            <p>{{ $user->name }}</p>
                        @endforeach
                    </td>
                    <td data-label="Description">{{ $annonce->short_content }}</td>
                    <td data-label="URL" class="text-center">
                        <a class="btn btn-primary font-bold py-2 px-4 rounded" href="{{ route('annonce.more', ['id' => $annonce->id]) }}">Détails</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    @else
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                   Vous n'avez pas encore créé d'annonce.
                </div>
            </div>
        </div>
    </div>
    @endif

</x-app-layout>