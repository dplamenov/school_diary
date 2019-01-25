<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TeacherController
{
    public function listOfClass(Request $request, $class_id)
    {
        $teacher_id = $request->session()->get('user_data')['id'];
        if ($request->session()->get('islogged') !== true or $request->session()->get('user_data')['type'] != 'Teacher') {
            return redirect()->route('home');
        }
        $class_model = new Classes();
        if (!$class_model->classExistsById($class_id)) {
            return redirect()->route('home');
        }

        $subjects = [];
        $result = DB::select('SELECT * FROM `teacher_classes` WHERE `teacher_id` = ? and class_id = ?', [$teacher_id, $class_id]);
        for ($i = 0; $i <= count($result) - 1; $i++) {
            $subject = DB::select('SELECT * FROM `subjects` WHERE subject_id = ?', [$result[$i]->subject_id]);
            $subjects[] = $subject[0]->subject_name;
        }
        return view('teacher_class', ['title' => 'Class ID :' . $class_id, 'subjects' => $subjects]);

    }
}