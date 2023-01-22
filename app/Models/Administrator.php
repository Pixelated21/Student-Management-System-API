<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Administrator extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'password',
        'login_time',
        'logout_time',
    ];

    public function userLoggedIn(bool $isLoggedIn)
    {
        if($isLoggedIn){
            $this->login_time = now();
            $this->logout_time = null;
        }
        else{
            $this->logout_time = now();
        }

        $this->save();
    }
}
