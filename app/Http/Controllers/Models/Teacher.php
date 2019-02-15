<?php

namespace App\Http\Controllers\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Teacher extends Model
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

    public function getClassIdOfStudents($student)
    {
        return DB::select('SELECT * FROM students_classes where student_id = ?', [$student])[0]->class_id;
    }

    public function checkTeacherHasPermission($teacher, $student)
    {
        echo 'Teacher ' . $teacher . '<br>Student ' . $student;
        $class_id = $this->getClassIdOfStudents($student);
        $r = DB::select('SELECT * FROM classes where class_id = ? and teacher = ?', [$class_id, $teacher]);
        if(count($r) == 1){
            return true;
        }

    }
}