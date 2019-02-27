<?php


namespace App\Http\Controllers\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subject extends Model
{
    protected $table = 'subjects';
    protected $primaryKey = 'subject_id';
    public $timestamps = false;

    public function getAllSubject()
    {
        $r = [];
        $subject = DB::select('SELECT * FROM `subjects`');
        foreach ($subject as $key => $item) {
            $r[$key] = $item;
        }

        return $r;
    }

    public function getSubjectByTeacherId(int $teacher_id)
    {
        $r = DB::select("SELECT * FROM teachers LEFT JOIN teacher_subject ON teachers.teacher_id = teacher_subject.teacher_id LEFT JOIN subjects ON teacher_subject.subject_id = subjects.subject_id WHERE teachers.teacher_id = ?", [$teacher_id]);
        foreach ($r as $value) {
            $r[] = $value->subject_name;
        }
        foreach ($r as $key => $value) {
            if ($r[$key] instanceof \stdClass) {
                unset($r[$key]);
            }
        }
        $r = array_values($r);

        return $r;
    }
}