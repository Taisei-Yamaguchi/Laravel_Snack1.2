@extends('layouts.snackapp')

@section('title','MyPage')

@section('content')
        <ul><a href="login">to Login screen...</a></ul>
        @if($member['id']==1)
        <ul><a href="../administrator/index">管理者ログイン画面</a></ul>
        @else
        <a href="member_delete"　 class="deletion">Account Deletion</a>&nbsp;
        <a href="member_edit" class="edit">Account Edit</a>&nbsp;
        <a href="member_pass_change" class="edit">password change</a>&nbsp;
        @endif
<div class='member_infomation'>
        @if(isset($member))
        <img class="member_image" src="../storage/member_images/{{$member['image']}}" width="70" height="85" alt="" align='left'>
        <p>Name: {{$member['name']}} </p>
        <p>Mail: {{$member['mail']}} </p>
        @endif
</div>
<ul><a href="recomend_add">&raquo Recommend ←please recommend your favorite snacks!</a></ul>
        
    <div class="suggest_items">
        @if(count($suggest_items)>0)
        <p>This application suggest these snacks!</p>
            @foreach($suggest_items as $item)
            <table>
            <tr><th> 
            @if(!isset($like_check[$item->id]))
            <a class="before_nice" href="like?snack_id={{$item->id}}">☆</a>
            @else
            <a class="after_nice" href="like?snack_id={{$item->id}}">★</a>
            @endif
            </th><td>
            count of likes {{$item->likes_cnt}}
            </td></tr>
            <tr><th>Name:</th><td><a href="{{$item->url}}" style="text-decoration:none;">{{$item->name}}</a></td></tr>
            <tr><th>Company:</th><td>{{$item->company}}</td></tr>
            <tr><th>Recommender:</th><td><a href='recomender_search?recomend=member_id,{{$item->member_id}}' style="text-decoration:none;">{{$item->member->name}}</a></td>
            <tr><th>Image</th><td><img src="../storage/snack_images/{{$item->image}}" width="70" height="85" alt=""></td></tr>
            </table>
            @endforeach
        @endif
    </div>
        

     
        
        <form action="search" method=post>
            {{csrf_field()}}
            <select name="snack_type">
                <option value="" selected>Choose type!</option>
                <option value="グミ">グミ gummi</option><!-- comment -->
                <option value="アメ">アメ candy</option><!-- comment -->
                <option value="ラムネ">ラムネ ramune</option><!-- comment -->
                <option value="チョコレート">チョコレート chocolate</option><!-- comment -->
                <option value="クッキー">クッキー cookie</option>
                <option value="ガム">ガム chewing gum</option>
                <option value="ビスケット">ビスケット bisketto</option><!-- comment -->
                <option value="ソフトキャンディー">ソフトキャンディー soft candy</option>
                <option value="アイス">アイス ice cream</option><!-- comment -->
                <option Value="スナック菓子">スナック菓子 snack food </option><!-- comment -->
                <option value="せんべい">せんべい rice cookie</option>
                <option value="その他">その他 other</option>    
            </select>
            <select name="country">
                <option value="" selected>Choose Country!</option>
                <option value="日本">日本 Japan</option><!-- comment -->
                <option value="Canada">Canada</option><!-- comment -->
                <option value="その他">その他 other</option>    
            </select>
            <select name="order">
                <option value="" selected>Choose the order of search!</option>
                <option value="likes_cnt,desc">priority of  popularity</option>
                <option value="likes_cnt,asc">rarity</option>
                <option value="name,asc">name</option>
                <option value="country,asc">country</option>
                <option value="company,asc">company</option>
                <option value="created_at,desc">recent</option>
                <option value="created_at,asc">old</option>
            </select>
            <br>
            <input type="text" name="keyword" placeholder="検索">
            <input type="submit" value="search" class="search">
        </form>
        <div class="form_conf">
            <form action="like_search" method="post">
            {{csrf_field()}}
                <input type="submit" value="★" class="my_like_button" align="left">
            </form>
            <form action="recomend_search" method="post" >
            {{csrf_field()}}
                <input type="hidden" name="recomend" value="member_id,{{$member['id']}}">
                <input type="submit" value="R" class="recomended_button">
            </form>
        </div>
        <hr>

        @if(isset($recomender_info))
            <img class="member_image" src="../storage/member_images/{{$recomender_info['image']}}" width="70" height="85" alt="" align='left'>
            <p>{{$recomender_info['name']}} recommends those snacks!</p>
            <br>
            <br>
        @endif    

        @if(isset($items))
            @foreach($items as $item)
            <table>
            <tr><th> 
            @if(!isset($like_check[$item->id]))
            <a class="before_nice" href="like?snack_id={{$item->id}}" class="before_nice">☆</a>
            @else
            <a class="after_nice" href="like?snack_id={{$item->id}}" class="after_nice">★</a>
            @endif
        </th><td>
            count of likes {{$item->likes_cnt}}
        </td></tr>
            <tr><th>Name:</th><td><a href="{{$item->url}}" style="text-decoration:none;">{{$item->name}}</a>
            @if($item->member_id==$member['id'])
            <a href="delete?snack_id={{$item->id}}" class='deletion'>delete</a>
            <a href="snack_edit?snack_id={{$item->id}}" class='edit'>edit</a>
            @endif
            </td></tr>
            
            <tr><th>Company:</th><td>{{$item->company}}</td></tr>
            <tr><th>Comment:</th><td>{{$item->coment}}</td></tr>
            <tr><th>Recommender:</th><td><a href='recomender_search?recomend=member_id,{{$item->member_id}}' style="text-decoration:none;">{{$item->member->name}}</a></td>
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