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
        //like処理ミドルウェアで行った後にここに来る。
        //$ses=$request->session()->all();
        //$suggest_items=$request->suggest_items;
        //redirectすればこれらも必要ない
        /*return view('snack1.mypage',[
            'member'=>$ses,
            'suggest_items'=>$suggest_items,
        ]);*/

        return back()->withInput();
    }
}
