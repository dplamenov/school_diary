<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeacherController
{
    public function listOfClass(Request $request, $id)
    {
        if($request->session()->get('islogged') !== true or $request->session()->get('user_data')['type'] != 'Teacher'){
            return redirect()->route('home');
        }
        var_dump($request->session());
        return $id;
    }
}