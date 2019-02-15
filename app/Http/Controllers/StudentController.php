<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Students;
use App\Http\Controllers\Models\Teacher;
use Illuminate\Http\Request;

class StudentController
{
    public function studentFromTeacher(Request $request, $student_id)
    {

        if ($request->session()->get('islogged') !== true or $request->session()->get('user_data')['type'] != 'Teacher') {
            return redirect()->route('home');
        }
        $teacher_id = $request->session()->get('user_data')['tid'];
        $student_model = new Students();
        $teacher_model = new Teacher();

        if($teacher_model->checkTeacherHasPermission($teacher_id, $student_id)){
            $student = $student_model->getStudentById($student_id);
            return view('student_teacher', ['student' => $student]);
        }


    }
}