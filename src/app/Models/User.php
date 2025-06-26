<?php

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
