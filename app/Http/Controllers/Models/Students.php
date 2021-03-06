<?php

namespace App\Http\Controllers\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $table = 'students';
    protected $primaryKey = 'student_id';
    public $timestamps = false;

    public function studentExist(int $id)
    {
        $result = Students::where('student_id', $id)->get();
        if (count($result) > 0) {
            return true;
        }
        return false;
    }

    public function getStudentById(int $id)
    {
        $result = Students::where('student_id', $id)->first();
        return $result;
    }


}
