<?php

namespace App\Http\Controllers\Models;

use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    protected $table = 'parents';
    protected $primaryKey = 'parent_id';
    public $timestamps = false;

    public function newParent($data){
        $parent = new Parents();
        $parent->parent_name = $data['name'];
        $parent->student_id = $data['student_id'];
        $parent->save();

        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        User::newUser(['username' => $data['username'], 'password' => $password, 'type' => 1, 'email' => $data['email'], 'id' => $parent->parent_id]);

    }

}
