<?php

namespace App\Http\Controllers;


class StudentController
{
    private function studentFromTeacher(){
        return view('student_teacher');
    }
}