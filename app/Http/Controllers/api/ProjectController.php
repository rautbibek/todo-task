<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function myProjects(){
        $projects = Project::where('user_id',Auth::id())->latest()->get();
        return response()->json([
            'projects'=>$projects
        ]);
    }

    public function store(ProjectRequest $request){
        $id= $request->id;
        $message = "";
        if(isset($id)){
            Project::updated([
                'name'=> $request->name,
                'visibility'=>$request->visibility
            ]);
            $message="Project updated successfully.";
        }else{
            Project::create([
                'user_id'=>auth()->id(),
                'name'=> $request->name,
                'visibility'=>$request->visibility
            ]);
            $message="New project created successfully.";
        }
        return response()->json([
            'message'=>$message
        ],200);
    }
}
