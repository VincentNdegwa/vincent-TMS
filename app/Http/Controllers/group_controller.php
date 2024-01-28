<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class group_controller extends Controller
{
    function createNewGroup(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "group_name" => "required",
        ]);

        if (!$validation->fails()) {
            $group = Group::create([
                "group_name" => $request->input("group_name")
            ]);
            $latest_group_id = $group->id;
            if ($latest_group_id) {
                $user_group = UserGroup::create([
                    "user_id" => auth()->id(),
                    "group_id" => $latest_group_id,
                    "admin" => "true"
                ]);
                if ($user_group) {
                    return response()->json([
                        'error' => false,
                        "data" => $group,
                        "message" => "Group created"
                    ], 201);
                } else {
                    $group->delete();
                    return response()->json([
                        'error' => true,
                        'message' => 'Failed to add user to the group'
                    ], 400);
                }
            } else {
                return response()->json(['error' => true, 'message' => 'Failed to create new group'], 500);
            }
        } else {
            return response()->json([
                'error' => true,
                'validations' => $validation->errors(),
                "message" => "You have missing inputs"
            ], 400);
        }
    }
}
