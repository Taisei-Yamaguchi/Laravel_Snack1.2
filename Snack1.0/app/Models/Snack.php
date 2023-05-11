<?php

namespace App\Models;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Snack extends Model
{
    protected $guarded=array('id');

    public static $rules=array(
        'name'=>'required|max:255',
        'company'=>'required|max:255',
        'member_id'=>'required',
        'image'=>'',
        'url'=>'nullable|url',
        'type'=>'required',
        'coment'=>'nullable|max:50',
        'keyword'=>'nullable|max:50',
        'country'=>'required',
        'deletion'=>'',
    );

    public function member(){
        return $this->belongsTo('App\Models\Member');
    }

    public function like(){
        return $this->hasOne('App\Models\Like');
    }

    public function getData(){
        return $this->id.':'.$this->name.'('
        .$this->member->name.')';
    }


}
