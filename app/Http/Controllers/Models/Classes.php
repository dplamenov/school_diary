<?php

namespace App\Http\Controllers\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Classes extends Model
{
    protected $primaryKey = 'class_id';
    public $timestamps = false;

    public function getAllClasses()
    {
        $r = DB::select('SELECT * FROM `classes` left join `teachers` on classes.teacher = teachers.teacher_id');
        foreach ($r as $element) {
            yield $element;
        }
    }

    public function classExists(string $name)
    {
        $name = "'$name'";
        $r = DB::select('SELECT COUNT(*) as count FROM `classes` WHERE `class_name` = ' . $name);
        return (boolean)$r[0]->count;
    }

    public function classExistsById(int $id)
    {
        $r = DB::select('SELECT COUNT(*) as count FROM `classes` WHERE `class_id` = ?', [$id]);
        return (boolean)$r[0]->count;
    }

    public function getClassNameById(int $id){
        $r = DB::select('SELECT `class_name` FROM `classes` WHERE `class_id` = ?', [$id]);
        return $r[0]->class_name;
    }

    public function getStudentsInClass(int $class_id){
        $students_query = DB::select("SELECT * FROM `students_classes` LEFT JOIN `students` ON students_classes.student_id = students.student_id WHERE students_classes.class_id = ?", [$class_id]);
    }


}