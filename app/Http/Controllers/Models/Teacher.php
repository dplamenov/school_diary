<?php

namespace App\Http\Controllers\Models;


use Illuminate\Support\Facades\DB;

class Teacher
{
    public function getAllTeacher()
    {
        $r = DB::select('SELECT * FROM `teachers`');
        foreach ($r as $item) {
            yield $item;
        }
    }

    public function getAllTeacherBySubjectId(int $id)
    {
        $result = [];
        $r = DB::select('SELECT * FROM `teacher_subject` LEFT JOIN `teachers` ON teacher_subject.teacher_id = teachers.teacher_id LEFT JOIN `subjects` ON teacher_subject.subject_id = subjects.subject_id WHERE teacher_subject.subject_id = ?', [$id]);
        foreach ($r as $item) {
            $result[] = $item;
        }
        return $result;
    }

    public function teacherExists(string $name)
    {
        $r = DB::select('SELECT COUNT(*) as count FROM `teachers` WHERE `teacher_name` = ?', [$name])[0]->count;
        return (boolean)$r;
    }
}