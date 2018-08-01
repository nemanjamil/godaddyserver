<?php

namespace App;

use App\Notes;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;



    public function notes(){
        return $this->hasMany('App\Notes');
    }

    public function notestype($typenote){
        return $this->hasMany('App\Notes')
            ->where('typenote', $typenote)
            ->where('active', 1);
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
