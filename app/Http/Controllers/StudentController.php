<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Students;
use Illuminate\Http\Request;

class StudentController
{
    public function studentFromTeacher(Request $request, $student_id)
    {
        if ($request->session()->get('islogged') !== true or $request->session()->get('user_data')['type'] != 'Teacher') {
            return redirect()->route('home');
        }
        $student_model = new Students();
        $student = $student_model->getStudentById($student_id);
        return view('student_teacher', ['student' => $student]);
    }
}