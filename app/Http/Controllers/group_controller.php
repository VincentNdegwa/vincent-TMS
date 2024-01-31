<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class group_controller extends Controller
{
    function createNewGroup(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "group_name" => "required",
            "group_description" => "required",
            "group_icon" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        if ($validation->fails()) {
            return response()->json([
                'error' => true,
                'validations' => $validation->errors(),
                "message" => "Validation failed. Please check your inputs."
            ], 400);
        }

        try {
            $groupIconPath = $request->file('group_icon')->store('group_icons', 'public');


            $group = Group::create([
                "group_name" => $request->input("group_name"),
                "group_description" => $request->input("group_description"),
                "group_icon" => "storage/" . $groupIconPath
            ]);

            $latestGroupId = $group->id;

            if (!$latestGroupId) {
                throw new \Exception("Failed to create new group");
            }


            $userGroup = UserGroup::create([
                "user_id" => auth()->id(),
                "group_id" => $latestGroupId,
                "admin" => true
            ]);

            if (!$userGroup) {
                $group->delete();
                Storage::delete($groupIconPath);

                throw new \Exception("Failed to add user to the group");
            }

            return response()->json([
                'error' => false,
                "data" => $group,
                "message" => "Group created successfully."
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    function viewGroup($id)
    {
        $group = Group::where("groups.id", $id)
            ->with(["user_group" => function ($query) {
                $query->with("users");
            }])
            ->first();


        if ($group) {
            $userName = User::where("id", auth()->id())->value("name");

            return Inertia::render("ViewGroup", [
                "viewData" => [
                    "error" => false,
                    "group_data" => $group,
                    "user_id" => auth()->id(),
                    "message" => "Group data retrieved"
                ],
                "userName" => $userName,
            ]);
        }
    }


    function editGroup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'group_name' => 'required',
            'group_description' => 'required',
            'new_group_icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'group_icon' => 'nullable|string',
            'existing_icon' => 'nullable|string',
            'id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 400);
        }

        $group = Group::find($request->id);

        if (!$group) {
            return response()->json(['error' => true, 'message' => 'Group not found'], 404);
        }

        $group->group_name = $request->group_name;
        $group->group_description = $request->group_description;

        if ($request->new_group_icon) {
            if ($request->existing_icon) {
                Storage::delete($request->existing_icon);
            }

            $path = $request->file("new_group_icon")->store("group_icons", "public");
            $group->group_icon = "storage/" . $path;
        } elseif ($request->group_icon === "null") {
            Storage::delete($request->existing_icon);
            $group->group_icon = "null_image";
        }

        // Save the changes
        $group->save();

        return response()->json(['error' => false, 'message' => 'Group updated successfully', 'data' => $group], 200);
    }
}
