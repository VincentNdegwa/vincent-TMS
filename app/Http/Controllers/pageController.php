<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class pageController extends Controller
{
    public function getPlayGround()
    {

        return Inertia::render(
            'Playground',
            [
                'allTasks' => Task::select(
                    'tasks.id',
                    'tasks.name',
                    'tasks.assigner',
                    'tasks.user_id as assignee',
                    'tasks.created_at',
                    'users.name as assigner_name',
                    'users.email',
                    'tasks.likes',
                    'tasks.taskFile',
                    'tasks.response_file'
                )
                    ->where('completed', 1)
                    ->join('users', 'users.id', '=', 'tasks.assigner')
                    ->join('users as user', 'user.id', '=', 'tasks.user_id')
                    ->with([
                        "taskComments" => function ($query) {
                            $query->with("Sender");
                        }
                    ])
                    ->get(),
                'auth' => auth()->id()
            ]

        );
    }
}
