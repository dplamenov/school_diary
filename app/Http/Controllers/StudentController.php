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
        return view('student_teacher');
    }
}