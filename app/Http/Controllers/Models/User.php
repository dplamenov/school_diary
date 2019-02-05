<?php

namespace App\Http\Controllers\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    public function getUserTypes(): array
    {
        return ['Teacher', 'Parent', 'Student'];
    }

    public static function newUser($data)
    {
        $user = new User();
        $user->username = $data['username'];
        $user->password = $data['password'];
        $user->type = $data['type'];
        $user->email = $data['email'];
        $user->id = $data['id'];
        $user->save();
    }

    public function login(){

    }
}