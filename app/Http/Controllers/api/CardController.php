<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use App\Models\Project;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function getCard($project_id){
        $project = Project::findOrFail($project_id);
        $card = Card::with(['tasks'=>function($query){
            $query->orderBy('order','asc');
        }])->where('project_id',$project_id)->get();
        return response()->json([
            'cards'=>$card,
            'project'=>$project,
        ]);
    }
    public function store(Request $request){
        //return $request->all();
        $this->validate($request,[
            'title'=>'required|max:100'
        ]);
        $card = Card::orderBy('id','desc')->first();
        $order = 1;
        if($card){
            $order =$card->order+1;
        }
        $id = $request->id;
        if(isset($id)){
            Card::updated([
                'title'=>$request->title,
                'order'=>$order
            ]);
        }else{
            Card::create([
                'user_id'=>auth()->id(),
                'project_id'=>$request->project_id,
                'title'=>$request->title,
                'order'=>$order

            ]);
        }
        return response()->json([
            'message'=>'card updated successfully'
        ]);
    }
}
