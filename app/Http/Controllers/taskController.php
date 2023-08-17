<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class taskController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth']);
    }

    public function getAllTask()
    {
        return Inertia::render("ViewTasks", [
            "tasks" => auth()->user()->tasks()->where('user_id', auth()->id())->get(),
            "taskAssigning" => Task::where('assigner', auth()->id())->orderBy("created_at", "ASC")->get(),
        ]);
    }


    public function getUnique($id)
    {
        $task = Task::find($id);
        return response()->json($task);
    }

    public function sortTask(Request $request)
    {
        $query = $request->query('sort');
        $key = 'id';
        if ($query == 'dueDate') {
            $key = 'due_date';
        } elseif ($query == "all") {
            $key = "id";
        } elseif ($query == "name") {
            $key = "name";
        } elseif ($query == "latest") {
            $key = "created_at";
        } elseif ($query == "priority") {
            $key = "priority";
        }

        return Inertia::render("ViewTasks", [
            "tasks" => auth()->user()->tasks()->where('user_id', auth()->id())->orderBy($key, "desc")->get(),
            "taskAssigning" => Task::where('assigner', auth()->id())->orderBy("created_at", "DESC")->get(),
        ]);
        // return response()->json($query);
    }


    public function addTask(Request $request)
    {
        if ($request->hasFile('taskFile')) {
            $file = $request->file('taskFile');
            $path = $file->store('taskFiles', 'public');
            Task::create([
                "name" => $request->input('name'),
                "unique_id" => $request->input('unique_id'),
                "assigner" => auth()->id(),
                "user_id" => $request->input('user_id'),
                "priority" => $request->input('priority'),
                "due_date" => Carbon::parse($request->input('due_date'))->timestamp,
                'description' => $request->input("description"),
                'taskFile'=> $path,
            ]);
        }else{
            Task::create([
                "name" => $request->input('name'),
                "unique_id" => $request->input('unique_id'),
                "assigner" => auth()->id(),
                "user_id" => $request->input('user_id'),
                "priority" => $request->input('priority'),
                "due_date" => Carbon::parse($request->input('due_date'))->timestamp,
                'description' => $request->input("description"),
            ]); 
        }

        return Inertia::render('AddTask');
    }

    public function getUserTasks()
    {
        $loggedInId = auth()->id();
        return Inertia::render('Dashboard', [
            'tasks' => Task::where('user_id', $loggedInId)->orderBy("created_at", "DESC")->get(),
            'assigningTasks' => Task::where('assigner', $loggedInId)->orderBy("created_at", "DESC")->limit(9)->get(),
            "assigner" => count(Task::where('assigner', $loggedInId)->get()),
        ]);
    }

    public function storeUserTask()
    {
        $this->middleware(["auth"]);
        $loggedInId = auth()->id();
        return Inertia::render('AddTask', [
            'tasks' => Task::where('user_id', $loggedInId)->orderBy("created_at", "DESC")->get(),
            'assigningTasks' => Task::where('assigner', $loggedInId)->orderBy("created_at", "DESC")->limit(9)->get(),
            "users" => User::where("id", "!=", auth()->id())->get(),
        ]);
    }

    public function updateTask(Request $request)
    {
        $taskid = $request->input('id');
        $task = Task::find($taskid);
        $update = [
            "completed" => 1,
            "task_reply" => $request->input("task_reply"),
            "date_submit" => $request->input("date_submit"),
        ];
        $task->update($update);
        return Inertia::render('AddTask', [
            'tasks' => Task::where('user_id', auth()->id())->orderBy("created_at", "DESC")->get(),
        ]);
    }
}
