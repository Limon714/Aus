<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
 protected $fillable = ['firstname','lastname',	'mobile','email','password','otp'];
 protected $attributes = [
    'otp' => '0'
 ];
}
