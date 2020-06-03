<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title','body','user_id','image','cat_id'];
    
    public function user(){
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Catrgory', 'cat_id');
    }

    public function likes(){
        return $this->belongsTo('App\Like');
    }
    
    public function dislikes(){
        return $this->belongsTo('App\Dislike');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
