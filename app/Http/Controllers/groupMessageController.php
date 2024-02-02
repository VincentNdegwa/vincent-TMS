<?php

namespace App\Http\Controllers;

use App\Events\GroupNotification;
use App\Models\groupMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class groupMessageController extends Controller
{
    function addMessage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => "required",
            'user_id' => "required",
            "group_id" => "required",
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => true, 'message' => $validator->errors()->first()], 400);
        }

        $message = groupMessage::create([
            'message' => $request->input("message"),
            'user_id' => $request->input("user_id"),
            "group_id" => $request->input("group_id"),
        ]);
        if (!$message) {
            return response()->json(['error' => true, 'message' => "Message failed"], 400);
        }
        event(new GroupNotification(json_encode($message)));
        return response()->json(['error' => false, 'message' => "Message failed", "data" => $message]);
    }
}
