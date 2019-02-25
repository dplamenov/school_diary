<?php

namespace App\Http\Controllers\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

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

    public function getClassNameById(int $id)
    {
        if ($this->classExistsById($id)) {
            $r = DB::select('SELECT `class_name` FROM `classes` WHERE `class_id` = ?', [$id]);
            return $r[0]->class_name;
        }
        throw new \Exception('Class don`t exists');

    }

    public function getStudentsInClass(int $class_id)
    {
        $students_query = DB::select("SELECT * FROM `students_classes` LEFT JOIN `students` ON students_classes.student_id = students.student_id WHERE students_classes.class_id = ?", [$class_id]);
        foreach ($students_query as $k => $s) {
            $students_query[$k]->grades[] = DB::select('SELECT * FROM `grades` where student_id = ?', [$s->student_id]);
        }

        foreach ($students_query as $key => $value) {
            $average = [];
            $id = $students_query[$key]->student_id;
            $grades = $students_query[$key]->grades;
            foreach ($grades[0] as $k => $grade) {
                $average[] = $grade->grade;
            }
            foreach ($average as $index => $item) {
                $grade_number = DB::select('SELECT * FROM grade WHERE grade_id = ?', [$item])[0]->grade_number;
                $average[$index] = $grade_number;

            }
            if (count($average) == 0) {
                $students_query[$key]->average_grade = 0;
            } else {
                $students_query[$key]->average_grade = array_sum($average) / count($average);
            }

            unset($average);
        }
        foreach ($students_query as $student) {


            $result[] = $student;
            yield $student;
        }
    }


}