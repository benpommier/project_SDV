<x-app-layout>
            <!-- <div>
                <div class="float-start">
                    <h4 class="pb-3">Créer une tâche</h4>
                </div>
                <div class="float-end">
                    <a href="{{ route('taches') }}" class="btn btn-info">
                        <i class="fa fa-arrow-left"></i> Toutes les tâches
                    </a>
                </div>
                <div class="clearfix"></div>
            </div> -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg mx-auto">

                <form action="{{ route('tache.store') }}" method="POST">
                    @csrf
                    <!-- Titre -->
                    <div>
                        <x-input-label for="title" :value="__('Titre')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>
                    <!-- Description -->
                    <div class="mt-4">
                        <x-input-label for="description" :value="__('Description')" />
                            <x-secondary-button
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'help-information')"
                            ><i class="bi bi-info-circle"></i>
                            </x-secondary-button>
                            <x-modal name="help-information" focusable>
                                <div class="p-6">
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ __('Comment réaliser une bonne description de tâche ?') }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ __('La description de votre tâche s\'affichera dans la partie centrale de la tâche.') }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-600">
                                        {{ __('Nous vous conseillons de mettre la date d\'échéance, de lister les tâches ménagères (les pièces à nettoyer, ranger), ect ...') }}
                                    </p>
                                </div>
                            </x-modal>
                        <textarea id="content" class="block mt-1 w-full" name="description" id="description" :value="old('description')" required></textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <label for="status" class="form-label">Statut</label>
                        <select name="status" id="status" class="form-input block mt-1 w-full">
                            @foreach ($statuses as $status)
                                <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- <a href="{{ route('taches') }}" class="btn btn-secondary mr-2"><i class="fa fa-arrow-left"></i> Annuler</a> -->

                    <!-- Validation -->
                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Créer la tâche') }}
                        </x-primary-button>
                    </div>
                </form>
        </div>
</x-app-layout>