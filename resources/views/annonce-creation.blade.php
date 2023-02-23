<x-app-layout>
<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">

    <form method="POST" action="{{ route('annonce.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Titre -->
        <div>
            <x-input-label for="title" :value="__('Titre')" />
            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
            <x-input-error :messages="$errors->get('title')" class="mt-2" />
        </div>

        <!-- Adresse -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Adresse')" />
            <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Localisation_id -->
        <div class="mt-4">
            <x-input-label for="localisation_id" :value="__('Localisation :')" />
            <select id="localisation_id" class="form-input block mt-1 w-full" name="localisation_id" required>
                @foreach (\App\Models\Localisation::all() as $localisation)
                <option value="{{ $localisation->id }}">{{ $localisation->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Prix -->
        <div class="mt-4">
            <x-input-label for="price" :value="__('Prix / mois en euros')" />
            <x-text-input id="price" class="block mt-1 w-full" type="text" name="price" :value="old('price')" required />
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-input-label for="content" :value="__('Description')" />
            <x-text-input id="content" class="block mt-1 w-full" type="text" name="content" :value="old('content')" required />
            <x-input-error :messages="$errors->get('content')" class="mt-2" />
        </div>

        <!-- Ajouts de photos (en cours) -->
        <div class="mt-4">
            <label for="images">Obligé de mettre une photo, implémentation en cours, ne fonctionne pas encore</label>
            <input id="images" type="file" name="images">
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ml-4">
                {{ __('Créer l\'annonce') }}
            </x-primary-button>
        </div>
    </form>
</div>
</x-app-layout>
