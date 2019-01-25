<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Models\Classes;
use Illuminate\Http\Request;

class TeacherController
{
    public function listOfClass(Request $request, $class_id)
    {
        if ($request->session()->get('islogged') !== true or $request->session()->get('user_data')['type'] != 'Teacher') {
            return redirect()->route('home');
        }
        $class_model = new Classes();
        if (!$class_model->classExistsById($class_id)) {
            return redirect()->route('home');
        }
    }
}