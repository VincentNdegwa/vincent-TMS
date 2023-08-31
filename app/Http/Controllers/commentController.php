<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;
use Inertia\Inertia;

class commentController extends Controller
{
    public function create(Request $request)
    {
        $createdComment = Comments::create([
            'text' => $request->input('text'),
            'task_id' => $request->input('task_id'),
            'sender_id' => $request->input('sender'),
            'receiver_id' => $request->input('receiver'),
        ]);
        return Inertia::render('Playground', [
            'created' => $createdComment
        ]);
    }


    public function retrieve()
    {
        $conversation = Comments::all();
        dd($conversation);
    }
}
