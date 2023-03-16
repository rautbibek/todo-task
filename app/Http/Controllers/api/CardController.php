<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    public function store(Request $request){
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
                'name'=>$request->title,
                'order'=>$order
            ]);
        }else{
            Card::create([
                'name'=>$request->title,
                'order'=>$order

            ]);
        }
    }
}
