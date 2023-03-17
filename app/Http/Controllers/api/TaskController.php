<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function store(Request $request){
        $this->validate($request,[
            'title'=>'required',
        ]);
        $id = $request->id;
        if(isset($id)){
            Task::where('id',$id)->update([
                'title'=>$request->title,
                'priority'=>$request->priority,
                'description'=>$request->description
            ]);
        }else{
            $card_position = Task::where('card_id',$request->card_id)->orderBy('order','asc')->first();
            $order = 1;
            if($card_position){
                $order = $card_position->order-1;
            }

            Task::create([
                'title'=>$request->title,
                'priority'=>$request->priority,
                'description'=>$request->description,
                'user_id'=>auth()->id(),
                'card_id'=>$request->card_id,
                'order'=>$order
            ]);
        }
    }

    public function updateOrderOnMove(Request $request){
        //return $request->all();
        $card_id= $request->id;
        $tasks= $request->tasks;
        $task_data=[];
        $i=1;
        foreach($tasks as $task){
            DB::table('tasks')->where('id',$task['id'])->update([
                'card_id'=>$card_id,
                'order'=>$i++
            ]);
        }
        //dd($task_data);

        //return Task::where('card_id',$card_id)->get();
    }


}
