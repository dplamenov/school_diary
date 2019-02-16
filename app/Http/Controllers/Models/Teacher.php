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
        $r = DB::select('SELECT * FROM students_classes where student_id = ?', [$student]);
        if(count($r) == 0){
            return false;
        }
        return $r[0]->class_id;
    }

    public function checkTeacherHasPermission($teacher, $student)
    {
        $class_id = $this->getClassIdOfStudents($student);
        if(!$class_id){
            throw new \Exception('No students with this id');
        }
        $r = DB::select('SELECT * FROM classes where class_id = ? and teacher = ?', [$class_id, $teacher]);
        if (count($r) == 1) {
            return true;
        }
        $r = DB::select('SELECT * FROM teacher_classes WHERE class_id = ? and teacher_id = ?', [$class_id, $teacher]);
        if (count($r) > 0) {
            return true;
        }
        throw new \Exception('You don`t have permission to this student');
    }
}