<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg w-full">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="d-flex justify-content-between">

                                <div class="flex items-center justify-end mt-4">
                                    <a href="{{ route('tache.creation') }}">
                                        <x-primary-button class="ml-4">
                                            {{ __('Créer une tâche') }}
                                        </x-primary-button>
                                    </a>
                                </div>

                                @forelse ($tasks as $task)
                                    <div class="card mt-4">
                                        <div class="border p-1">
                                            <span class="ml-4 mr-2 mt-1">{{ $task->title }}</span>
                                            
                                            @if ($task->created_at)
                                                <span class="inline-flex items-center px-2.5 py-0.5 mr-2 mb-1 rounded-full text-sm font-medium bg-yellow-400 text-dark">
                                                    {{ $task->created_at->locale('fr')->diffForHumans() }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="card-body">
                                            <div class="card-text flex mt-2">
                                                <div class="w-4/5 ml-4 mr-4">
                                                    <span class="break-words">
                                                        {{ $task->description }}
                                                    </span>
                                                    <br>
                                                    @if ($task->status === 'Todo')
                                                        <span class="inline-flex items-center px-2.5 py-0.5 mr-2 mb-2 rounded-full text-sm font-medium bg-blue-200 text-dark">
                                                            À faire
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2.5 py-0.5 mr-2 mb-2 rounded-full text-sm font-medium bg-green-400 text-dark">
                                                            Fait
                                                        </span>
                                                    @endif

                                                    @if ($task->updated_at)
                                                        <small>Dernière modification - {{ $task->updated_at->locale('fr')->diffForHumans() }} </small>
                                                    @endif
                                                </div>
                                                <div class="col-auto ml-auto">
                                                    <a href="{{ route('tache.edit', $task->id) }}" class="btn bg-green-600 btn-success" style="font-size: 9px;">
                                                        <i class="fa fa-edit">Modifier</i>
                                                    </a>

                                                    <form action="{{ route('taches.destroy', $task->id) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn bg-red-600" style="font-size: 9px;margin-right: 10px">
                                                        <i class="fa fa-trash">Supprimer</i>
                                                    </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                @empty
                                    <div class="grid place-items-center"> Aucune tâche disponible. </div>
                                @endforelse
                            </div>
                        </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>