<?php

namespace App\Http\Controllers\Models;


use Illuminate\Support\Facades\DB;

class Classes
{
    public function getAllClasses()
    {
        $r = DB::select('SELECT * FROM `classes` left join `teachers` on classes.teacher = teachers.teacher_id');
        foreach ($r as $element) {
            yield $element;
        }
    }

    public function classExists(string $name)
    {
        $r = DB::select('SELECT COUNT(*) as count FROM `classes` WHERE `class_name` = ?', [$name])[0]->count;
        return (boolean)$r;
    }
}