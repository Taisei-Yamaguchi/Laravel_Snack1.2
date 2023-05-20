<?php

namespace App\Http\Controllers;

use App\Function\SnackSearch;
use App\Function\LikeFunction;
use App\Function\MemberSearch;
use App\Function\LoginFunction;
use App\Models\Snack;
use App\Models\Member;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Snack1Controller extends Controller
{


    

//to Login Screen
    public function login_index(Request $request){
        $request->session()->forget('id');
        $request->session()->forget('name');
        $request->session()->forget('mail');
        $request->session()->forget('image');
        $request->session()->forget('keyword');
        $request->session()->forget('snack_type');
        $request->session()->forget('country');
        $request->session()->forget('order');
        $request->session()->forget('form');
        return view('snack1.index');
    }





//login processing & to Mypage
    public function login(Request $request){
        $mail=$request->mail;
        $pass=$request->pass;
        //mailとpassを渡して、ログインできるメンバーを取得
        $member=LoginFunction::login($mail,$pass);
        //ここにifを入れて、一致するメンバーがいたらマイページへ。いなければエラーメッセージ。
        if(isset($member)){
            $request->session()->put('id',$member->id);
            $request->session()->put('name',$member->name);
            $request->session()->put('image',$member->image);
            $request->session()->put('mail',$member->mail);
            
            $suggest_items=array();
            $ses=$request->session()->all(); 
           
            //$suggest_items=array();
        //2023.3.7 ここミドルウェアに移す？？
            return view('snack1.mypage',[
                'member'=>$ses,
                'suggest_items'=>$suggest_items,
            ]);
        }else{
            return view('snack1.index',['mess'=>'ログイン失敗']);
        }
    }





//to Mypage(for GET). But session_id which is added when logined is necessary.
    public function mypage_index(Request $request)
    {
        $request->session()->forget('keyword');
        $request->session()->forget('snack_type');
        $request->session()->forget('country');
        $request->session()->forget('order');
        $ses=$request->session()->all();
        //↓ミドルウェアから取得
        $suggest_items=$request->suggest_items;

        return view('snack1.mypage',[
            'member'=>$ses,
            'suggest_items'=>$suggest_items,
        ]);
    }





//to Administrator Login page. But session_id has to be '1'.
    public function administrator_index(Request $request)
    {
        $request->session()->forget('keyword');
        $request->session()->forget('snack_type');
        $request->session()->forget('country');
        $request->session()->forget('order');
        $ses_id=$request->session()->get('id');
        return view('snack1.administrator_index',[
            'member_id'=>$ses_id,
        ]);
    }





//administrator login & to snacks administration page.
    public function administrator_1(Request $request)
    {
        $name=$request->name;
        $love_girl=$request->love_girl;
        $neko=$request->neko;

        if(($name=="山口泰生")&&($neko="わらび"))
        {
            $ses_id=$request->session()->get('id');

            return view('snack1.administrator_1',[
            'member_id'=>$ses_id,
            ]);
        }else{
            $error="情報が違います。";

            return view('snack1.administrator_index',[
                'error'=>$error,
            ]);
        }
    }

    



//to snacks administration page　(for GET)
    public function administrator_1_1(Request $request)
    {
        $request->session()->forget('keyword');
        $request->session()->forget('snack_type');
        $request->session()->forget('country');
        $request->session()->forget('order');
        $ses_id=$request->session()->get('id');
        return view('snack1.administrator_1',[
            'member_id'=>$ses_id,
        ]);
    }





//search snacks for administration
    public function administrator_snack(Request $request)
    {
        $ses_id=$request->session()->get('id');
        $keyword=$request->keyword;
        $snack_type=$request->snack_type;
        $country=$request->country;
        $order=$request->order;

        $request->session()->put('keyword',$keyword);
        $request->session()->put('snack_type',$snack_type);
        $request->session()->put('country',$country);
        $request->session()->put('order',$order);
        //AND OR検索　を考える???
        //2023.3.9 検索機能は共通関数に
        $items=SnackSearch::administrator_snack_search($keyword,$snack_type,$country,$order);
        return view('snack1.administrator_1',[
            'member_id'=>$ses_id,
            'items'=>$items,
        ]);
    }




//search snacks for administration (for GET)
public function get_administrator_snack(Request $request)
{
    $ses_id=$request->session()->get('id');
    $keyword=$request->session()->get('keyword');
    $snack_type=$request->session()->get('snack_type');
    $country=$request->session()->get('country');
    $order=$request->session()->get('order');
    //AND OR検索　を考える???
    //2023.3.9 検索機能は共通関数に
    $items=SnackSearch::administrator_snack_search($keyword,$snack_type,$country,$order);
    return view('snack1.administrator_1',[
        'member_id'=>$ses_id,
        'items'=>$items,
    ]);
}




//limit snacks
    public function snack_limit(Request $request)
    {
        $ses_id=$request->session()->get('id');
        $id=$request->snack_id;
        $param=[
            'deletion'=>1,
        ];

        $item=Snack::where('id',$id)->update($param);
        return view('snack1.administrator_1',[
            'member_id'=>$ses_id,
        ]);
    }




//unlimit snacks
    public function snack_unlimit(Request $request)
    {
        $ses_id=$request->session()->get('id');
        $id=$request->snack_id;
        $param=[
            'deletion'=>0,
        ];

        $item=Snack::where('id',$id)->update($param);
        return view('snack1.administrator_1',[
            'member_id'=>$ses_id,
        ]);
    }




//to member administration page
    public function administrator_2(Request $request)
    {
        $request->session()->forget('keyword');
        $request->session()->forget('snack_type');
        $request->session()->forget('country');
        $request->session()->forget('order');
        $ses_id=$request->session()->get('id');

        return view('snack1.administrator_2',[
            'member_id'=>$ses_id,
        ]);
    }



//search members for administration
    public function administrator_member(Request $request)
    {
        $ses_id=$request->session()->get('id');
        $keyword=$request->keyword;
        $order=$request->order;

        $request->session()->put('keyword',$keyword);
        $request->session()->put('order',$order);
        $members=MemberSearch::member_search($keyword,$order);
        return view('snack1.administrator_2',[
            'member_id'=>$ses_id,
            'members'=>$members,
        ]);
    }




//search members for administration(for Get)
    public function get_administrator_member(Request $request)
    {
        $ses_id=$request->session()->get('id');
        $keyword=$request->session()->get('keyword');
        $order=$request->session()->get('order');

        $request->session()->put('keyword',$keyword);
        $request->session()->put('order',$order);
        $members=MemberSearch::member_search($keyword,$order);
        return view('snack1.administrator_2',[
            'member_id'=>$ses_id,
            'members'=>$members,
        ]);
    }




//limit members
    public function member_limit(Request $request)
    {
        $ses_id=$request->session()->get('id');
        $id=$request->id;
        $param=[
            'deletion'=>1,
        ];

        $item=Member::where('id',$id)->update($param);
        return view('snack1.administrator_2',[
            'member_id'=>$ses_id,
        ]);
    }




//unlimit members
    public function member_unlimit(Request $request)
    {
        $ses_id=$request->session()->get('id');
        $id=$request->id;
        $param=[
            'deletion'=>0,
        ];

        $item=Member::where('id',$id)->update($param);
        return view('snack1.administrator_2',[
            'member_id'=>$ses_id,
        ]);
    }
}
