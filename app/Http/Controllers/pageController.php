<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
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
        $userData = User::where("id", auth()->id())
            ->with("user_verification")
            ->first();

        return Inertia::render("Profile", [
            "userData" => $userData,
            "userName" => $userData->name,
        ]);
    }
    function updateProfile(Request $request)
    {
        try {
            // $validator = Validator::make($request->all(), [
            //     "name" => "required",
            //     "full_names" => "required",
            //     "userId" => "required",
            // ]);
            // if ($validator->fails()) {
            //     return response()->json([
            //         "error" => true,
            //         "meesage" => $validator->errors()->first(),
            //     ]);
            // }
            $filePath = "";
            $newData = [
                "name" => $request->input("username"),
                "full_names" => $request->input("fullName"),
            ];
            if ($request->input("newPassword")) {
                $newPass = Hash::make($request->input("newPassword"));
                $newData["password"] = $newPass;
            }
            if ($request->file("updateprofile")) {
                $file = $request->file("updateprofile");
                $filePath = $file->store("profilePics", "public");
                $newData["profile_path"] = $filePath;
            }
            $user = User::where("id", $request->input("userId"))->update($newData);
            if ($user) {
                Storage::disk("public")->delete($filePath);
                return response()->json([
                    "data" => User::where("id", auth()->id())->with("user_verification")->first(),
                    "error" => false,
                    "message" => "Profile Updated"
                ]);
            } else {
                Storage::disk("public")->delete($filePath);

                return response()->json([
                    "error" => true,
                    "message" => "Failed to update. Please try again later."
                ]);
            }
        } catch (\Throwable $th) {
            if (!empty($filePath)) {
                Storage::disk("public")->delete($filePath);
            }
            return response()->json([
                "error" => true,
                "message" => $th->getMessage()
            ]);
        }
    }
}
