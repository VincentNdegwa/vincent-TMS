<?php

namespace App\Http\Controllers;

use App\Events\GroupNotification;
use App\Models\Group;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\UserGroup;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class taskController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth']);
    }

    public function getAllTask()
    {
        return Inertia::render("ViewTasks", [
            "tasks" => auth()->user()
                ->tasks()
                ->where('user_id', auth()->id())
                ->where('completed', 0)
                ->get(),
            "taskAssigning" => Task::where('assigner', auth()->id())
                ->orderBy("created_at", "ASC")
                ->get(),
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
            "tasks" => auth()->user()->tasks()->where('user_id', auth()->id())
                ->where('completed', 0)
                ->orderBy($key, "desc")->get(),
            "taskAssigning" => Task::where('assigner', auth()->id())->orderBy("created_at", "DESC")->get(),
        ]);
        // return response()->json($query);
    }


    public function addTask(Request $request)
    {

        try {
            $dueDateInput = $request->input('dueDate');
            $dueDate = Carbon::parse($dueDateInput);
            $addedAsssigning = null;
            if ($request->hasFile('taskFile')) {
                $file = $request->file('taskFile');
                $filename = $file->storeAs('taskFiles', $file->getClientOriginalName(), 'public');
                $addedAsssigning = Task::create([
                    "name" => $request->input('name'),
                    "unique_id" => $request->input('unique_id'),
                    "assigner" => auth()->id(),
                    "user_id" => $request->input('user_id'),
                    "priority" => $request->input('priority'),
                    "due_date" => $dueDate->timestamp,
                    'description' => $request->input("description"),
                    'taskFile' => $filename,
                ]);
            } else {
                $addedAsssigning = Task::create([
                    "name" => $request->input('name'),
                    "unique_id" => $request->input('unique_id'),
                    "assigner" => auth()->id(),
                    "user_id" => $request->input('user_id'),
                    "priority" => $request->input('priority'),
                    "due_date" => $dueDate->timestamp,
                    'description' => $request->input("description"),
                ]);
            }

            return response()->json([
                "error" => false,
                "task" => $addedAsssigning
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getUserTasks()
    {
        // event(new GroupNotification("hello"));
        $loggedInId = auth()->id();
        return Inertia::render('Dashboard', [
            'tasks' => Task::where('user_id', $loggedInId)->orderBy("created_at", "DESC")->get(),
            'assigningTasks' => Task::where('assigner', $loggedInId)->orderBy("created_at", "DESC")->limit(9)->get(),
            "assigner" => count(Task::where('assigner', $loggedInId)->get()),
            "groups" => UserGroup::where('user_id', auth()->id())
                ->join('groups', 'user_group.group_id', '=', 'groups.id')
                ->get()

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
            "addedAsssigning" => null
        ]);
    }

    public function updateTask(Request $request)
    {
        $taskid = $request->input('id');
        $task = Task::find($taskid);

        if ($request->hasFile('response_file')) {
            $file = $request->file('response_file');
            $filepath = $file->store('responseFiles', 'public');
            $update = [
                "completed" => 1,
                "task_reply" => $request->input("task_reply"),
                "date_submit" => $request->input("date_submit"),
                'response_file' => $filepath
            ];
            $task->update($update);
            // return Inertia::render('AddTask', [
            //     'tasks' => Task::where('user_id', auth()->id())->orderBy("created_at", "DESC")->get(),
            // ]);
            return Redirect::route('viewTasks');
        } else {
            $update = [
                "completed" => 1,
                "task_reply" => $request->input("task_reply"),
                "date_submit" => $request->input("date_submit"),
            ];
            $task->update($update);
            // return Inertia::render('ViewTasks', [
            //     'tasks' => Task::where('user_id', auth()->id())->orderBy("created_at", "DESC")->get(),
            // ]);
            return Redirect::route('viewTasks');
        }
    }

    function assignTaskGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_id' => 'required',
            'user_id' => 'required',
            'dueDate' => 'required|date',
            'name' => 'required',
            'unique_id' => 'required',
            'priority' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()]);
        }

        try {
            $dueDate = Carbon::parse($request->input('dueDate'));
            $users = UserGroup::where('group_id', $request->input('group_id'))
            ->where('user_id', '!=', $request->input('user_id'))
            ->select('user_id')
            ->get();

            $tasks = [];

            foreach ($users as $user) {
                $taskData = [
                    'name' => $request->input('name'),
                    'unique_id' => $request->input('unique_id'),
                    'assigner' => auth()->id(),
                    'user_id' => $user->user_id,
                    'priority' => $request->input('priority'),
                    'due_date' => $dueDate->timestamp,
                    'description' => $request->input('description'),
                ];

                if ($request->hasFile('taskFile')) {
                    $file = $request->file('taskFile');
                    $filename = $file->storeAs('taskFiles', $file->getClientOriginalName(), 'public');
                    $taskData['taskFile'] = $filename;
                }

                $addedAssigning = Task::create($taskData);
                $tasks[] = $addedAssigning;
            }

            return response()->json(['error' => false, 'message' => 'Tasks assigned successfully', 'tasks' => $tasks]);
        } catch (\Throwable $th) {
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }
}
