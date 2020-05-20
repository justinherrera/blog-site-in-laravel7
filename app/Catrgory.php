<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catrgory extends Model
{
    public function posts()
    {
        return $this->hasMany('App\Post', 'cat_id');
    }
}
