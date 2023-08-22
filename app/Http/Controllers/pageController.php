<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class pageController extends Controller
{
    public function getPlayGround()
    {
        return Inertia::render('Playground', [
            // "allTasks" => Task::where('completed', 1)->get(),
            'allTasks' => Task::select('tasks.id', 'tasks.name', 'tasks.assigner', 'tasks.created_at', 'users.name as assigner_name', 'users.email')
                ->where('completed', 1)
                ->join('users', 'users.id', '=', 'tasks.assigner')
                ->get(),
        ]);
    }
}
