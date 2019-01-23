<?php

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

        foreach ($subject as $item) {
            $subjects[] = $item->subject_name;
        }

        return view('addteacherform', ['subjects' => $subjects]);
    }

    public function addTeacher(Request $request)
    {
        $validate = $this->validate($request, [
            'fullname' => 'min:8',
            'subjects' => 'array'
        ]);

        DB::insert("INSERT INTO `teachers` (`teacher_id`, `teacher_name`) VALUES (NULL, ?)", [$validate['fullname']]);
        $last_id = DB::select('SELECT * FROM `teachers` WHERE `teacher_name` = ?', [$validate['fullname']])[0]->teacher_id;
        foreach ($validate['subjects'] as $subject) {
            DB::insert("INSERT INTO `teacher_subject` (`teacher_id`, `subject_id`) VALUES (?, ?)", [$last_id, $subject + 1]);
        }

        return redirect(url('/'));

    }

    public function addSubjectForm(Request $request)
    {
        if ($request->session()->get('user_data')['type'] != 'director') {
            return redirect()->route('home');
        }
        return view('addsubjectform');
    }

    public function addSubject(Request $request)
    {
        $validate = $this->validate($request, [
            'subject' => 'unique:subjects,subject_name|required'
        ], [
            'subject.unique' => 'Subject already created'
        ]);

        DB::insert('INSERT INTO `subjects` (`subject_name`) VALUES (?)', [$validate['subject']]);

        return redirect(url('/'));
    }
}