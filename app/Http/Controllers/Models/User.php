<?php

namespace App\Http\Controllers\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function getUserTypes() : array
    {
        return ['Teacher', 'Parent', 'Student'];
    }

    public function newUser($data){
        $user = new User();

    }
}