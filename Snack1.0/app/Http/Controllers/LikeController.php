<?php

namespace App\Http\Controllers;

use App\Function\LikeFunction;
use App\Models\Like;
use App\Models\Snack;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index(Request $request){
        $items=Like::all();
        return view('like.index',['items'=>$items]);
    }



//add or delete 'like'
    public function like_add_delete (Request $request){
        //まずクエリを取得する
        //Middlewareを後処理にしないと、イイネ処理後にsuggestitemsを取得できないか？
        $snack_id=$request->snack_id;
        $ses=$request->session()->all();
        $suggest_items=$request->suggest_items;
        //using 'LikeFunction'
        //2023.3.9 共通関数にした
        LikeFunction::like_add_delete($ses['id'],$snack_id);
        return view('snack1.mypage',[
            'member'=>$ses,
            'suggest_items'=>$suggest_items,
        ]);
    }
}
