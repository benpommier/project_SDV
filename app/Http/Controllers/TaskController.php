<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function taches()
    {
        $user = Auth::user();

        if (!Gate::allows('task-access')) {
            abort('403');
        }

        // On récupère les tâches de l'annonce à laquelle l'utilisateur est connecté
        $tasks = Task::join('annonce_user', 'tasks.annonce_id', '=', 'annonce_user.annonce_id')
                ->select('tasks.*')
                ->where('annonce_user.user_id', $user->id)
                ->orderBy('tasks.id', 'desc')
                ->paginate(30);
        
        return view('task/taches', ['tasks' => $tasks]);
    }

    public function creation()
    {
        if (!Gate::allows('task-access')) {
            abort('403');
        }
       $statuses = [
            [
                'label' => 'Todo',
                'value' => 'Todo',
            ],
            [
                'label' => 'Done',
                'value' => 'Done',
            ]
        ];
        return view('task/tache-creation', compact('statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);
        if (!Gate::allows('task-access')) {
            abort('403');
        }

        $user = auth()->user();
        $annonce_id = $user->annonces->first()->id;

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->annonce_id = $annonce_id;
        $task->save();
        return redirect()->route('taches');
    }

    public function show($id)
    {
        //
    }
 
    public function edit(Request $request)
    {
        $id = $request->server('QUERY_STRING');
        $task = Task::findOrFail($id);
        if (!Gate::allows('task-access')) {
            abort('403');
        }
        $statuses = [
            [
                'label' => 'Todo',
                'value' => 'Todo',
            ],
            [
                'label' => 'Done',
                'value' => 'Done',
            ]
        ];
        return view('task/tache-edit', compact('statuses', 'task'));
    }

    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        if (!Gate::allows('task-access')) {
            abort('403');
        }
        $request->validate([
            'title' => 'required'
        ]);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->status = $request->status;
        $task->save();
        return redirect()->route('taches');
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('taches');
    }
}
