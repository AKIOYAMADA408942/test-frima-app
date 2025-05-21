<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'name',
        'condition',
        'brand',
        'content',
        'price',
        'img_path',
    ];


    public function categories(){
        return $this->belongsToMany('App\Models\Category')-> withTimestamps();
    }

    public function purchase(){
        return $this->hasOne('App\Models\Purchase');
    }

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }

    public function likes(){
        return $this->hasMany('App\Models\Like');
    }
}
