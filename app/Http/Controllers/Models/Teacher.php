<?php

namespace App\Http\Controllers\Models;


use Illuminate\Support\Facades\DB;

class Teacher
{
    public function getAllTeacher(){
        $r = DB::select('SELECT * FROM `teachers`');
        foreach ($r as $item){
            yield $item;
        }
    }
}