@extends('layouts.snackapp')

@section('title','Administrator')

@section('content')
        <ul><a href="../mypage/login">ログイン画面へ</a></ul>
        @if($member_id==1)
        <ul><a href="../administrator/index">管理者ログイン画面</a></ul>
        @endif
        <ul><a href="home2">メンバー管理画面へ</a></ul>

    
        <p>投稿されたお菓子の管理</p>
        <form action="snack" method=post>
            {{csrf_field()}}
            <select name="snack_type">
                <option value="" selected>種類を選んでね♡</option>
                <option value="グミ">グミ</option><!-- comment -->
                <option value="アメ">アメ</option><!-- comment -->
                <option value="ラムネ">ラムネ</option><!-- comment -->
                <option value="チョコレート">チョコレート</option><!-- comment -->
                <option value="クッキー">クッキー</option>
                <option value="ガム">ガム</option>
                <option value="ビスケット">ビスケット</option><!-- comment -->
                <option value="ソフトキャンディー">ソフトキャンディー</option>
                <option value="アイス">アイス</option><!-- comment -->
                <option Value="スナック菓子">スナック菓子</option><!-- comment -->
                <option value="せんべい">せんべい</option>
                <option value="その他">その他</option>    
            </select>
            <select name="country">
                <option value="" selected>国を選んでね♡</option>
                <option value="日本">日本</option><!-- comment -->
                <option value="Canada">Canada</option><!-- comment -->
                <option value="その他">その他</option>    
            </select>
            <select name="order">
                <option value="" selected>順番指定してね♡</option>
                <option value="likes_cnt,desc">人気順</option>
                <option value="likes_cnt,asc">珍しい順</option>
                <option value="name,asc">名前順</option>
                <option value="country,asc">国順</option>
                <option value="company,asc">企業順</option>
                <option value="created_at,desc">新しい順</option>
                <option value="created_at,asc">古い順</option>
            </select>
            <br>
            <input type="text" name="keyword" placeholder="検索">
            <input type="submit" value="search" class="search">
        </form>
        
        <hr>

        @if(isset($items))
            @foreach($items as $item)
            <table>
            <tr><th>ID: </th><td>{{$item->id}}
            @if($item->deletion==0)
            <form action="snack_limit" method="post">
                {{csrf_field()}}
                <input type="hidden" name="snack_id" value="{{$item->id}}">
                <input class="limit" type="submit" value="非表示にする">
            </form>
            @else
            <form action="snack_unlimit" method="post">
                {{csrf_field()}}
                <input type="hidden" name="snack_id" value="{{$item->id}}">
                <input class="unlimit" type="submit" value="表示にする">
            </form>
            @endif   
                
            </td>
            <tr><th>Count of likes:</th><td>★{{$item->likes_cnt}}</td>
            <tr><th>Name:</th><td><a href="{{$item->url}}">{{$item->name}}</a>
            </td></tr>
            <tr><th>Company:</th><td>{{$item->company}}</td></tr>
            <tr><th>Coment:</th><td>{{$item->coment}}</td></tr>
            <tr><th>Recomender:</th><td><a href="snack_recomend?recomend=member_id,{{$item->member_id}}">{{$item->member->name}}</a></td>
            <tr><th>Image</th><td><img src="../storage/snack_images/{{$item->image}}" width="70" height="85" alt=""></td></tr>
            </table>
            <br>
            @endforeach

            {{$items->links()}}
        @endif
@endsection

@section('footer')
copyright 2023 yamaguchi.
@endsection