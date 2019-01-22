<?php
/**
 * Project: school_diary.
 * File: DirectorController.php
 * Developer: dplamenov@icloud.com
 * Date: 22.1.2019 г.
 * Time: 16:53
 */

namespace App\Http\Controllers;


use App\Http\Controllers\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DirectorController extends Controller
{
    public function addTeacherForm(Request $request)
    {
        $subject = array();
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        $subject = new Subject();
        $subject = $subject->getAllSubject();

        foreach ($subject as $item){
            $subjects[] = $item->subject_name;
        }

        return view('addteacherform', ['subjects' => $subjects]);
    }

    public function addTeacher(Request $request){
        $validate = $this->validate($request,[
            'fullname' => 'min:8',
            'subjects' => 'array'
        ]);
        DB::insert("INSERT INTO `teachers` (`teacher_id`, `teacher_name`) VALUES (NULL, ?)",[$validate['fullname']]);
        $last_id= DB::select('SELECT * FROM `teachers` WHERE `teacher_name` = ?',[$validate['fullname']])[0]->teacher_id;


    }
}