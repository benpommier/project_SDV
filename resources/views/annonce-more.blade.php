<x-app-layout>
    <!-- Partie présentation des annonces -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <p> {{ $annonce->title }}</p>
                    <p style="text-align: right;"> {{ $annonce->price }} euros / mois </p>
                </div>
                <div class="max-w-xl">
                    <p> à {{ $annonce->address }}</p>
                </div>
                <div class="max-w-xl">
                    <h1 style="font-weight: bold;">Description du professionnel</h1>
                    <p> {{ $annonce->content }} </p>
                </div>
            </div>

            
        </div>
    </div>
    <!-- Si utilisateur connecté, on lui donne les droits de supprimer l'annonce (d'ajouter des photos si faisable) -->
    @if (Auth::check() && Auth::user()->group_id == 1 && $annonce->user_id == Auth::user()->id)
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <label for="photos"> Choisissez vos photos : (EN COURS DE DEV - NE FONCTIONNE PAS)</label>
                    <br>
                    <input type="file" id="photos" name="photos"
                        accept="image/png, image/jpeg">
                </div>
            </div>
        </div>
    </div>
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