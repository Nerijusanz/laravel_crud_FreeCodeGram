<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user(){
        return $this->belongsTo(User::class);   //one to one relatioship
    }

    public function followers(){
        return $this->belongsToMany(User::class);
    }
}
