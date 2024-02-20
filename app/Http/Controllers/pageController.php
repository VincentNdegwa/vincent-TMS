<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Task;
use App\Models\User;
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
                    'user.name as assignee_name',
                    'tasks.likes',
                    // 'tasks.taskFile',
                    // 'tasks.response_file',
                    'tasks.updated_at'
                )
                    ->where('completed', 1)
                    ->join('users', 'users.id', '=', 'tasks.assigner')
                    ->join('users as user', 'user.id', '=', 'tasks.user_id')
                    // ->with([
                    //     "taskComments" => function ($query) {
                    //         $query->with("Sender");
                    //     }
                    // ])
                    // ->with("user")
                    // ->with("assigner")
                    ->get(),
                'auth' => auth()->id()
            ]

        );
    }

    function getComments(Request $request, $id)
    {
        if ($id) {
            $userId = auth()->id();
            return Inertia::render("PlaygroundTask", [
                'allTasks' => Task::where("tasks.id", $id)
                    ->select(
                        'tasks.id',
                        'tasks.name',
                        'tasks.description',
                        'tasks.assigner',
                        'tasks.user_id as assignee',
                        'tasks.created_at',
                        'users.name as assigner_name',
                        'users.email',
                        'user.name as assignee_name',
                        'tasks.likes',
                        'tasks.taskFile',
                        'tasks.response_file',
                        'tasks.updated_at'
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
                'auth' => $userId,
                "user" => User::where("id", $userId)->first()
            ]);
        }
    }

    function getProfile()
    {
        return Inertia::render("Profile", []);
    }
}
