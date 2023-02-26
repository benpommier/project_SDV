<x-app-layout>
    <!-- Partie présentation des annonces -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                <!-- Affichage des images et du reste de la présentation de l'annonce -->
                @if($annonce->images->count() > 0)
                    <div class="slideshow-container">

                        @foreach ($annonce->images as $image)
                            <div class="mySlides fade">
                                <img src="{{ asset('storage/' . $image->path) }}" width="40%" alt="Mon image" class="mx-auto">
                            </div>
                        @endforeach
                        <!-- <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a> -->
                    </div>
                @else
                    <div class="col-md-12">
                        <img src="{{ asset('storage/images/' . 'default.png') }}" alt="Image par défaut" width="40%" class="mx-auto">
                    </div>
                @endif

                <!-- Titre et annonce -->
                <div class="max-w-xl">
                    <p class="font-bold"> {{ $annonce->title }}</p>
                    <p> {{ $annonce->price }}€ / mois </p>
                </div>

                <!-- Titre et annonce -->
                <div class="max-w-xl">
                    <p class="font-bold"> Nombre de colocataires maximum pour ce logement</p>
                    <p> {{ $annonce->nb_coloc }} colocataires. </p>
                </div>

                <div class="max-w-xl">
                    <p class="font-bold"> Se trouve à</p>
                    <p> {{ $annonce->address }}</p>
                </div>

                <div class="max-w-xl">
                    <p class="font-bold"> Description du professionnel</p>
                    <p> {{ $annonce->content }} </p>
                </div>

                <div class="max-w-xl">
                    <p class="font-bold"> Ce que propose ce logement </p>
                    @forelse($annonce->tags as $tag) 
                        <p>{{ $tag->name }}</p>
                    @empty
                    <span> Aucune information supplémentaire renseignée </span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Si utilisateur connecté, on lui donne les droits de s'inscrire à une annonce et de voir les inscrits -->
    @if (Auth::check())
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h2 class="text-lg font-medium text-gray-900 font-bold">
                    Les utilisateurs suivant sont inscrits à cette annonce :
                </h2>

                <div class="max-w-xl">
                @foreach ($annonce->users as $user)
                    <p>{{ $user->name }}</p>
                @endforeach
                
                <!-- Vérifie que les utilisateurs locataires ne peuvent pas s'inscrire -->
                @if (in_array(Auth::user()->group_id, [2, 3]))
                    <!-- Vérifie que les utilisateurs locataires ne peuvent pas s'inscrire et que l'annonce n'est pas pleine -->
                    @if ($annonce->users->where('id', Auth::id())->isEmpty() && ($annonce->users->count() < $annonce->nb_coloc))
                    <form method="POST" action="{{ route('annonces.subscribe', $annonce->id) }}">
                        @csrf
                        <p> Souhaitez-vous vous <button type="submit" class="btn btn-primary font-bold">inscrire</button> à ce logement ?</p>
                    </form>
                    @elseif ($annonce->users->where('id', Auth::id())->isNotEmpty() && ($annonce->users->count() <= $annonce->nb_coloc))
                    <form method="POST" action="{{ route('annonces.unsubscribe', $annonce->id) }}">
                        @csrf
                        @method('DELETE')
                        <p> Souhaitez-vous vous <button type="submit" class="btn btn-primary font-bold">désinscrire</button> de ce logement ?</p>
                    </form>
                    @endif
                @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Si utilisateur connecté, on lui donne les droits de supprimer l'annonce -->
    @if (Auth::check() && in_array(Auth::user()->group_id, [1, 3]) && $annonce->user_id == Auth::user()->id)
    <!-- Voir text file bureau si le temps pour modifications de photos -->

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Supprimer l\'annonce') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Une fois que votre annonce est supprimée, celle-ci sera définitivement supprimée. 
                                    Avant de supprimer votre annonce, merci de sauvegarder toutes les données que vous souhaitez conserver.') }}
                            </p>
                        </header>
                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-annonce-deletion')"
                        >{{ __('Supprimer l\'annonce') }}</x-danger-button>
                        <x-modal name="confirm-annonce-deletion" :show="$errors->annonceDeletion->isNotEmpty()" focusable>
                            <form method="post" action="{{ route('annonce.destroy', $annonce->id) }}" class="p-6">
                                @csrf
                                @method('delete')

                                <h2 class="text-lg font-medium text-gray-900">
                                    {{ __('Êtes-vous sur de vouloir supprimer votre annonce ?') }}
                                </h2>

                                <p class="mt-1 text-sm text-gray-600">
                                    {{ __('Une fois que votre annonce est supprimée, celle-ci sera définitivement supprimée. 
                                    Avant de supprimer votre annonce, merci de sauvegarder toutes les données que vous souhaitez conserver.') }}
                                </p>
                                <div class="mt-6">
                                    <x-input-label for="password" value="Password" class="sr-only" />

                                    <x-text-input
                                        id="password"
                                        name="password"
                                        type="password"
                                        class="mt-1 block w-3/4"
                                        placeholder="Password"
                                    />

                                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                                </div>
                                <div class="mt-6 flex justify-end">
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Annuler') }}
                                    </x-secondary-button>

                                    <x-danger-button class="ml-3">
                                        {{ __('Supprimer l\'annonce') }}
                                    </x-danger-button>
                                </div>
                            </form>
                        </x-modal>
                    </section>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>