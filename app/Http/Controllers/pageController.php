<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class pageController extends Controller
{
    public function getPlayGround(){
        return Inertia::render('Playground',[
            "allTasks"=>Task::all(),
            'userTask'=>Task::where("user_id", auth()->id())->get(),
        ]);
    }
}
