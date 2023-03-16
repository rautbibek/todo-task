<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request){
        $this->validate($request,[
            'title'=>'required',
        ]);


        $id = $request->id;
        if(isset($id)){
            Task::updateed([
                'title'=>$request->title,
                'priority'=>$request->priority,
                'description'=>$request->detail
            ]);
        }else{
            Task::create([
                'title'=>$request->title,
                'priority'=>$request->priority,
                'description'=>$request->description,
                'user_id'=>auth()->id(),
                'card_id'=>$request->card_id,
                'order'=>1
            ]);
        }
    }
}
