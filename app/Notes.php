<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Notes extends Model
{
    protected $fillable = ['title', 'typenote','textnote','active','color'];


    public function userget(){
        return $this->belongsTo('App\User');
    }
}
