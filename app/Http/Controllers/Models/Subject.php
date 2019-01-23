<?php


namespace App\Http\Controllers\Models;

use Illuminate\Support\Facades\DB;

class Subject
{
    public function getAllSubject()
    {
        $subject = DB::select('SELECT * FROM `subjects`');
        foreach ($subject as $item) {
            yield $item;
        }
    }

    public function getSubjectByTeacherId(int $teacher_id)
    {
        $r = DB::select("SELECT * FROM teachers LEFT JOIN teacher_subject ON teachers.teacher_id = teacher_subject.teacher_id LEFT JOIN subjects ON teacher_subject.subject_id = subjects.subject_id WHERE teachers.teacher_id = ?", [$teacher_id]);
        foreach ($r as $value){
            $r[] = $value->subject_name;
        }
        foreach ($r as $key => $value){
            if($r[$key] instanceof \stdClass){
                unset($r[$key]);
            }

        }
        $r = array_values($r);

        //echo '<pre>' . print_r($r, true) . '</pre>';

        return $r;
    }
}