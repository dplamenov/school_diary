<?php
/**
 * Project: school_diary.
 * File: DirectorController.php
 * Developer: dplamenov@icloud.com
 * Date: 22.1.2019 г.
 * Time: 16:53
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class DirectorController extends Controller
{
    public function addTeacherForm(Request $request){
        if($request->session()->get('user_data')['type'] != 'director'){
            return redirect()->route('home');
        }
        return view('addteacherform');
    }
}